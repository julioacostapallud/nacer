<?php

require_once("../../config.php");

variables_form_busqueda("errores_FechaEmb");

$fecha_hoy=date("Y-m-d H:i:s");
$fecha_hoy=fecha($fecha_hoy);

if ($cmd == "")  $cmd="activos";

$orden = array(
        "default" => "1",
		"1" => "clave_beneficiario",  
		"2" => "numero_doc",  
        "3" => "apellido_benef",
        "4" => "nombre_benef",
        "5" => "fecha_nacimiento_benef",      
        "6" => "fecha_inscripcion",         
		"7" => "activo",
		"8" => "cuie_ea",
		"9" => "nombreefector",
       );
$filtro = array(
		"numero_doc" => "DNI",
        "apellido_benef" => "Apellido",
        "nombre_benef" => "Nombre",          
		"cuie_ea" => "Código",
       );

$sql_tmp="SELECT * FROM uad.beneficiarios b, nacer.efe_conv e";
$where_tmp="b.cuie_ea = e.cuie
AND sexo='F' AND (
fecha_diagnostico_embarazo > current_date
OR fum > current_date
OR (fecha_diagnostico_embarazo <= date '1900-01-01' and menor_embarazada='S')
OR (fum <= date '1900-01-01' and menor_embarazada='S')
OR  ((DATE_PART('month', fum) - DATE_PART('month', fecha_probable_parto))>9 and menor_embarazada='S')
OR (TRUNC(DATE_PART('day', fecha_diagnostico_embarazo::timestamp - fum::timestamp)/7)<3 AND  menor_embarazada='S')
)";

echo $html_header;
?>

<div class="newstyle-full-container">
<form name=form1 action="errores_FechaEmb.php" method=POST>

	<div class="row-fluid">
		<div class="span8">
			<?list($sql,$total_muletos,$link_pagina,$up) = form_busqueda($sql_tmp,$orden,$filtro,$link_tmp,$where_tmp,"buscar");?>
			<input class='btn' type='submit' name="buscar" value='Buscar'>
		</div>
		<div class="span4">
			<? $link=encode_link("errores_FechaEmb_excel.php",array());?>
			<a href="#" class="pull-right" onclick="window.open('<?=$link?>')"><i class="icon-share-alt"></i> Exportar Excel</a>
		</div>
	</div>

<?$result = sql($sql) or die;?>

<div class="pull-right paginador">
	<?=$total_muletos?> Errores en fecha de embarazo encontrados. 
	<?=$link_pagina?>
</div> 

<table class="table table-condensed table-hover table-striped">
		
	<thead>
		<tr>
			<th><a id=mo href='<?=encode_link("errores_FechaEmb.php",array("sort"=>"1","up"=>$up))?>'>Clave</a></th>
			<th><a id=mo href='<?=encode_link("errores_FechaEmb.php",array("sort"=>"2","up"=>$up))?>'>DNI</a></th>
			<th><a id=mo href='<?=encode_link("errores_FechaEmb.php",array("sort"=>"3","up"=>$up))?>'>Apellido</a></th>
			<th><a id=mo href='<?=encode_link("errores_FechaEmb.php",array("sort"=>"4","up"=>$up))?>'>Nombre</a></th>
			<th><a id=mo href='<?=encode_link("errores_FechaEmb.php",array("sort"=>"5","up"=>$up))?>'>Nacimiento</a></th>
			<th><a id=mo href='<?=encode_link("errores_FechaEmb.php",array("sort"=>"6","up"=>$up))?>'>Inscripción</a></th> 				
			<th><a id=mo href='<?=encode_link("errores_FechaEmb.php",array("sort"=>"7","up"=>$up))?>'>Activo</a></th> 							
			<th><a id=mo href='<?=encode_link("errores_FechaEmb.php",array("sort"=>"8","up"=>$up))?>'>Código</a></th> 				
			<th><a id=mo href='<?=encode_link("errores_FechaEmb.php",array("sort"=>"9","up"=>$up))?>'>Efector</a></th> 							
		</tr>
	</thead>

 <?
   while (!$result->EOF) {
   		$ref = encode_link("../inscripcion/ins_admin.php",array("id_planilla"=>$result->fields['id_beneficiarios']));
		$onclick_elegir="location.href='$ref'";
		?>
  
    <tr class="manito">
		 <td onclick="<?=$onclick_elegir?>"><?=$result->fields['clave_beneficiario']?></td> 	
		 <td onclick="<?=$onclick_elegir?>"><?=$result->fields['numero_doc']?></td> 
		 <td onclick="<?=$onclick_elegir?>"><?=$result->fields['apellido_benef']?></td>     
		 <td onclick="<?=$onclick_elegir?>"><?=$result->fields['nombre_benef']?></td>     
		 <td onclick="<?=$onclick_elegir?>"><?=fecha($result->fields['fecha_nacimiento_benef'])?></td>
		 <td onclick="<?=$onclick_elegir?>"><?=fecha($result->fields['fecha_inscripcion'])?></td>  
		 <td onclick="<?=$onclick_elegir?>"><?=$result->fields['activo']?></td>     
		 <td onclick="<?=$onclick_elegir?>"><?=$result->fields['cuie_ea']?></td> 
		 <td onclick="<?=$onclick_elegir?>"><?=$result->fields['nombreefector']?></td>   
    </tr>
	<?$result->MoveNext();
    }?>
    
</table>
</form>
</div>
</body>
</html>
