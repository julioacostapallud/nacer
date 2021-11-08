<?php
	try
	{
		$str = "O' Higgins";
		$slashes = addslashes($str);
		echo $str;
		echo $slashes;
	}
	catch (Exception $e)
	{
		echo $e->getMessage() . “/n”;
	}
	if ($flag != 1) 
	{
		echo 'Se han comprobado las personas correctamente';
	}

?>