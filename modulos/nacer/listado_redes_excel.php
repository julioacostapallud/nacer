<?php

require_once ("../../config.php");

$sql="SELECT b.numero_doc DNI, b.apellido_benef Apellido, b.nombre_benef Nombre, b.fecha_nacimiento_benef Nacimiento, 
b.localidad Localidad, b.cuie_ea CUIE, e.nombreefector Efector, b.fecha_inscripcion Inscripcion, b.fecha_carga Carga, 
b.fumador, b.diabetes, b.infarto, b.acv, b.hta, b.estatinas,
b.tipo_documento, b.clase_documento_benef, b.sexo, 
b.calle, b.numero_calle, b.manzana, b.piso, b.dpto, b.entre_calle_1, b.entre_calle_2, b.barrio, b.municipio, b.departamento
FROM uad.beneficiarios b INNER JOIN nacer.efe_conv e ON b.cuie_ea = e.cuie
WHERE fumador != '' OR diabetes != '' OR infarto != '' OR acv != '' OR hta != '' OR estatinas != ''
ORDER BY b.numero_doc";

$result=sql($sql) or fin_pagina();

excel_header("beneficiarios.xls");

?>
<form name=form1 method=post action="listado_redes_excel.php">
<table width="100%">
  <tr>
   <td>
    <table width="100%">
     <tr>
      <td align=left>
       <b>Total beneficiarios: </b><?=$result->RecordCount();?> 
       </td>       
      </tr>      
    </table>  
   </td>
  </tr>  
 </table> 
 <br>
 <table width="100%" align=center border=1 bordercolor=#585858 cellspacing="0" cellpadding="5"> 
  <tr bgcolor=#C0C0FF>
    <td>DNI</td>
	<td>Tipo Documento</td>
	<td>Clase Documento</td>
	<td>Sexo</td>
    <td>Apellido</td>
    <td>Nombre</td>      
    <td>Nacimiento</td>

	<td>Calle</td>      	
	<td>Numero</td>
	<td>Manzana</td>      
	<td>Piso</td> 
	<td>Dpto</td>      	
	<td>Entre calle</td>
	<td>Y calle</td>      
	<td>Barrio</td> 
	<td>Municipio</td>      	
	<td>Departamento</td>
	
    <td>Localidad</td>
	<td>CUIE</td>	
    <td>Efector</td>
    <td>Inscripcion</td>      
    <td>Carga</td> 
	<td>Fumador</td>      	
    <td>Diabetes</td>
    <td>Infarto</td>      
    <td>ACV</td> 
	<td>HTA</td>      	
    <td>Estatinas</td>
  </tr>
  <?   
  while (!$result->EOF) {?>  
    <tr>     
		<td><?=$result->fields['dni']?></td>
		<td><?=$result->fields['tipo_documento']?></td>
		<td><?=$result->fields['clase_documento_benef']?></td>
		<td><?=$result->fields['sexo']?></td> 
		<td><?=$result->fields['apellido']?></td>
		<td><?=$result->fields['nombre']?></td> 
		<td><?=fecha($result->fields['nacimiento'])?></td>
		<td><?=$result->fields['calle']?></td>     
		<td><?=$result->fields['numero_calle']?></td>
		<td><?=$result->fields['manzana']?></td> 
		<td><?=$result->fields['piso']?></td> 			
		<td><?=$result->fields['dpto']?></td> 
		<td><?=$result->fields['entre_calle_1']?></td> 
		<td><?=$result->fields['entre_calle_2']?></td> 
		<td><?=$result->fields['barrio']?></td> 
		<td><?=$result->fields['municipio']?></td> 
		<td><?=$result->fields['departamento']?></td> 	
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
	<?$result->MoveNext();
    }?>
 </table>
 </form>