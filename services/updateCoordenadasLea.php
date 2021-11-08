<?php
	//require_once "config.php";
	//key = "c05c1c7f4e584333bcdd3efb196c06e4"; //lea

	$key = "566f32feeb0f448d9e6442093e0e5fe3";
	
	// $sql_tmp = "Select b.id_beneficiarios, Trim(c.tipo || ' ' || b.calle) calle, b.numero_calle, /*barrio,*/ b.localidad
	// 			From uad.calles c inner join uad.beneficiarios b ON c.nombre ilike b.calle
	// 			Where precision is Null
	// 			And numero_calle Not In ('0', '00', '000', '0000', '1', '.1', '.', '00000')
	// 			And (numero_calle ~ '^[0-9\.]+$') = true
	// 			And b.localidad = 'RESISTENCIA'
	// 			And b.calle Not In ('S/N')
	// 			Order By numero_doc Desc
	// 			Fetch First 1 Rows Only";
	
	// $result = pg_exec($sql_tmp);
	
	// while ($row = pg_fetch_object($result)) 
	// {
		//$address = $row->calle."+".$row->numero_calle."+".$row->localidad."+"."Chaco+Argentina";
		//$address = str_replace(" ", "%20", $address);
		$address = urlencode("Calle%20Liniers%20484+Resistencia+Chaco+Argentina");
		
		$url = "http://api.opencagedata.com/geocode/v1/json?q=$address&key=$key";
            

		//$response = file_get_contents($url);
		//var_dump(json_decode($result, true));

		//$ch = curl_init($url);

			$curl_handle=curl_init();
			curl_setopt($curl_handle, CURLOPT_URL,$url);
			curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
			curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl_handle, CURLOPT_USERAGENT, 'nacer');
			curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
			$response = curl_exec($curl_handle);

			if (curl_exec($curl_handle) === false) {
				echo curl_error($curl_handle);
			} else {
				echo "cURL ejecutado correctamente<br>";
				echo $response;
			}

			curl_close($curl_handle);
            
            		
		$result_array = json_decode($response, true);
		$latitud = $result_array["results"][0]["geometry"]["lat"];
		$longitud = $result_array["results"][0]["geometry"]["lng"];
		$precision = $result_array["results"][0]["confidence"];

		print_r($result_array);
		
		// try
		// {
		// 	$query = "UPDATE uad.beneficiarios 
		// 			SET ubicacionlatitud = '$latitud',
		// 			ubicacionlongitud = '$longitud',
		// 			precision = '$precision'
		// 			WHERE id_beneficiarios = '$row->id_beneficiarios';";
		// 	pg_query($dbconn, $query);
		// }
		// catch (Exception $e)
		// {
		// 	echo $e->getMessage() . �/n�;
		// }
		
		
/*		echo $row->id_beneficiarios;
		echo $latitud;
		echo $longitud;
		echo $precision;*/


	//}
	
	//print_r($result_array);
?>