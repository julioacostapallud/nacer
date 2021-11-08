<?php
require_once "config.php";

	$insQueryString = "	SELECT
								apellido_benef || ' ' || nombre_benef NombreyApellido, 
								clase_documento_benef ClaseDocumento, 
								tipo_documento TipoDocumento, 
								numero_doc Dni,
								sexo Sexo,
								localidad Localidad, 
								cuie_ea Cuie,
								fecha_nacimiento_benef FechaNacimiento, 
								fecha_inscripcion FechaInscripcion,
								fumador, acv, hta, infarto, diabetes, estatinas
						FROM uad.beneficiarios";

	$sql = $insQueryString;

	$sql = $sql.
	" WHERE  (fumador != '' OR diabetes != '' OR infarto != '' OR acv != '' OR hta != '' OR estatinas != '')";


$result=pg_exec($sql);

while ($row = pg_fetch_object($result)) {$arr[] = $row;}

function build_table($array){
    // start table
    $html = '<table>';
    // header row
    $html .= '<tr>';
    foreach($array[0] as $key=>$value){
            $html .= '<th>' . $key . '</th>';
        }
    $html .= '</tr>';

    // data rows
    foreach( $array as $key=>$value){
        $html .= '<tr>';
        foreach($value as $key2=>$value2){
            $html .= '<td>' . $value2 . '</td>';
        }
        $html .= '</tr>';
    }

    // finish table and return it

    $html .= '</table>';
    return $html;
}

echo build_table($arr);

//echo json_encode($arr);
?>