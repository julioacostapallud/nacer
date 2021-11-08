<?php
require_once("../../config.php");

variables_form_busqueda("listado_rcvg_resumen");

$fecha_hoy=date("Y-m-d H:i:s");
$fecha_hoy=fecha($fecha_hoy);

if ($cmd == "")  $cmd="nominalizada";

$orden = array(
        "default" => "1",
        "1" => "Descripcion",
        "2" => "Mujeres",
        "3" => "Hombres"
   
       );
$filtro = array(
		"cuie" => "Efector"
       
       );
$datos_barra = array(
		 array(
			"descripcion"=> "Resumen",
			"cmd"        => "Resumen"
		 )
	);

	
	

$sql_tmp="SELECT * FROM(
SELECT  DESC1.cuie_ea AS cuie,DESC1.Descripcion,SUM(DESC1.mujeres) AS mujeres,SUM(DESC1.Hombres)AS Hombres FROM (
(SELECT cuie_ea,'1-Población nominalizada' Descripcion, sum(case when sexo='F' then 1 else 0 end) as mujeres,sum(case when sexo='M' then 1 else 0 end) as Hombres
FROM uad.beneficiarios b INNER JOIN nacer.efe_conv e ON b.cuie_ea = e.cuie
where current_date-b.fecha_nacimiento_benef > 14600
group by cuie_ea)
union
select cuie,'1-Población nominalizada' Descripcion, 0 as mujeres,0 as Hombres
from nacer.efe_conv ) AS DESC1
GROUP BY DESC1.cuie_ea,DESC1.Descripcion

union

SELECT  DESC2.cuie_ea,DESC2.Descripcion,SUM(DESC2.mujeres) AS mujeres,SUM(DESC2.Hombres)AS Hombres FROM (
(SELECT cuie_ea,'2-Población clasificada segun RCVG' Descripcion ,sum(case when sexo='F' then 1 else 0 end) as mujeres,sum(case when sexo='M' then 1 else 0 end) as Hombres
FROM uad.beneficiarios b INNER JOIN nacer.efe_conv e ON b.cuie_ea = e.cuie
where current_date-b.fecha_nacimiento_benef > 14600
AND ((score_riesgo<>'') AND (score_riesgo<>'0'))
group by cuie_ea)
union
select cuie,'2-Población clasificada segun RCVG' Descripcion, 0 as mujeres,0 as Hombres
from nacer.efe_conv ) AS DESC2
GROUP BY DESC2.cuie_ea,DESC2.Descripcion

union

SELECT  DESC3.cuie_ea,DESC3.Descripcion,SUM(DESC3.mujeres) AS mujeres,SUM(DESC3.Hombres)AS Hombres FROM (
(SELECT cuie_ea,'3-Población clasificada con RCVG mayor al 10%' Descripcion,sum(case when sexo='F' then 1 else 0 end) as mujeres,sum(case when sexo='M' then 1 else 0 end) as Hombres
FROM uad.beneficiarios b INNER JOIN nacer.efe_conv e ON b.cuie_ea = e.cuie
where current_date-b.fecha_nacimiento_benef > 14600
AND ((score_riesgo ='3') OR (score_riesgo='4') OR (score_riesgo='5'))
group by cuie_ea)
union
select cuie,'3-Población clasificada con RCVG mayor al 10%' Descripcion, 0 as mujeres,0 as Hombres
from nacer.efe_conv ) AS DESC3
GROUP BY DESC3.cuie_ea,DESC3.Descripcion

union

SELECT  DESC4.cuie_ea,DESC4.Descripcion,SUM(DESC4.mujeres) AS mujeres,SUM(DESC4.Hombres)AS Hombres FROM (
(SELECT cuie_ea,'4-Población con RCVG mayor al 10% en seguimiento' Descripcion,sum(case when sexo='F' then 1 else 0 end) as mujeres,sum(case when sexo='M' then 1 else 0 end) as Hombres
FROM uad.beneficiarios b INNER JOIN nacer.efe_conv e ON b.cuie_ea = e.cuie
where current_date-b.fecha_nacimiento_benef > 14600
AND ((score_riesgo ='3') OR (score_riesgo='4') OR (score_riesgo='5')) 
group by cuie_ea)
union
select cuie,'4-Población con RCVG mayor al 10% en seguimiento' Descripcion, 0 as mujeres,0 as Hombres
from nacer.efe_conv ) AS DESC4
GROUP BY DESC4.cuie_ea,DESC4.Descripcion

union

SELECT  DESC5.cuie_ea,DESC5.Descripcion,SUM(DESC5.mujeres) AS mujeres,SUM(DESC5.Hombres)AS Hombres FROM (
(SELECT cuie_ea,'5-Población con RCVG mayor al 10% Sin seguimiento en el último año' Descripcion,sum(case when sexo='F' then 1 else 0 end) as mujeres,sum(case when sexo='M' then 1 else 0 end) as Hombres
FROM uad.beneficiarios b INNER JOIN nacer.efe_conv e ON b.cuie_ea = e.cuie
where current_date-b.fecha_nacimiento_benef > 14600
AND ((score_riesgo ='3') OR (score_riesgo='4') OR (score_riesgo='5'))
group by cuie_ea)
union
select cuie,'5-Población con RCVG mayor al 10% Sin seguimiento en el último año' Descripcion, 0 as mujeres,0 as Hombres
from nacer.efe_conv ) AS DESC5
GROUP BY DESC5.cuie_ea,DESC5.Descripcion


) AS T
";

//$where_tmp=" 1=1";


if ($cmd=="Resumen") $where_tmp .= " ";

echo $html_header;
?>

<div class="newstyle-full-container">

	<?
		// SUBMENU
		generar_barra_nav($datos_barra);
	?>
	
	<form name=form1 action="listado_rcvg_resumen.php" method=POST>
		<div class="row-fluid">
			<div class="span8">
				<?list($sql,$total_muletos,$link_pagina,$up) = form_busqueda($sql_tmp,$orden,$filtro,$link_tmp,$where_tmp,"buscar");?>
				<input class="btn" type=submit name="buscar" value='Buscar'>
			</div>
		</div>
		
		<?
			$result = sql($sql) or die;
		?>

		<div class="pull-right paginador">	
			<?=$total_muletos?> Resumen.  
			<?=$link_pagina?>
		</div> 

		<table class="table table-condensed table-bordered table-hover">
			<thead>
				<tr>
					<th><a id=mo href='<?=encode_link("listado_rcvg_resumen.php",array("sort"=>"1","up"=>$up))?>'>Descripción</a></th>      	
					<th><a id=mo href='<?=encode_link("listado_rcvg_resumen.php",array("sort"=>"2","up"=>$up))?>'>Mujeres</a></th>
					<th><a id=mo href='<?=encode_link("listado_rcvg_resumen.php",array("sort"=>"3","up"=>$up))?>'>Hombres</a></th>
					
				</tr>
			</thead>
			<tbody>
			<?
				while (!$result->EOF) {
			?>
					<tr>        
						<td><?=$result->fields['descripcion']?></td>
						<td><?=$result->fields['mujeres']?></td>
						<td><?=$result->fields['hombres']?></td> 
					
					</tr>
			<?
					$result->MoveNext();
				}
			?>
			</tbody>
		</table>
	</form>
</div>

</body>
</html>