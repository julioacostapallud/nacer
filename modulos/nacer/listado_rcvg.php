<?php
require_once("../../config.php");

variables_form_busqueda("listado_rcvg");

$fecha_hoy=date("Y-m-d H:i:s");
$fecha_hoy=fecha($fecha_hoy);

if ($cmd == "")  $cmd="nominalizada";

$orden = array(
        "default" => "1",
        "1" => "numero_doc",
        "2" => "apellido_benef",
        "3" => "nombre_benef",
        "4" => "fecha_nacimiento_benef",
        "5" => "localidad",
        "6" => "cuie_ea",
		"7" => "nombreefector",
        "8" => "fecha_inscripcion",
		"9" => "fecha_carga",
		"10" => "fumador",
		"11" => "diabetes",
		"12" => "hta",
		"13" => "score_riesgo",
		"14" => "sexo",
       );
$filtro = array(
		"numero_doc" => "DNI",
        "apellido_benef" => "Apellido",
        "nombre_benef" => "Nombre",
		"nombreefector" => "Efector",
		"sexo" => "Sexo"
       );
$datos_barra = array(
		 array(
			"descripcion"=> "Nominalizada",
			"cmd"        => "nominalizada"
		 ),
		 array(
			"descripcion"=> "Clasificada",
			"cmd"        => "clasificada"
		 ),
		 array(
			"descripcion"=> "RCVG mayor a 10%",
			"cmd"        => "mayor"
		 ),
		 array(
			"descripcion"=> "Mayor a 10 con seguimiento",
			"cmd"        => "seguimiento"
		 ),
		 array(
			"descripcion"=> "Mayor a 10 sin controles",
			"cmd"        => "controles"
		 )
	);

	
	

$sql_tmp="SELECT b.numero_doc DNI, b.apellido_benef Apellido, b.nombre_benef Nombre, b.fecha_nacimiento_benef Nacimiento, 
b.localidad Localidad, b.cuie_ea CUIE, e.nombreefector Efector, b.fecha_inscripcion Inscripcion, b.fecha_carga Carga, 
b.fumador, b.diabetes, b.hta, b.score_riesgo, b.sexo
FROM uad.beneficiarios b INNER JOIN nacer.efe_conv e ON b.cuie_ea = e.cuie";

$where_tmp=" ( current_date-b.fecha_nacimiento_benef) > 14600";


if ($cmd=="nominalizada") $where_tmp .= " ";
if ($cmd=="clasificada") $where_tmp .= " AND ((score_riesgo<>'') AND (score_riesgo<>'0'))";
if ($cmd=="mayor") $where_tmp .= " AND ((score_riesgo ='3') OR (score_riesgo='4') OR (score_riesgo='5'))";
if ($cmd=="seguimiento") $where_tmp .= " AND ((score_riesgo ='3') OR (score_riesgo='4') OR (score_riesgo='5'))";
if ($cmd=="controles") $where_tmp .= " AND ((score_riesgo ='3') OR (score_riesgo='4') OR (score_riesgo='5'))";

echo $html_header;
?>

<div class="newstyle-full-container">

	<?
		// SUBMENU
		generar_barra_nav($datos_barra);
	?>
	
	<form name=form1 action="listado_rcvg.php" method=POST>
		<div class="row-fluid">
			<div class="span8">
				<?list($sql,$total_muletos,$link_pagina,$up) = form_busqueda($sql_tmp,$orden,$filtro,$link_tmp,$where_tmp,"buscar");?>
				<input class="btn" type=submit name="buscar" value='Buscar'>
			</div>
			<div class="span4">
				<? $link=encode_link("listado_rcvg_excel.php",array());?>
				<a href="#" class="pull-right" onclick="window.open('<?=$link?>')"><i class="icon-share-alt"></i> Exportar Excel</a>
			</div>
		</div>
		
		<?
			$result = sql($sql) or die;
		?>

		<div class="pull-right paginador">	
			<?=$total_muletos?> beneficiarios encontrados.  
			<?=$link_pagina?>
		</div> 

		<table class="table table-condensed table-bordered table-hover">
			<thead>
				<tr>
					<th><a id=mo href='<?=encode_link("listado_rcvg.php",array("sort"=>"1","up"=>$up))?>'>DNI</a></th>      	
					<th><a id=mo href='<?=encode_link("listado_rcvg.php",array("sort"=>"2","up"=>$up))?>'>Apellido</a></th>
					<th><a id=mo href='<?=encode_link("listado_rcvg.php",array("sort"=>"3","up"=>$up))?>'>Nombre</a></th>
					<th><a id=mo href='<?=encode_link("listado_rcvg.php",array("sort"=>"4","up"=>$up))?>'>Nacimiento</a></th>
					<th><a id=mo href='<?=encode_link("listado_rcvg.php",array("sort"=>"5","up"=>$up))?>'>Localidad</a></th>
					<th><a id=mo href='<?=encode_link("listado_rcvg.php",array("sort"=>"6","up"=>$up))?>'>CUIE</a></th>
					<th><a id=mo href='<?=encode_link("listado_rcvg.php",array("sort"=>"7","up"=>$up))?>'>Efector</a></th>
					<th><a id=mo href='<?=encode_link("listado_rcvg.php",array("sort"=>"8","up"=>$up))?>'>Inscripción</a></th>
					<th><a id=mo href='<?=encode_link("listado_rcvg.php",array("sort"=>"9","up"=>$up))?>'>Carga</a></th>
					<th><a id=mo href='<?=encode_link("listado_rcvg.php",array("sort"=>"10","up"=>$up))?>'>Fumador</a></th>
					<th><a id=mo href='<?=encode_link("listado_rcvg.php",array("sort"=>"11","up"=>$up))?>'>Diabetes</a></th>
					<th><a id=mo href='<?=encode_link("listado_rcvg.php",array("sort"=>"12","up"=>$up))?>'>Tension Arterial</a></th>
					<th><a id=mo href='<?=encode_link("listado_rcvg.php",array("sort"=>"13","up"=>$up))?>'>RCVG</a></th>
					<th><a id=mo href='<?=encode_link("listado_rcvg.php",array("sort"=>"14","up"=>$up))?>'>Sexo</a></th>
				</tr>
			</thead>
			<tbody>
			<?
				while (!$result->EOF) {
			?>
					<tr>        
						<td><?=$result->fields['dni']?></td>
						<td><?=$result->fields['apellido']?></td>
						<td><?=$result->fields['nombre']?></td> 
						<td><?=fecha($result->fields['nacimiento'])?></td>
						<td><?=$result->fields['localidad']?></td>
						<td><?=$result->fields['cuie']?></td>						
						<td><?=$result->fields['efector']?></td>
						<td><?=fecha($result->fields['inscripcion'])?></td>
						<td><?=fecha($result->fields['carga'])?></td>	
					    <td><?=$result->fields['fumador']?></td>	
					    <td><?=$result->fields['diabetes']?></td>	
						<td><?=$result->fields['hta']?></td>	
	                    <td><?=$result->fields['score_riesgo']?></td>								
						<td><?=$result->fields['sexo']?></td>	
					</tr>
			<?
					$result->MoveNext();
				}
			?>
			</tbody>
		</table>
	</form>
</div>

</body>
</html>