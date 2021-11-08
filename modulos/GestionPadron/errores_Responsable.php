<?php

require_once("../../config.php");

variables_form_busqueda("errores_Responsable");

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
		"6" => "activo",
		"7" => "cuie_ea",
		"8" => "nombreefector",
		"9" => "responsable",
		"10" => "tipodocr",
		"11" => "nrodocR",
		"12" => "aper",
		"13" => "nomr",

		
       );
$filtro = array(
		"numero_doc" => "DNI",
        "apellido_benef" => "Apellido",
        "nombre_benef" => "Nombre",          
		"cuie_ea" => "Código",
       );

$sql_tmp="select t.*,e.nombreefector from
	((SELECT id_beneficiarios,fecha_nacimiento_benef,clave_beneficiario,numero_doc,apellido_benef,nombre_benef,activo,cuie_ea,responsable,tipo_doc_madre as TipoDocR,nro_doc_madre as NroDocR,apellido_madre as ApeR,nombre_madre as NomR
	FROM uad.beneficiarios b where  responsable ='MADRE') union
	(SELECT id_beneficiarios,fecha_nacimiento_benef,clave_beneficiario,numero_doc,apellido_benef,nombre_benef,activo,cuie_ea,responsable,tipo_doc_padre,nro_doc_padre,apellido_padre,nombre_padre
	FROM uad.beneficiarios b where  responsable ='PADRE') union
	(SELECT id_beneficiarios,fecha_nacimiento_benef,clave_beneficiario,numero_doc,apellido_benef,nombre_benef,activo,cuie_ea,responsable,tipo_doc_tutor,nro_doc_tutor,apellido_tutor,nombre_tutor
	FROM uad.beneficiarios b where responsable ='TUTOR')
	) as t,nacer.efe_conv e";
$where_tmp=" t.cuie_ea=e.cuie and t.fecha_nacimiento_benef+(365*10)>current_date and  nrodocr <>''  and nrodocr is not null and
(( nrodocr  LIKE '%z%') OR (LENGTH(nrodocr)>8) OR (LENGTH(nrodocr)<7)
OR ( nrodocr  LIKE '%A%') OR( nrodocr  LIKE '%F%') OR  ( nrodocr  LIKE '%K%')  OR( nrodocr  LIKE '%P%') OR  ( nrodocr  LIKE '%U%') 
OR ( nrodocr  LIKE '%B%') OR( nrodocr  LIKE '%G%') OR  ( nrodocr  LIKE '%L%')  OR( nrodocr  LIKE '%Q%') OR  ( nrodocr  LIKE '%V%') 
OR ( nrodocr  LIKE '%C%') OR( nrodocr  LIKE '%H%') OR  ( nrodocr  LIKE '%M%')  OR( nrodocr  LIKE '%R%') OR  ( nrodocr  LIKE '%W%') 
OR ( nrodocr  LIKE '%D%') OR( nrodocr  LIKE '%I%') OR  ( nrodocr  LIKE '%N%')  OR( nrodocr  LIKE '%S%') OR  ( nrodocr  LIKE '%X%') 
OR ( nrodocr  LIKE '%E%') OR( nrodocr  LIKE '%J%') OR  ( nrodocr  LIKE '%O%')  OR( nrodocr  LIKE '%T%') OR  ( nrodocr  LIKE '%Y%') 
OR ( nrodocr  LIKE '%Z%') OR( nrodocr  LIKE '%.%') OR  ( nrodocr  LIKE '%,%')  OR( nrodocr  LIKE '%;%') OR  ( nrodocr  LIKE '%:%')
OR ( nrodocr  LIKE '%a%') OR( nrodocr  LIKE '%f%') OR  ( nrodocr  LIKE '%k%')  OR( nrodocr  LIKE '%p%') OR  ( nrodocr  LIKE '%u%') 
OR ( nrodocr  LIKE '%b%') OR( nrodocr  LIKE '%g%') OR  ( nrodocr  LIKE '%l%')  OR( nrodocr  LIKE '%q%') OR  ( nrodocr  LIKE '%v%') 
OR ( nrodocr  LIKE '%c%') OR( nrodocr  LIKE '%h%') OR  ( nrodocr  LIKE '%m%')  OR( nrodocr  LIKE '%r%') OR  ( nrodocr  LIKE '%w%') 
OR ( nrodocr  LIKE '%d%') OR( nrodocr  LIKE '%i%') OR  ( nrodocr  LIKE '%n%')  OR( nrodocr  LIKE '%s%') OR  ( nrodocr  LIKE '%x%') 
OR ( nrodocr  LIKE '%e%') OR( nrodocr  LIKE '%j%') OR  ( nrodocr  LIKE '%o%')  OR( nrodocr  LIKE '%t%') OR  ( nrodocr  LIKE '%y%'))
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
			<? $link=encode_link("errores_Responsable_excel.php",array());?>
			<a href="#" class="pull-right" onclick="window.open('<?=$link?>')"><i class="icon-share-alt"></i> Exportar Excel</a>
		</div>
	</div>

