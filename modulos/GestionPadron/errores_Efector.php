<?php

require_once("../../config.php");

variables_form_busqueda("errores_Efector");

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
		"8" => "localidad",
		"9" => "barrio",
		"10" => "usuario_carga",
		

       );
$filtro = array(
		"numero_doc" => "DNI",
        "apellido_benef" => "Apellido",
        "nombre_benef" => "Nombre",          
		"localidad" => "Localidad",          
		"barrio" => "Barrio",          		
       );

$sql_tmp="SELECT * FROM uad.beneficiarios";
$where_tmp="cuie_ea='-1'  or cuie_ea='' or cuie_ea is null
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
			<? $link=encode_link("errores_Efector_excel.php",array());?>
			<a href="#" class="pull-right" onclick="window.open('<?=$link?>')"><i class="icon-share-alt"></i> Exportar Excel</a>
		</div>
	</div>

<?$result = sql($sql) or die;?>

<div class="pull-right paginador">
	<?=$total_muletos?> Beneficiarios sin efector encontrados. 
	<?=$link_pagina?>
</div> 

<table class="table table-condensed table-hover table-striped">
		
	<thead>
		<tr>
			<th><a id=mo href='<?=encode_link("errores_Efector.php",array("sort"=>"1","up"=>$up))?>'>Clave</a></th>
			<th><a id=mo href='<?=encode_link("errores_Efector.php",array("sort"=>"2","up"=>$up))?>'>DNI</a></th>
			<th><a id=mo href='<?=encode_link("errores_Efector.php",array("sort"=>"3","up"=>$up))?>'>Apellido</a></th>
			<th><a id=mo href='<?=encode_link("errores_Efector.php",array("sort"=>"4","up"=>$up))?>'>Nombre</a></th>
			<th><a id=mo href='<?=encode_link("errores_Efector.php",array("sort"=>"5","up"=>$up))?>'>Nacimiento</a></th>
			<th><a id=mo href='<?=encode_link("errores_Efector.php",array("sort"=>"6","up"=>$up))?>'>Inscripción</a></th> 				
			<th><a id=mo href='<?=encode_link("errores_Efector.php",array("sort"=>"7","up"=>$up))?>'>Activo</a></th> 		
			<th><a id=mo href='<?=encode_link("errores_Efector.php",array("sort"=>"8","up"=>$up))?>'>Localidad</a></th> 				
			<th><a id=mo href='<?=encode_link("errores_Efector.php",array("sort"=>"9","up"=>$up))?>'>Barrio</a></th> 							
			<th><a id=mo href='<?=encode_link("errores_Efector.php",array("sort"=>"10","up"=>$up))?>'>Usuario</a></th> 							
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
	     <td onclick="<?=$onclick_elegir?>"><?=$result->fields['localidad']?></td>      		 
	     <td onclick="<?=$onclick_elegir?>"><?=$result->fields['barrio']?></td>   		 
		 <td onclick="<?=$onclick_elegir?>"><?=$result->fields['usuario_carga']?></td>   		 
    </tr>
	<?$result->MoveNext();
    }?>
    
</table>
</form>
</div>
</body>
</html>
