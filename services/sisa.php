<?php
	$user = "lnpallud";
	$pass = "Pily140531";
	if(!empty($_GET)) {
		if(!empty($_GET["dni"])) {
			$nrodoc = $_GET["dni"];
			$ch = curl_init("https://sisa.msal.gov.ar/sisa/services/rest/cmdb/obtener?nrodoc=$nrodoc&usuario=$user&clave=$pass");
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);       
			curl_close($ch);
			
			$persona = new SimpleXMLElement($output);
			
			if ($persona->resultado == "QUOTA_DIARIA_EXCEDIDA")
			{
				echo $persona->resultado;
			} else {
				echo "id: " . $persona->id . "<br>";
				echo "codigoSISA: " . $persona->codigoSISA . "<br>";
				echo "tipoDocumento: " . $persona->tipoDocumento . "<br>";
				echo "nroDocumento: " . $persona->nroDocumento . "<br>";
				echo "Apellido: " . $persona->apellido . "<br>";
				echo "Nombre: " . $persona->nombre . "<br>";
				echo "sexo: " . $persona->sexo . "<br>";
				echo "fechaNacimiento: " . $persona->fechaNacimiento . "<br>";
				echo "obraSocialVigente: " . $persona->obraSocialVigente . "<br>";
				echo "provincia: " . $persona->provincia . "<br>";
				echo "departamento: " . $persona->departamento . "<br>";
				echo "localidad: " . $persona->localidad . "<br>";
				echo "domicilio: " . $persona->domicilio . "<br>";
				echo "codigoPostal: " . $persona->codigoPostal . "<br>";
				echo "resultado: " . $persona->resultado . "<br>";
			}
		}
	}
?>