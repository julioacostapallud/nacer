<?php

require_once("../../config.php");

variables_form_busqueda("errores_DNI");

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

$sql_tmp="SELECT * FROM uad.beneficiarios b,nacer.efe_conv e";
$where_tmp=" b.cuie_ea=e.cuie and   ((numero_doc='') OR (numero_doc is null) OR ( numero_doc  LIKE '%z%') OR (LENGTH(numero_doc)>8) OR (LENGTH(numero_doc)<7)
OR ( numero_doc  LIKE '%A%') OR( numero_doc  LIKE '%F%') OR  ( numero_doc  LIKE '%K%')  OR( numero_doc  LIKE '%P%') OR  ( numero_doc  LIKE '%U%') 
OR ( numero_doc  LIKE '%B%') OR( numero_doc  LIKE '%G%') OR  ( numero_doc  LIKE '%L%')  OR( numero_doc  LIKE '%Q%') OR  ( numero_doc  LIKE '%V%') 
OR ( numero_doc  LIKE '%C%') OR( numero_doc  LIKE '%H%') OR  ( numero_doc  LIKE '%M%')  OR( numero_doc  LIKE '%R%') OR  ( numero_doc  LIKE '%W%') 
OR ( numero_doc  LIKE '%D%') OR( numero_doc  LIKE '%I%') OR  ( numero_doc  LIKE '%N%')  OR( numero_doc  LIKE '%S%') OR  ( numero_doc  LIKE '%X%') 
OR ( numero_doc  LIKE '%E%') OR( numero_doc  LIKE '%J%') OR  ( numero_doc  LIKE '%O%')  OR( numero_doc  LIKE '%T%') OR  ( numero_doc  LIKE '%Y%') 
OR ( numero_doc  LIKE '%Z%') OR( numero_doc  LIKE '%.%') OR  ( numero_doc  LIKE '%,%')  OR( numero_doc  LIKE '%;%') OR  ( numero_doc  LIKE '%:%')
OR ( numero_doc  LIKE '%a%') OR( numero_doc  LIKE '%f%') OR  ( numero_doc  LIKE '%k%')  OR( numero_doc  LIKE '%p%') OR  ( numero_doc  LIKE '%u%') 
OR ( numero_doc  LIKE '%b%') OR( numero_doc  LIKE '%g%') OR  ( numero_doc  LIKE '%l%')  OR( numero_doc  LIKE '%q%') OR  ( numero_doc  LIKE '%v%') 
OR ( numero_doc  LIKE '%c%') OR( numero_doc  LIKE '%h%') OR  ( numero_doc  LIKE '%m%')  OR( numero_doc  LIKE '%r%') OR  ( numero_doc  LIKE '%w%') 
OR ( numero_doc  LIKE '%d%') OR( numero_doc  LIKE '%i%') OR  ( numero_doc  LIKE '%n%')  OR( numero_doc  LIKE '%s%') OR  ( numero_doc  LIKE '%x%') 
OR ( numero_doc  LIKE '%e%') OR( numero_doc  LIKE '%j%') OR  ( numero_doc  LIKE '%o%')  OR( numero_doc  LIKE '%t%') OR  ( numero_doc  LIKE '%y%'))
";
    
echo $html_header;
?>

<div class="newstyle-full-container">
<form name=form1 action="errores_nombreyapellido.php" method=POST>

	<div class="row-fluid">
		<div class="span8">
			<?list($sql,$total_muletos,$link_pagina,$up) = form_busqueda($sql_tmp,$orden,$filtro,$link_tmp,$where_tmp,"buscar");?>
			<input class='btn' type='submit' name="buscar" value='Buscar'>
		</div>
		<div class="span4">
			<? $link=encode_link("errores_DNI_excel.php",array());?>
			<a href="#" class="pull-right" onclick="window.open('<?=$link?>')"><i class="icon-share-alt"></i> Exportar Excel</a>
		</div>
	</div>

<?$result = sql($sql) or die;?>

<div class="pull-right paginador">
	<?=$total_muletos?> Errores de DNI encontrados. 
	<?=$link_pagina?>
</div> 

<table class="table table-condensed table-hover table-striped">
		
	<thead>
		<tr>
			<th><a id=mo href='<?=encode_link("errores_DNI.php",array("sort"=>"1","up"=>$up))?>'>Clave</a></th>
			<th><a id=mo href='<?=encode_link("errores_DNI.php",array("sort"=>"2","up"=>$up))?>'>DNI</a></th>
			<th><a id=mo href='<?=encode_link("errores_DNI.php",array("sort"=>"3","up"=>$up))?>'>Apellido</a></th>
			<th><a id=mo href='<?=encode_link("errores_DNI.php",array("sort"=>"4","up"=>$up))?>'>Nombre</a></th>
			<th><a id=mo href='<?=encode_link("errores_DNI.php",array("sort"=>"5","up"=>$up))?>'>Nacimiento</a></th>
			<th><a id=mo href='<?=encode_link("errores_DNI.php",array("sort"=>"6","up"=>$up))?>'>Inscripción</a></th> 				
			<th><a id=mo href='<?=encode_link("errores_DNI.php",array("sort"=>"7","up"=>$up))?>'>Activo</a></th> 							
			<th><a id=mo href='<?=encode_link("errores_DNI.php",array("sort"=>"8","up"=>$up))?>'>Código</a></th> 				
			<th><a id=mo href='<?=encode_link("errores_DNI.php",array("sort"=>"9","up"=>$up))?>'>Efector</a></th> 							
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
