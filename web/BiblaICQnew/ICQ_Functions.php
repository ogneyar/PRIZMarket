<?

/*
**
** _старт
** _CoinMarketCap
**
**
**
**
*/

// реакция бота на команду старт
function _старт() {	
	global $bot_icq, $chatId, $firstName;
	$реплика = "Здравствуй ".$firstName."\n\nЯ помогу тебе узнать сколько стоит PRIZM на \n\nCoinMarketCap.com \n\nдля этого нажми на команду \n\n/kurs \n\nили же пришли мне слово *Курс*.";
	$bot_icq->sendText($chatId, $реплика);
}

// отправка сообщения к АПИ КМК
function _CoinMarketCap($id){	
	
	global $cmc_api_key;
	
	// 'RUB'='2806' 
	// 'PZM'='1681'
	
	$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest';
	$parameters = [			
		'id' => $id		
	];

	$headers = [
		'Accepts: application/json',
		'X-CMC_PRO_API_KEY: '.$cmc_api_key
	];
	$qs = http_build_query($parameters); // query string encode the parameters
	$request = "{$url}?{$qs}"; // create the request URL


	$curl = curl_init(); // Get cURL resource
	// Set cURL options
	curl_setopt_array($curl, array(
		CURLOPT_URL => $request,            // set the request URL
		CURLOPT_HTTPHEADER => $headers,     // set the headers 
		CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
	));

	$response = curl_exec($curl); // Send the request, save the response
	
	curl_close($curl); // Close request

	return $response;

}
	

function _kurs_PZM(){	
	
	$время = time();
	
	$время_записи = _время_записи_курса();
	
	if ($время_записи) $разница = $время - $время_записи;
	
	if ($время_записи&&$разница < 600) {
		
			$reply = _дай_курс_PZM();
			
	}else {
		
			$arrayCMC_RUB=json_decode(_CoinMarketCap('2806'), true); 	//  RUB
			$PriceRUB_in_USD=$arrayCMC_RUB['data']['2806']['quote']['USD']['price'];	
			$PriceUSD_in_RUB=1/$PriceRUB_in_USD;	

			$arrayCMC_PZM=json_decode(_CoinMarketCap('1681'), true); // PRIZM
			$PricePZM_in_USD=$arrayCMC_PZM['data']['1681']['quote']['USD']['price'];
			$PricePZM_in_RUB=$PriceUSD_in_RUB*$PricePZM_in_USD;
	
			$Date_PricePZM = gmdate('d.m.Y H:i', $время + 3*3600);
	
			$Round_PricePZM_in_USD=round($PricePZM_in_USD, 4);
			$Round_PricePZM_in_RUB=round($PricePZM_in_RUB, 2);
						
			_запись_переменной_курса('курс PZM', $Round_PricePZM_in_USD, 'USD', $время);
			
			_запись_переменной_курса('курс PZM', $Round_PricePZM_in_RUB, 'RUB', $время);
					
			$reply="Курс PRIZM на [CoinMarketCap](https://coinmarketcap.com/ru/currencies/prizm/)\n\n\t\t1PZM = ".
				$Round_PricePZM_in_USD." $\n\t\t1PZM = ".$Round_PricePZM_in_RUB.
				" \xE2\x82\xBD\n\n";  //1PZM = ".$Round_PricePZM_in_ETH." ETH\n1PZM = ".$Round_PricePZM_in_BTC." BTC
			$reply.="на ".$Date_PricePZM." МСК";			
			
	}

	return $reply;

}


// функция вывода из таблицы данных о курсе
function _дай_курс_PZM(){	
	
	global $mysqli, $tokenMARKET, $таблица_переменных;

        $id_bota = strstr($tokenMARKET, ':', true);

	$ответ = false;
	
	$запрос = "SELECT * FROM {$таблица_переменных} WHERE id_bota='{$id_bota}' AND nazvanie='курс PZM'";
	 
	$результат = $mysqli->query($запрос);

	if ($результат->num_rows > 0) {
		
		$результМассив = $результат->fetch_all(MYSQLI_ASSOC);
		
		foreach($результМассив as $строка) { 
		
			if ($строка['opisanie'] == 'USD') {
			
				$курсPZM_USD = $строка['soderjimoe'];
				
			}elseif ($строка['opisanie'] == 'RUB') {
				
				$курсPZM_RUB = $строка['soderjimoe'];
				
			}
			
		}
		
		$время = $результМассив[0]['vremya'];

                $Date_PricePZM = gmdate('d.m.Y H:i', $время + 3*3600);
		
		$ответ = "Курс PRIZM на [CoinMarketCap](https://coinmarketcap.com/ru/currencies/prizm/)\n\n\t\t1PZM = ".
		$курсPZM_USD." $\n\t\t1PZM = ".$курсPZM_RUB." \xE2\x82\xBD\n\nна ".$Date_PricePZM." МСК";	
		
	}	

	return $ответ;

}

// запись в таблицу для переменных
function _запись_переменной_курса($название, $содержимое, $описание, $время){	
	
	global $mysqli, $tokenMARKET, $таблица_переменных;
	
        $id_bota = strstr($tokenMARKET, ':', true);
	
	$запрос = "SELECT nazvanie FROM {$таблица_переменных} WHERE id_bota='{$id_bota}' AND nazvanie='{$название}' AND opisanie='{$описание}'";
	 
	$результат = $mysqli->query($запрос);

	if ($результат->num_rows > 0) {
		
		$запрос = "UPDATE {$таблица_переменных} SET soderjimoe='{$содержимое}', vremya='{$время}'  WHERE id_bota='{$id_bota}' AND nazvanie='{$название}' AND opisanie='{$описание}'";
		
		$mysqli->query($запрос);
		
	}else {
		
		$запрос = "INSERT INTO {$таблица_переменных} (
			`id_bota`, `nazvanie`, `soderjimoe`, `opisanie`, `vremya`
		) VALUES (
			'{$id_bota}', '{$название}', '{$содержимое}', '{$описание}', '{$время}'
		)";		
		
		$mysqli->query($запрос);
		
	}
	
}


// проверка последней записи курса
function _время_записи_курса(){	
	
	global $mysqli, $tokenMARKET, $таблица_переменных;
	
        $id_bota = strstr($tokenMARKET, ':', true);

	$ответ = false;
		
	$запрос = "SELECT vremya FROM {$таблица_переменных} WHERE id_bota={$id_bota} AND nazvanie='курс PZM'";
	 
	$результат = $mysqli->query($запрос);
	
	if ($результат) {
	
		if ($результат->num_rows > 0) {
			
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);
			
			$ответ = $результМассив[0]['vremya'];
			
		}
	
	}
	
	return $ответ;
	
}



?>
