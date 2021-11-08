<?php
require_once "config.php";

if(!empty($_GET)) {
	$sexo = $_GET["sexo"];
	$diabetes = $_GET["diabetes"];
	$fumador = $_GET["fumador"];
	$hta = $_GET["hta"];
	$edad = $_GET["edad"];
	$sql= "SELECT uad.calcularScoreRiesgo('$sexo', '$diabetes', '$fumador', '$hta' , '$edad')";
}
	
$result=pg_exec($sql);

while ($row = pg_fetch_object($result)) {$arr[] = $row;}
	
echo json_encode($arr);
?>
