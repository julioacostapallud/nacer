<?php

require_once ("../../config.php");

$sql="SELECT * FROM uad.beneficiarios b,nacer.efe_conv e
where 
b.cuie_ea=e.cuie and   ((numero_doc='') OR (numero_doc is null) OR ( numero_doc  LIKE '%z%') OR (LENGTH(numero_doc)>8) OR (LENGTH(numero_doc)<7)
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

$result=sql($sql) or fin_pagina();

excel_header("Errores DNI.xls");

?>
<form name=form1 method=post action="errores_DNI_excel.php">
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