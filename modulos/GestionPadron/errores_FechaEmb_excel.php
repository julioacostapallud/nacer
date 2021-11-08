<?php

require_once ("../../config.php");

$sql="SELECT * FROM uad.beneficiarios b, nacer.efe_conv e
WHERE b.cuie_ea = e.cuie 
AND 
(
fecha_diagnostico_embarazo > current_date
OR fum > current_date
OR (fecha_diagnostico_embarazo <= date '1900-01-01' and menor_embarazada='S')
OR (fum <= date '1900-01-01' and menor_embarazada='S')
OR  ((DATE_PART('month', fum) - DATE_PART('month', fecha_probable_parto))>9 and menor_embarazada='S')
OR (TRUNC(DATE_PART('day', fecha_diagnostico_embarazo::timestamp - fum::timestamp)/7)<3 AND  menor_embarazada='S')
)";

$result=sql($sql) or fin_pagina();

excel_header("Errores FechaEmb.xls");

?>
<form name=form1 method=post action="errores_FechaEmb_excel.php">
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
    <td align=right >Clave</td>      	
    <td align=right >Documento</td>
    <td align=right >Apellido</td>
    <td align=right >Nombre</td>
    <td align=right >Nacimiento</td>    
    <td align=right >Inscripción</td>    
    <td align=right >Activo</td>    
	<td align=right >Código</td>    
    <td align=right >Efector</td>   
  </tr>
  <?   
  while (!$result->EOF) {?>  
    <tr>     
		 <td><?=$result->fields['clave_beneficiario']?></td> 	
		 <td><?=$result->fields['numero_doc']?></td> 
		 <td><?=$result->fields['apellido_benef']?></td>     
		 <td><?=$result->fields['nombre_benef']?></td>     
		 <td><?=fecha($result->fields['fecha_nacimiento_benef'])?></td>
		 <td><?=fecha($result->fields['fecha_inscripcion'])?></td>  
		 <td><?=$result->fields['activo']?></td>   
		 <td><?=$result->fields['cuie_ea']?></td> 
		 <td><?=$result->fields['nombreefector']?></td>     
    </tr>
	<?$result->MoveNext();
    }?>
 </table>
 </form>