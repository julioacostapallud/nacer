<?php

require_once ("../../config.php");

$sql="SELECT * FROM uad.beneficiarios b,nacer.efe_conv e
where b.cuie_ea=e.cuie and 
fecha_nacimiento_benef>current_date
";

$result=sql($sql) or fin_pagina();

excel_header("Errores FechaNac.xls");

?>
<form name=form1 method=post action="errores_FechaNac_excel.php">
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