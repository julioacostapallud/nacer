<?php
/*
	nombre_benef || ' ' || apellido_benef ilike '%jose%luis%fernandez%'
	or apellido_benef || ' ' || nombre_benef ilike '%jose%luis%fernandez%'
*/
require_once "config.php";

if(!empty($_POST)) {
	if(!empty($_POST["dni"])) {
		$dni = $_POST["dni"];
		$sql= "Select clave_beneficiario clave, id_categoria categoria, apellido_benef || ' ' || nombre_benef apynom, 
		clase_documento_benef clasedoc, tipo_documento tipodoc, numero_doc dni, localidad, cuie_ea cuie,
		fecha_probable_parto fpp, fecha_efectiva_parto fep, fecha_nacimiento_benef fechanac, fecha_inscripcion fechains
		from uad.beneficiarios 
		where estado_envio = 'n'
		and numero_doc = '$dni'";
	}
}

if(!empty($_GET)) {
	$insQueryString = "	SELECT
								clave_beneficiario ClaveBeneficiario, 
								id_categoria Categoria, 
								apellido_benef || ' ' || nombre_benef NombreyApellido, 
								clase_documento_benef ClaseDocumento, 
								tipo_documento TipoDocumento, 
								numero_doc Dni,
								sexo Sexo,
								localidad Localidad, 
								cuie_ea Cuie,
								fecha_probable_parto Fpp, 
								fecha_efectiva_parto Fep, 
								fecha_nacimiento_benef FechaNacimiento, 
								fecha_inscripcion FechaInscripcion,
								activo Activo
						FROM uad.beneficiarios";

	if(!empty($_GET["dni"])) {
		$dni = $_GET["dni"];
		$sql = $insQueryString . " WHERE numero_doc ILIKE '$dni%' ";

	} elseif (!empty($_GET["nombre"])) {
		$nombre = $_GET["nombre"];
		$sql = $insQueryString . " WHERE (apellido_benef ILIKE '%$nombre%' or nombre_benef ILIKE '%$nombre%') ";
	} elseif (!empty($_GET["clave"])) {
		$clave = $_GET["clave"];
		$sql = $insQueryString . " WHERE clave_beneficiario = '$clave'";
	} else {
		$sql = $insQueryString;
	}
	
	$sql = $sql.
	" --AND (
		--(date_part('year', age(fecha_nacimiento_benef + interval '1 month')) < 20 AND sexo = 'M')
		--OR
		--(sexo = 'F')
	--)  
	 LIMIT 20";
}

$result=pg_exec($sql);

while ($row = pg_fetch_object($result)) {$arr[] = $row;}


echo json_encode($arr);
?>
