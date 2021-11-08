<?php
require_once("../../config.php");

variables_form_busqueda("listado_redes");

$fecha_hoy=date("Y-m-d H:i:s");
$fecha_hoy=fecha($fecha_hoy);

if ($cmd == "")  $cmd="todos";

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
		"12" => "infarto",
		"13" => "acv",
		"14" => "hta",
		"15" => "estatinas",
       );
$filtro = array(
		"numero_doc" => "DNI",
        "apellido_benef" => "Apellido",
        "nombre_benef" => "Nombre",
		"nombreefector" => "Efector"		
       );
$datos_barra = array(
		 array(
			"descripcion"=> "Diabeticos",
			"cmd"        => "diabetes"
		 ),
		 array(
			"descripcion"=> "Hipertensos",
			"cmd"        => "hta"
		 ),
		 array(
			"descripcion"=> "Fumadores",
			"cmd"        => "fumador"
		 ),
		 array(
			"descripcion"=> "Infartados",
			"cmd"        => "infarto"
		 ),
		 		 array(
			"descripcion"=> "Con ACV",
			"cmd"        => "acv"
		 ),
		 array(
			"descripcion"=> "Usan Estatinas",
			"cmd"        => "estatinas"
		 ),
		 array(
			"descripcion"=> "Todos",
			"cmd"        => "todos"
		 )
	);

$sql_tmp="SELECT b.numero_doc DNI, b.apellido_benef Apellido, b.nombre_benef Nombre, b.fecha_nacimiento_benef Nacimiento, 
b.localidad Localidad, b.cuie_ea CUIE, e.nombreefector Efector, b.fecha_inscripcion Inscripcion, b.fecha_carga Carga, 
b.fumador, b.diabetes, b.infarto, b.acv, b.hta, b.estatinas
FROM uad.beneficiarios b INNER JOIN nacer.efe_conv e ON b.cuie_ea = e.cuie";

$where_tmp=" (fumador != '' OR diabetes != '' OR infarto != '' OR acv != '' OR hta != '' OR estatinas != '')";

if ($cmd=="diabetes") $where_tmp .= " AND ( diabetes = 'S')";
if ($cmd=="fumador") $where_tmp .= " AND ( fumador = 'S')";
if ($cmd=="infarto") $where_tmp .= " AND ( infarto = 'S')";
if ($cmd=="acv") $where_tmp .= " AND ( acv = 'S')";
if ($cmd=="hta") $where_tmp .= " AND ( hta = 'S')";
if ($cmd=="estatinas") $where_tmp .= " AND ( estatinas = 'S')";

echo $html_header;
?>

<div class="newstyle-full-container">

	<?
		// SUBMENU
		generar_barra_nav($datos_barra);
	?>
	
	<form name=form1 action="listado_redes.php" method=POST>
		<div class="row-fluid">
			<div class="span8">
				<?list($sql,$total_muletos,$link_pagina,$up) = form_busqueda($sql_tmp,$orden,$filtro,$link_tmp,$where_tmp,"buscar");?>
				<input class="btn" type=submit name="buscar" value='Buscar'>
			</div>
			<div class="span4">
				<? $link=encode_link("listado_redes_excel.php",array());?>
				<a href="#" class="pull-right" onclick="window.open('<?=$link?>')"><i class="icon-share-alt"></i> Exportar Excel</a>
			</div>
		</div>
		
		<?
			$result = sql($sql) or die;
			//echo json_encode($sql);
			//echo json_encode($result);
		?>

		<div class="pull-right paginador">	
			<?=$total_muletos?> beneficiarios encontrados.  
			<?=$link_pagina?>
		</div> 

		<table class="table table-condensed table-bordered table-hover">
			<thead>
				<tr>
					<th><a id=mo href='<?=encode_link("listado_redes.php",array("sort"=>"1","up"=>$up))?>'>DNI</a></th>      	
					<th><a id=mo href='<?=encode_link("listado_redes.php",array("sort"=>"2","up"=>$up))?>'>Apellido</a></th>
					<th><a id=mo href='<?=encode_link("listado_redes.php",array("sort"=>"3","up"=>$up))?>'>Nombre</a></th>
					<th><a id=mo href='<?=encode_link("listado_redes.php",array("sort"=>"4","up"=>$up))?>'>Nacimiento</a></th>
					<th><a id=mo href='<?=encode_link("listado_redes.php",array("sort"=>"5","up"=>$up))?>'>Localidad</a></th>
					<th><a id=mo href='<?=encode_link("listado_redes.php",array("sort"=>"6","up"=>$up))?>'>CUIE</a></th>
					<th><a id=mo href='<?=encode_link("listado_redes.php",array("sort"=>"7","up"=>$up))?>'>Efector</a></th>
					<th><a id=mo href='<?=encode_link("listado_redes.php",array("sort"=>"8","up"=>$up))?>'>Inscripción</a></th>
					<th><a id=mo href='<?=encode_link("listado_redes.php",array("sort"=>"9","up"=>$up))?>'>Carga</a></th>
					<th><a id=mo href='<?=encode_link("listado_redes.php",array("sort"=>"10","up"=>$up))?>'>Fumador</a></th>      	
					<th><a id=mo href='<?=encode_link("listado_redes.php",array("sort"=>"11","up"=>$up))?>'>Diabetes</a></th>
					<th><a id=mo href='<?=encode_link("listado_redes.php",array("sort"=>"12","up"=>$up))?>'>Infarto</a></th>
					<th><a id=mo href='<?=encode_link("listado_redes.php",array("sort"=>"13","up"=>$up))?>'>ACV</a></th>
					<th><a id=mo href='<?=encode_link("listado_redes.php",array("sort"=>"14","up"=>$up))?>'>HTA</a></th>
					<th><a id=mo href='<?=encode_link("listado_redes.php",array("sort"=>"15","up"=>$up))?>'>Estatinas</a></th>				
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
						<td><?=$result->fields['infarto']?></td> 
						<td><?=$result->fields['acv']?></td> 
						<td><?=$result->fields['hta']?></td> 
						<td><?=$result->fields['estatinas']?></td> 
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