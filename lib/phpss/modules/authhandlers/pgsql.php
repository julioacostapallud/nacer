<?php

/*
 * phpSecureSite
 *
 * modules/authhandlers/pgsql.php
 *
 * PostgreSQL authentication backend. Allows for authentication
 * where account data is stored in a PostgreSQL database.
 *
 *
 * Copyright (C) 2002-2003 Erik Grinaker
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
*/

// NOTE: This module should only be used for accessing account data in
// a different database (possible on another server) than the normal
// phpSecureSite database. Normally you should really use the database
// authentication handler instead.

// register authhandler
phpss_module_register("pgsql", PHPSS_MODULE_TYPE_AUTHHANDLER);

// register login handler
phpss_handler_register(PHPSS_HANDLER_TYPE_AUTH_LOGIN, "phpss_authhandler_pgsql_login");
phpss_handler_register(PHPSS_HANDLER_TYPE_AUTH_ACCOUNTDATA, "phpss_authhandler_pgsql_get_account_data");
phpss_handler_register(PHPSS_HANDLER_TYPE_AUTH_ACCOUNTGROUPS, "phpss_authhandler_pgsql_get_account_groups");
phpss_handler_register(PHPSS_HANDLER_TYPE_AUTH_ACCOUNTID, "phpss_authhandler_pgsql_get_account_id");
phpss_handler_register(PHPSS_HANDLER_TYPE_AUTH_GROUPDATA, "phpss_authhandler_pgsql_get_group_data");
phpss_handler_register(PHPSS_HANDLER_TYPE_AUTH_GROUPID, "phpss_authhandler_pgsql_get_group_id");

// int phpss_authhandler_pgsql_login(str username, str password)
// attempts to authenticate the user against the PostgreSQL database
function phpss_authhandler_pgsql_login($username, $password) {
	phpss_module_config_get("pgsql", PHPSS_MODULE_TYPE_AUTHHANDLER);

	// set up password type
	switch($cfg[pwtype]) {
		case "md5": $sqlpw = "'" . md5($password) . "'"; break;
		case "plaintext": $sqlpw = "'" . $password . "'"; break;
		default: phpss_error("Invalid pwtype for auth handler");
	}

	// authenticate user
	$query = "	SELECT
				" . $cfg["col_account_id"] . "
			FROM
				" . $cfg["tab_account"] . "
			WHERE
				LOWER(" . $cfg["col_account_username"] . ") = '" . strtolower($username) . "'
				AND " . $cfg["col_account_password"] . " = " . $sqlpw . "'
				AND " . $cfg["col_account_active"] . " = 't'";
	$res = phpss_authhandler_pgsql_dbquery($query);
	
	return (sizeof($res) == 1 ? $res[0][0] : false);
}

// void phpss_authhandler_pgsql_dbclose(res link)
// closes a database connection
function phpss_authhandler_pgsql_dbclose($link) {
		@pg_close($link);
}

// res phpss_authhandler_pgsql_dbinit()
// sets up a database connection
function phpss_authhandler_pgsql_dbinit() {
	phpss_module_config_get("pgsql", PHPSS_MODULE_TYPE_AUTHHANDLER);

	// connect to database server
	if (($link = @pg_connect("host=" . $cfg["hostname"] . " port=" . $cfg["port"] . " dbname=" . $cfg["database"] . " user=" . $cfg["username"] . " password=" . $cfg["password"])) == false)
		phpss_error("Authhandler unable to connect to backend");

	return $link;
}

// arr phpss_authhandler_pgsql_dbquery(str query)
// executes a query
function phpss_authhandler_pgsql_dbquery($query) {
	$link = phpss_authhandler_pgsql_dbinit();
	
	if (($rs = @pg_query($link, $query)) == false)
		phpss_error("An authhandler database query failed : " . $query);

	$data = array();
	for($i = 0; $i < pg_num_rows($rs); $i++)
		$data[] = @pg_fetch_row($rs, $i);

	phpss_authhandler_pgsql_dbclose($link);

	return $data;
}

