<?php

require_once ("../../config.php");

$sql=$parametros["sql"];
$result=sql($sql) or fin_pagina();

excel_header("resumen_planillas.xls");

?>
<form name=form1 method=post action="resumen_planillas_excel.php">
 <br>
 <table width="100%" align=center border=1 bordercolor=#585858 cellspacing="0" cellpadding="5"> 
  <tr bgcolor=#C0C0FF>
    <td align=right id=mo>Efector</td>
    <td align=right id=mo>Cant Ni?os</td>
    <td align=right id=mo>Cant Embarazadas</td>   
  </tr>
  <?   
  while (!$result->EOF) {?>  
    <tr>     
     <td><?=$result->fields['nombreefector']?></td>     
     <td><?=$result->fields['cn']?></td>     
     <td><?=$result->fields['ca']?></td>        
    </tr>
	<?$result->MoveNext();
    }?>
 </table>
 </form>