<?php
	require_once "config.php";
	$user = "lnpallud";
	$pass = "Pily140531";
	
	$sql_tmp = "Select * 
				From uad.personas
				Where ComprobadoSisa Is Null and padronSumar is Null
				Order By DNI Desc
				Fetch First 10000 Rows Only";
	
	$result = pg_exec($sql_tmp);
	
	$encontrados = 0;
	$noencontrados = 0;
	
	while ($row = pg_fetch_object($result)) 
	{
		$nrodoc = $row->dni;
		$ch = curl_init("https://sisa.msal.gov.ar/sisa/services/rest/cmdb/obtener?nrodoc=$nrodoc&usuario=$user&clave=$pass");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);       
		curl_close($ch);
		
		try
		{
			$persona = new SimpleXMLElement($output);
			
			if ($persona->resultado != "QUOTA_DIARIA_EXCEDIDA")
			{
				if ($persona->id != "")
				{
					$date = new DateTime(substr($persona->fechaNacimiento, 0, 10));
					$fechanacimiento = $date->format('Y-m-d');
					
					
					$departamento = $persona->departamento;
					if ($departamento == "O'Higgins") {$departamento = "O Higgins";}
					
					$query = "UPDATE uad.personas 
					SET comprobadosisa = '1',
					fechanacimiento = '$fechanacimiento',
					nombre = '$persona->nombre',
					apellido = '$persona->apellido',
					domiciliosisa = '$persona->domicilio',
					cod_pos = '$persona->codigoPostal',
					provincia = '$persona->provincia',
					departamento = '$departamento',
					localidad = '$persona->localidad',
					tipodocumento = '$persona->tipoDocumento'
					WHERE dni = '$nrodoc';";					
					
					
					/*
					$departamento = addslashes('$persona->departamento');
					$apellido = addslashes('$persona->apellido');
					$nombre = addslashes('$persona->nombre');
					$domicilio = addslashes('$persona->domicilio');
					*/
					
					/*
					$query = "UPDATE uad.personas 
					SET comprobadosisa = '1',
					fechanacimiento = '$fechanacimiento',
					nombre = '$nombre',
					apellido = '$apellido',
					domiciliosisa = '$domicilio',
					cod_pos = '$persona->codigoPostal',
					provincia = '$persona->provincia',
					departamento = '$persona->departamento',
					localidad = '$persona->localidad',
					tipodocumento = '$persona->tipoDocumento'
					WHERE dni = '$nrodoc';";
					*/
					
					$encontrados = $encontrados + 1;
					
				} else { //Si no encuentra
					$query = "UPDATE uad.personas 
					SET comprobadosisa = '0'
					WHERE dni = '$nrodoc';";
					
					$noencontrados = $noencontrados + 1;
				}
				pg_query($dbconn, $query);
				//$arr[] = $row; //Sacar esto
			} else {
				echo 'Quota diaria excedida. ';
				echo 'Encontrados: ' . $encontrados . '. No encontrados: ' . $noencontrados;
				$flag = 1;
				break;
			}
		}
		catch (Exception $e)
		{
			echo $e->getMessage() . “/n”;
		}
	}
	if ($flag != 1) 
	{
		echo 'Encontrados: ' . $encontrados . '. No encontrados: ' . $noencontrados;
	}
	//echo json_encode($arr); //Sacar esto
?>