// arr phpss_authhandler_pgsql_get_account_data(int accountid)
// retrieves account data
function phpss_authhandler_pgsql_get_account_data($accountid) {
	phpss_module_config_get("pgsql", PHPSS_MODULE_TYPE_AUTHHANDLER);

	$query = "	SELECT
				" . $cfg["col_account_id"] . ",
				" . $cfg["col_account_username"] . ",
				" . $cfg["col_account_password"] . ",
				" . $cfg["col_account_active"] . "
			FROM
				" . $cfg["tab_account"] . "
			WHERE
				" . $cfg["col_account_id"] . " = " . $accountid;
	$res = phpss_authhandler_pgsql_dbquery($query);
	
	if (sizeof($res) == 0) {
		$data = false;
	} else {
		$data["id"] = $res[0][0];
		$data["username"] = $res[0][1];
		$data["password"] = $res[0][2];
		$data["active"] = ($res[0][3] == "t" ? true : false);
	}

	return $data;
}

// arr phpss_authhandler_pgsql_get_account_groups(int accountid)
// retrieves the groups an account is a member of
function phpss_authhandler_pgsql_get_account_groups($accountid) {
	phpss_module_config_get("pgsql", PHPSS_MODULE_TYPE_AUTHHANDLER);

	$query = "	SELECT
				" . $cfg["col_account_group_groupid"] . "
			FROM
				" . $cfg["tab_account_group"] . "
			WHERE
				" . $cfg["col_account_group_accountid"] . " = " . $accountid;
	$res = phpss_authhandler_pgsql_dbquery($query);

	$groups = array();
	foreach($res AS $row)
		$groups[] = $row[0];

	return $groups;
}

// int phpss_authhandler_pgsql_get_account_id(str username)
// looks up an account id based on a username
function phpss_authhandler_pgsql_get_account_id($username) {
	phpss_module_config_get("pgsql", PHPSS_MODULE_TYPE_AUTHHANDLER);

	$query = "	SELECT
				" . $cfg["col_account_id"] . "
			FROM
				" . $cfg["tab_account"] . "
			WHERE
				LOWER(" . $cfg["col_account_username"] . ") = '" . strtolower($username) . "'";
	$res = phpss_authhandler_pgsql_dbquery($query);

	return (sizeof($res) > 0 ? $res[0][0] : false);
}

// arr phpss_authhandler_pgsql_get_group_data(int groupid)
// retrieves group data
function phpss_authhandler_pgsql_get_group_data($groupid) {
	phpss_module_config_get("pgsql", PHPSS_MODULE_TYPE_AUTHHANDLER);

	$query = "	SELECT
				" . $cfg["col_group_id"] . ",
				" . $cfg["col_group_name"] . "
			FROM
				" . $cfg["tab_group"] . "
			WHERE
				" . $cfg["col_group_id"] . " = " . $groupid;
	$res = phpss_authhandler_pgsql_dbquery($query);

	if (sizeof($res) == 0) {
		$data = false;
	} else {
		$data["id"] = $res[0][0];
		$data["name"] = $res[0][1];
	}

	return $data;
}

// int phpss_authhandler_pgsql_get_group_id(str groupname)
// looks up the id of a group from its name
function phpss_authhandler_pgsql_get_group_id($groupname) {
	phpss_module_config_get("pgsql", PHPSS_MODULE_TYPE_AUTHHANDLER);

	$query = "	SELECT
				" . $cfg["col_group_id"] . "
			FROM
				" . $cfg["tab_group"] . "
			WHERE
				" . $cfg["col_group_name"] . " = '" . $groupname . "'";
	$res = phpss_authhandler_pgsql_dbquery($query);

	return (sizeof($res) > 0 ? $res[0][0] : false);
}

?>