<?$result = sql($sql) or die;?>

<div class="pull-right paginador">
	<?=$total_muletos?> Errores de Responsable encontrados. 
	<?=$link_pagina?>
</div> 

<table class="table table-condensed table-hover table-striped">
		
	<thead>
		<tr>
			<th><a id=mo href='<?=encode_link("errores_Responsable.php",array("sort"=>"1","up"=>$up))?>'>Clave</a></th>
			<th><a id=mo href='<?=encode_link("errores_Responsable.php",array("sort"=>"2","up"=>$up))?>'>DNI</a></th>
			<th><a id=mo href='<?=encode_link("errores_Responsable.php",array("sort"=>"3","up"=>$up))?>'>Apellido</a></th>
			<th><a id=mo href='<?=encode_link("errores_Responsable.php",array("sort"=>"4","up"=>$up))?>'>Nombre</a></th>
			<th><a id=mo href='<?=encode_link("errores_Responsable.php",array("sort"=>"5","up"=>$up))?>'>Nacimiento</a></th>
			<th><a id=mo href='<?=encode_link("errores_Responsable.php",array("sort"=>"6","up"=>$up))?>'>Activo</a></th> 							
			<th><a id=mo href='<?=encode_link("errores_Responsable.php",array("sort"=>"7","up"=>$up))?>'>Código</a></th> 				
			<th><a id=mo href='<?=encode_link("errores_Responsable.php",array("sort"=>"8","up"=>$up))?>'>Efector</a></th> 							
			<th><a id=mo href='<?=encode_link("errores_Responsable.php",array("sort"=>"9","up"=>$up))?>'>Responsable</a></th> 							
			<th><a id=mo href='<?=encode_link("errores_Responsable.php",array("sort"=>"10","up"=>$up))?>'>Tipo Doc</a></th> 							
			<th><a id=mo href='<?=encode_link("errores_Responsable.php",array("sort"=>"11","up"=>$up))?>'>Doc</a></th> 							
			<th><a id=mo href='<?=encode_link("errores_Responsable.php",array("sort"=>"12","up"=>$up))?>'>Apellido</a></th> 							
			<th><a id=mo href='<?=encode_link("errores_Responsable.php",array("sort"=>"13","up"=>$up))?>'>Nombre</a></th> 				
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
		 <td onclick="<?=$onclick_elegir?>"><?=$result->fields['activo']?></td>     
		 <td onclick="<?=$onclick_elegir?>"><?=$result->fields['cuie_ea']?></td> 
		 <td onclick="<?=$onclick_elegir?>"><?=$result->fields['nombreefector']?></td>   
		 <td onclick="<?=$onclick_elegir?>"><?=$result->fields['responsable']?></td>   
		 <td onclick="<?=$onclick_elegir?>"><?=$result->fields['tipodocr']?></td>   
		 <td onclick="<?=$onclick_elegir?>"><?=$result->fields['nrodocr']?></td>   
		 <td onclick="<?=$onclick_elegir?>"><?=$result->fields['aper']?></td>   
		 <td onclick="<?=$onclick_elegir?>"><?=$result->fields['nomr']?></td>   
    </tr>
	<?$result->MoveNext();
    }?>
    
</table>
</form>
</div>
</body>
</html>
