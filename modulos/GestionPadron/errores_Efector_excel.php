<?php

require_once ("../../config.php");

$sql="select * from uad.beneficiarios 
where 
cuie_ea='-1'  or cuie_ea='' or cuie_ea is null
";

$result=sql($sql) or fin_pagina();

excel_header("Errores Efector.xls");

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
    <td align=right >Localidad</td>    
    <td align=right >Barrio</td>    
    <td align=right >Usuario</td>    	
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
		 <td><?=$result->fields['localidad']?></td>   
		 <td><?=$result->fields['barrio']?></td>   		 
		 <td><?=$result->fields['usuario_carga']?></td>   		 
    </tr>
	<?$result->MoveNext();
    }?>
 </table>
 </form>