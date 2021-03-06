<?php
require_once("gacl_admin.inc.php");

//GET takes precedence.
if ($_GET['group_type'] == '') {
	$group_type = $_POST['group_type'];
} else {
	$group_type = $_GET['group_type'];
}

if ($_GET['return_page'] == '') {
	$return_page = $_POST['return_page'];
} else {
	$return_page = $_GET['return_page'];
}

switch(strtolower(trim($group_type))) {
    case 'axo':
        $group_type = 'axo';
		$group_table = 'axo_groups';
        break;
    default:
        $group_type = 'aro';
        $group_table = 'aro_groups';
        break;
}


switch ($_POST['action']) {
    case 'Borrar':
        $gacl_api->debug_text("Delete");

        if (count($_POST['delete_group']) > 0) {
			//Always reparent children when deleting a group.
			foreach ($_POST['delete_group'] as $group_id) {
				$gacl_api->debug_text("Deleting group_id: $group_id");

				$gacl_api->del_group($group_id, TRUE, $group_type);
			}
        }

        //Return page.
        $gacl_api->return_page($return_page);

        break;
    case 'Enviar':
        $gacl_api->debug_text("Submit");

        if (empty($_POST['parent_id'])) {
            $parent_id = 0;
        } else {
            $parent_id = $_POST['parent_id'];
        }

		//Make sure we're not reparenting to ourself.
		if (!empty($_POST['group_id']) AND $parent_id == $_POST['group_id']) {
			echo "Sorry, can't reparent to self!<br>\n";
			exit;
		}

        //No parent, assume a "root" group, generate a new parent id.
        if (empty($_POST['group_id'])) {
            $gacl_api->debug_text("Insert");

			$insert_id = $gacl_api->add_group($_POST['name'], $parent_id, $group_type);
        } else {
            $gacl_api->debug_text("Update");

			$gacl_api->edit_group($_POST['group_id'], $_POST['name'], $parent_id, $group_type);
        }

        $gacl_api->return_page("$return_page");
        break;
    default:
        //Grab specific group data
        if (!empty($_GET['group_id'])) {
            $query = "select
                                        id,
                                        parent_id,
                                        name
                            from    $group_table
                            where   id = ". (int)$_GET['group_id'];
            $rs = $db->Execute($query);
            $rows = $rs->GetRows();

            list($id, $parent_id, $name) = $rows[0];
            //showarray($name);
        } else {
            $parent_id = $_GET['parent_id'];
        }

        $smarty->assign('id', $id);
        $smarty->assign('parent_id', $parent_id);
        $smarty->assign('name', $name);

        $smarty->assign("options_groups", $gacl_api->format_groups($gacl_api->sort_groups($group_type)) );

        break;
}

$smarty->assign('group_type', $group_type);
$smarty->assign('return_page', $return_page);

$smarty->display('phpgacl/edit_group.tpl');
?>
