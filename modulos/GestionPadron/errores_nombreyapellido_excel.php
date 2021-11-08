<?php

require_once ("../../config.php");

$sql="SELECT * FROM uad.beneficiarios b,nacer.efe_conv e
where  b.cuie_ea=e.cuie and 
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

$result=sql($sql) or fin_pagina();

excel_header("Errores en nombreyapellido.xls");

?>
<form name=form1 method=post action="errores_nombreyapellido_excel.php">
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