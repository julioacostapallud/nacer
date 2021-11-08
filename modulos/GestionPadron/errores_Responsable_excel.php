<?php

require_once ("../../config.php");

$sql="select t.*,e.nombreefector from
	((SELECT fecha_nacimiento_benef,clave_beneficiario,numero_doc,apellido_benef,nombre_benef,activo,cuie_ea,responsable,tipo_doc_madre as TipoDocR,nro_doc_madre as NroDocR,apellido_madre as ApeR,nombre_madre as NomR
	FROM uad.beneficiarios b where  responsable ='MADRE') union
	(SELECT fecha_nacimiento_benef,clave_beneficiario,numero_doc,apellido_benef,nombre_benef,activo,cuie_ea,responsable,tipo_doc_padre,nro_doc_padre,apellido_padre,nombre_padre
	FROM uad.beneficiarios b where  responsable ='PADRE') union
	(SELECT fecha_nacimiento_benef,clave_beneficiario,numero_doc,apellido_benef,nombre_benef,activo,cuie_ea,responsable,tipo_doc_tutor,nro_doc_tutor,apellido_tutor,nombre_tutor
	FROM uad.beneficiarios b where responsable ='TUTOR')
	) as t,nacer.efe_conv e
where t.cuie_ea=e.cuie and t.fecha_nacimiento_benef+(365*10)>current_date and  nrodocr <>''  and nrodocr is not null and
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

$result=sql($sql) or fin_pagina();

excel_header("Errores Responsable.xls");

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
    <td align=right >Activo</td>    
	<td align=right >Código</td>    
    <td align=right >Efector</td>   
    <td align=right >Responsable</td>   
    <td align=right >Tipo Doc</td>   
    <td align=right >Nro Doc</td>   
    <td align=right >Apellido</td>   
    <td align=right >Nombre</td>   	
  </tr>
  <?   
  while (!$result->EOF) {?>  
    <tr>     
		 <td><?=$result->fields['clave_beneficiario']?></td> 	
		 <td><?=$result->fields['numero_doc']?></td> 
		 <td><?=$result->fields['apellido_benef']?></td>     
		 <td><?=$result->fields['nombre_benef']?></td>     
		 <td><?=fecha($result->fields['fecha_nacimiento_benef'])?></td>
		 <td><?=$result->fields['activo']?></td>   
		 <td><?=$result->fields['cuie_ea']?></td> 
		 <td><?=$result->fields['nombreefector']?></td>     
		 <td><?=$result->fields['responsable']?></td>     
		 <td><?=$result->fields['tipodocr']?></td>     
		 <td><?=$result->fields['nrodocr']?></td>     
		 <td><?=$result->fields['aper']?></td>     
		 <td><?=$result->fields['nomr']?></td>     		 
    </tr>
	<?$result->MoveNext();
    }?>
 </table>
 </form>