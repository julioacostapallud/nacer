<?php

require_once ("../../config.php");

$cmd=$parametros["cmd"];
$estado=$cmd;
if ($cmd=='nominalizada') $cmd='N';
elseif ($cmd=='clasificada')$cmd='C';
elseif ($cmd=='mayor')$cmd='M';
elseif ($cmd=='seguimiento')$cmd='S';
else $cmd='X';

$sql="SELECT b.numero_doc DNI, b.apellido_benef Apellido, b.nombre_benef Nombre, b.fecha_nacimiento_benef Nacimiento, 
b.localidad Localidad, b.cuie_ea CUIE, e.nombreefector Efector, b.fecha_inscripcion Inscripcion, b.fecha_carga Carga, 
b.fumador, b.diabetes, b.hta, b.score_riesgo, b.sexo
FROM uad.beneficiarios b INNER JOIN nacer.efe_conv e ON b.cuie_ea = e.cuie
WHERE ( current_date-b.fecha_nacimiento_benef) > 14600";

if ($cmd!='T') $sql.=" AND (smiafiliados.activo='$cmd')";
$sql.=" Order by smiafiliados.afiapellido";

$result=sql($sql) or fin_pagina();

excel_header("beneficiarios.xls");

?>
<form name=form1 method=post action="listado_rcvg_excel.php">
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
    <td>Apellido</td>
    <td>Nombre</td>      
    <td>Nacimiento</td>
    <td>Localidad</td>
	<td>CUIE</td>	
    <td>Efector</td>
    <td>Inscripcion</td>      
    <td>Carga</td> 
	<td>Fumador</td>      	
    <td>Diabetes</td>
	<td>HTA</td>      	
    <td>RCVG</td>
	<td>Sexo</td>
  </tr>
  <?   
  while (!$result->EOF) {?>  
    <tr>     
		<td><?=$result->fields['dni']?></td>
		<td><?=$result->fields['apellido']?></td>
		<td><?=$result->fields['nombre']?></td> 
		<td><?=fecha($result->fields['nacimiento'])?></td>
		<td><?=$result->fields['localidad']?></td>
		<td><?=$result->fields['cuie']?></td>		
		<td><?=$result->fields['efector']?></td>
		<td><?=fecha($result->fields['inscripcion'])?></td>
		<td><?=fecha($result->fields['carga'])?></td>						
		<td><?=$result->fields['fumador']?></td> 
		<td><?=$result->fields['diabetes']?></td> 
		<td><?=$result->fields['hta']?></td> 
		<td><?=$result->fields['score_riesgo']?></td>
		<td><?=$result->fields['sexo']?></td> 		
    </tr>
	<?$result->MoveNext();
    }?>
 </table>
 </form>