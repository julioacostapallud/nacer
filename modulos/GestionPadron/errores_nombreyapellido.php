<?php

require_once("../../config.php");

variables_form_busqueda("errores_nombreyapellido");

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
		"cuie_ea" => "C�digo",
       );

$sql_tmp="SELECT * FROM uad.beneficiarios b,nacer.efe_conv e";
$where_tmp=" b.cuie_ea=e.cuie and 
((apellido_benef  is null ) or (apellido_benef ='') OR (LENGTH(apellido_benef)<3)
OR ( apellido_benef LIKE '%1%') OR ( apellido_benef LIKE '%2%') OR ( apellido_benef LIKE '%3%') 
OR ( apellido_benef LIKE '%4%') OR ( apellido_benef LIKE '%5%') OR ( apellido_benef LIKE '%6%') 
OR ( apellido_benef LIKE '%7%') OR ( apellido_benef LIKE '%8%') OR ( apellido_benef LIKE '%9%') 
OR ( apellido_benef LIKE '%0%') OR ( apellido_benef LIKE '%.%') OR ( apellido_benef LIKE '%,%')
OR ( apellido_benef LIKE ' %') OR ( apellido_benef LIKE '%;%') OR ( apellido_benef LIKE '%:%')
OR ( nombre_benef  is null ) OR (nombre_benef ='') OR (LENGTH(nombre_benef)<3)
OR ( nombre_benef LIKE '%1%') OR ( nombre_benef LIKE '%2%') OR ( nombre_benef LIKE '%3%') 
OR ( nombre_benef LIKE '%4%') OR ( nombre_benef LIKE '%5%') OR ( nombre_benef LIKE '%6%') 
OR ( nombre_benef LIKE '%7%') OR ( nombre_benef LIKE '%8%') OR ( nombre_benef LIKE '%9%') 
OR ( nombre_benef LIKE '%0%') OR ( nombre_benef LIKE '%.%') OR ( nombre_benef LIKE '%,%')
OR ( nombre_benef LIKE ' %') OR ( nombre_benef LIKE '%;%') OR ( nombre_benef LIKE '%:%'))
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
			<? $link=encode_link("errores_nombreyapellido_excel.php",array());?>
			<a href="#" class="pull-right" onclick="window.open('<?=$link?>')"><i class="icon-share-alt"></i> Exportar Excel</a>
		</div>
	</div>

<?$result = sql($sql) or die;?>

<div class="pull-right paginador">
	<?=$total_muletos?> Errores en Nombre y apellido encontrados. 
	<?=$link_pagina?>
</div> 

<table class="table table-condensed table-hover table-striped">
		
	<thead>
		<tr>
			<th><a id=mo href='<?=encode_link("errores_nombreyapellido.php",array("sort"=>"1","up"=>$up))?>'>Clave</a></th>
			<th><a id=mo href='<?=encode_link("errores_nombreyapellido.php",array("sort"=>"2","up"=>$up))?>'>DNI</a></th>
			<th><a id=mo href='<?=encode_link("errores_nombreyapellido.php",array("sort"=>"3","up"=>$up))?>'>Apellido</a></th>
			<th><a id=mo href='<?=encode_link("errores_nombreyapellido.php",array("sort"=>"4","up"=>$up))?>'>Nombre</a></th>
			<th><a id=mo href='<?=encode_link("errores_nombreyapellido.php",array("sort"=>"5","up"=>$up))?>'>Nacimiento</a></th>
			<th><a id=mo href='<?=encode_link("errores_nombreyapellido.php",array("sort"=>"6","up"=>$up))?>'>Inscripci�n</a></th> 				
			<th><a id=mo href='<?=encode_link("errores_nombreyapellido.php",array("sort"=>"7","up"=>$up))?>'>Activo</a></th> 							
			<th><a id=mo href='<?=encode_link("errores_nombreyapellido.php",array("sort"=>"8","up"=>$up))?>'>C�digo</a></th> 				
			<th><a id=mo href='<?=encode_link("errores_nombreyapellido.php",array("sort"=>"9","up"=>$up))?>'>Efector</a></th> 							
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
