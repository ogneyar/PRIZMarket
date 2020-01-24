<?php

/*      ---------------------------
**
**       +-----------------------+
**       | ОСНОВНЫЕ ФУНКЦИИ БОТА |
**       +-----------------------+
**
**      ---------------------------
*/

function PrintArr($mass, $i=0) {
	
	global $flag;
		
	$flag .= "\t\t\t\t";			
		
	foreach($mass as $key[$i] => $value[$i]) {				
		if (is_array($value[$i])) {
				$_this .= $flag . $key[$i] . " : \n";
				$_this .= PrintArr($value[$i], ++$i);
		}else $_this .= $flag . $key[$i] . " : " . $value[$i] . "\n";
	}
	$str = $flag;
	$flag = substr($str, 0, -4);
	return $_this;
}


// при возникновении исключения вызывается эта функция
function exception_handler($exception) {

	global $tg, $master;
	
	$tg->sendMessage($master, "Ошибка! ".$exception->getCode()." ".$exception->getMessage());	
  
	exit('ok');  
}


function _CoinMarketCap($id){	

	// 'RUB'='2806' 
	// 'PZM'='1681'
	// 'ETH'='2'
	// 'BTC'='1'
	
	$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest';
	$parameters = [			
		'id' => $id		
	];

	$headers = [
		'Accepts: application/json',
		'X-CMC_PRO_API_KEY: c6791c7f-da01-47d3-8e06-2ef5def157b8'
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

function _PricePZM_in_Monet($symbol){
		
	if ($symbol=="\xE2\x82\xBD"){
		$CMCid='2806';
	}elseif ($symbol=="ETH"){
		$CMCid='2';
	}elseif ($symbol=="BTC"){
		$CMCid='1';
	}elseif ($symbol=="$"){
		$CMCid='1681'; // 1681 это PZM, стоимость всегда в дорлларах
	}	
	
	$arrayCMC=json_decode(_CoinMarketCap($CMCid), true); 	
	$PriceMonet_in_USD=$arrayCMC['data'][$CMCid]['quote']['USD']['price'];	// заданная Монета в долларах
	
	$PriceUSD_in_Monet=1/$PriceMonet_in_USD;	// 1 доллар в заданной Монете
	
	$arrayCMC_PZM=json_decode(_CoinMarketCap('1681'), true); // PRIZM
	$PricePZM_in_USD=$arrayCMC_PZM['data']['1681']['quote']['USD']['price'];
	
	if ($CMCid=='1681'){
		$PricePZM_in_Monet=$PriceMonet_in_USD;
	}else $PricePZM_in_Monet=$PriceUSD_in_Monet*$PricePZM_in_USD;	
	
	$Date_PricePZM=$arrayCMC_PZM['data']['1681']['quote']['USD']['last_updated'];
	
	$unixDate=strtotime($Date_PricePZM);
	$Date_PricePZM = gmdate('d.m.Y H:i:s', $unixDate + 3*3600);
	
	if ($CMCid=='1'){
		$PricePZM_in_Monet=number_format($PricePZM_in_Monet, 8, ".", "");
	}elseif ($CMCid=='2'){
		$PricePZM_in_Monet=number_format($PricePZM_in_Monet, 6, ".", "");
	}elseif (($CMCid=='1681')||($CMCid=='2806')){
		$PricePZM_in_Monet=number_format($PricePZM_in_Monet, 2, ".", "");
	}	
	
	$response="(1 PZM = ".$PricePZM_in_Monet." ".$symbol." на ".$Date_PricePZM.")";
	
	return $response;
	
}	


function _kurs_PZM(){	

		$arrayCMC_RUB=json_decode(_CoinMarketCap('2806'), true); 	//  RUB
		$PriceRUB_in_USD=$arrayCMC_RUB['data']['2806']['quote']['USD']['price'];	
		$PriceUSD_in_RUB=1/$PriceRUB_in_USD;	

		$arrayCMC_PZM=json_decode(_CoinMarketCap('1681'), true); // PRIZM
		$PricePZM_in_USD=$arrayCMC_PZM['data']['1681']['quote']['USD']['price'];
		$PricePZM_in_RUB=$PriceUSD_in_RUB*$PricePZM_in_USD;
	
		$arrayCMC_ETH=json_decode(_CoinMarketCap('2'), true); // ETH
		$PriceETH_in_USD=$arrayCMC_ETH['data']['2']['quote']['USD']['price'];
		$PriceUSD_in_ETH=1/$PriceETH_in_USD;	
		$PricePZM_in_ETH=$PricePZM_in_USD*$PriceUSD_in_ETH;
	
		$arrayCMC_BTC=json_decode(_CoinMarketCap('1'), true); // BTC
		$PriceBTC_in_USD=$arrayCMC_BTC['data']['1']['quote']['USD']['price'];
		$PriceUSD_in_BTC=1/$PriceBTC_in_USD;	
		$PricePZM_in_BTC=$PricePZM_in_USD*$PriceUSD_in_BTC;

		$Date_PricePZM=$arrayCMC_PZM['data']['1681']['quote']['USD']['last_updated'];
	
		$unixDate=strtotime($Date_PricePZM);
		$Date_PricePZM = gmdate('d.m.Y H:i:s', $unixDate + 3*3600);
	
		$Round_PricePZM_in_USD=round($PricePZM_in_USD, 2);
		$Round_PricePZM_in_RUB=round($PricePZM_in_RUB, 2);
		$Round_PricePZM_in_ETH=round($PricePZM_in_ETH, 6);
		$Round_PricePZM_in_BTC=number_format($PricePZM_in_BTC, 8, ".", "");
	
		$reply="Курс PRIZM на [CoinMarketCap:](https://coinmarketcap.com/ru/currencies/prizm/)\n1PZM = ".
			$Round_PricePZM_in_USD." $\n1PZM = ".$Round_PricePZM_in_RUB.
			" \xE2\x82\xBD\n1PZM = ".$Round_PricePZM_in_ETH." ETH\n1PZM = ".$Round_PricePZM_in_BTC." BTC\n";
		$reply.="Данные на ".$Date_PricePZM." МСК";	
		
		return $reply;
/*		
		$tg->call('sendMessage', [
            'chat_id' => $chatId,
            'text' => $reply,
            'parse_mode' => markdown,
            'disable_web_page_preview' => true,
            'reply_to_message_id' => null,
            'reply_markup' => null,
            'disable_notification' => false,
        ]);
*/
}



/* -----------------------------------
**
**  +-------------------------------+
**  | ФУНКЦИИ ДЛЯ bot_08_inline.php |
**  +-------------------------------+
**
** -----------------------------------
*/


function num_keybord($number, $_insert, $_keybord) { // функция клавиатуры ввода чисел

	global $str, $callbackText, $callbackChatId, $callbackMessageId, $callbackQueryId, $tg, $tehPodderjka, $callback_from_id, $mysqli, $master, $table2;
	
	$flag_vvoda='0';
	$last_id='0';
	$zpt='0';
	$summa="";
	
	$query = "SELECT id, knopka, flag, zpt FROM ". $table2 ." WHERE id_client=". $callback_from_id ." ORDER BY id"; 
	if ($result = $mysqli->query($query)) {						
		$last_id=$result->num_rows;
		if($last_id>0){
			$arrStrok = $result->fetch_all();
			$flag_vvoda=$arrStrok[$last_id-1]['2'];					
			for ($i=0; $i<$last_id; $i++){	
				$summa.=$arrStrok[$i]['1'];
				if ($arrStrok[$i]['3']=='1')$zpt='1';
			}			
		}		
	}
	if($summa<>""){
		$simbol = substr($summa, -1);    
		$sum= substr($summa,0,-1);
		if($sum<>""){
			$simbol2 = substr($sum, -1); 
		}
	}
	
	if ($flag_vvoda=='1') exit('ok');	
	
	$last = substr(strrchr($str, 10), 1);
	$kol=strlen($last);
	if ($kol>'0') {
		$str2 = substr($str,0,-$kol);
		$str=$str2;	
	}
	
	$txt = ".".$tehPodderjka."Отлично, теперь *введите " . $_insert . "*, огромная просьба \xF0\x9F\x99\x8F".
			" делайте это не спеша, а после нажмите \xE2\x9C\x85";			
			
	switch ($number) {
	case '1': case '2':	case '3': case '4': case '5': case '6': case '7': case '8': case '9':	
		
		$query = "INSERT INTO ".$table2." VALUES ('". $callback_from_id ."', '". ++$last_id ."' , '" . $number . "', '".$flag_vvoda."', '0')";
		$result=$mysqli->query($query);	
		
		$str.= $summa.$number . $txt;	
		
        break;
	case '0':	
		if ($last_id==0){
			$zpt='1';
			$number.=",";		
		}else $zpt='0';			
		
		$query = "INSERT INTO ".$table2." VALUES ('". $callback_from_id ."', '". ++$last_id ."', '" . $number . "', '" . $flag_vvoda . "', '" . $zpt . "')";
		if($result=$mysqli->query($query)){
			$str.= $summa.$number . $txt;	
		}else 	$tg->sendMessage($master, "не получается ноль в таблице сохранить");	
	
        break;
	case '20':  // 2 ноля	
		if ($last_id==0){
			$zpt='1';
			$number="0,0";		
		}else {
			$zpt='0';			
			$number="00";
		}	
		
		$query = "INSERT INTO ".$table2." VALUES ('". $callback_from_id ."', '". ++$last_id ."' , '" . $number . "', '".$flag_vvoda."', '".$zpt."')";
		$result=$mysqli->query($query);	

		$str.= $summa.$number . $txt;		
	
        break;	
	case '30':  // 3 ноля
		if ($last_id==0){
			$zpt='1';
			$number="0,00";		
		}else {
			$zpt='0';			
			$number="000";
		}
		
		$query = "INSERT INTO ".$table2." VALUES ('". $callback_from_id ."', '". ++$last_id ."' , '" . $number . "', '".$flag_vvoda."', '".$zpt."')";
		$result=$mysqli->query($query);	

		$str.= $summa.$number . $txt;	
		
        break;	
	case '50':  // удаление 
		if ($last_id>0){
			
			$query = "DELETE FROM ".$table2." WHERE id_client=" . $callback_from_id . " AND id=". $last_id;		
			$result=$mysqli->query($query);	
			
			$summa="";
			
			$query = "SELECT id, knopka FROM ". $table2 ." WHERE id_client=". $callback_from_id ." ORDER BY id"; 
			if ($result = $mysqli->query($query)) {				
				$last_id=$result->num_rows;
				if($last_id>0){
					$arrStrok = $result->fetch_all();								
					for ($i=0; $i<$last_id; $i++){	
						$summa.=$arrStrok[$i]['1'];						
					}			
				}		
			}			
			
			$str.= $summa . $txt;	
	
		}else {  // если не было ввода символов
			$str2 = "Эта операция не возможна\xE2\x9D\x97";
			$tg->answerCallbackQuery($callbackQueryId, $str2);		
			exit('ok');
		}		
		break;	
	case '90':  // запятая
		if($zpt=='0'){
			$zpt='1';
			if ($last_id==0){				
				$number="0,";		
			}else {				
				$number=",";		
			}
		
			$query = "INSERT INTO ".$table2." VALUES ('". $callback_from_id ."', '". ++$last_id ."' , '" . $number . "', '".$flag_vvoda."', '".$zpt."')";
			$result=$mysqli->query($query);	

			$str.= $summa.$number . $txt;	
		}else{
			$str2 = "Эта операция не возможна\xE2\x9D\x97";
			$tg->answerCallbackQuery($callbackQueryId, $str2);		
			exit('ok');
		}
		
		break;
	}
	
	$tg->editMessageText($callbackChatId, $callbackMessageId, $str, markdown, true, $_keybord);
}


function udalenie_starih_zapisey($tab) { // функция клавиатуры ввода чисел

	global $callback_from_id, $mysqli, $tg, $master;	
	
	$est_li_v_base=false;
	
	$query = "SELECT id_client FROM ". $tab ." WHERE id_client=". $callback_from_id; 
	if ($result = $mysqli->query($query)) {
		if($result->num_rows>0)	$est_li_v_base=true;					
	}
	
	if ($est_li_v_base==true) {
		$query = "DELETE FROM ".$tab." WHERE id_client=" . $callback_from_id;
		$mysqli->query($query);	
	}		
}


function kuplu_prodam_vibor($vibor) { // функция выбора кплю/продам

	global $callback_from_id, $mysqli, $tg, $callbackMessageId;
	global $table3, $callbackChatId, $keyInLine3, $tehPodderjka;	
	
	$query = "INSERT INTO ".$table3." VALUES ('". $callback_from_id ."', '". $callbackMessageId ."', '".$vibor."', 'PZM', '0', '0', '0', '0', '0', '0')";
	$mysqli->query($query);	
	
	$sms = "\xF0\x9F\x97\xA3 #".$vibor."\nPZM\n." . $tehPodderjka . "Отлично, теперь *введите КОЛИЧЕСТВО монет*,".
		" огромная просьба \xF0\x9F\x99\x8F делайте это не спеша, а после нажмите \xE2\x9C\x85";			
	$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine3);		
}


function vibor_valut($valuta) { // функция выбора кплю/продам

	global $callback_from_id, $mysqli, $tg, $callbackMessageId, $sms;
	global $table3, $callbackChatId, $keyInLine4, $tehPodderjka, $cenaText;		
	
	$query = "UPDATE ".$table3." SET valuta='".$valuta."' WHERE id_client=" . $callback_from_id;
	$mysqli->query($query);	
		
	
	$PricePZM_and_Date=_PricePZM_in_Monet($valuta);	
	
	
	$sms.= $valuta."\n.\n[{$PricePZM_and_Date}](https://coinmarketcap.com/ru/currencies/prizm/)" . $tehPodderjka . "Отлично, теперь *введите ".$cenaText."*, огромная просьба".
		" \xF0\x9F\x99\x8F делайте это не спеша, а после нажмите \xE2\x9C\x85";

	$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine4);
}


function vibor_banka($bank=null) { // функция выбора банка

	global $tg, $callbackMessageId, $sms, $callbackQueryId;
	global $callbackChatId, $keyInLine6, $keyInLine_bank, $tehPodderjka;				

	if ($bank!==null) {				
		$spisok_bankov = substr(strrchr($sms, 10), 1);
		if((stripos($spisok_bankov, $bank))===false) {	
			$sms.= $bank.", ";				
		}else {
			$tg->answerCallbackQuery($callbackQueryId, "Такой банк уже был выбран!");		
			exit('ok');		
		}		
		$sms.= "." . $tehPodderjka . "Выберайте любое количество банков/эл.кошельков \xF0\x9F\x91\x87 Когда ".
			"закончите выбирать \xF0\x9F\x91\x89 нажмите *Готово*.";
		$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine_bank);		
	}else {
		$sms.= "." . $tehPodderjka . "Превосходно, теперь выберите с".
			" какими банками/эл.кошельками Вы сотрудничаете? \xF0\x9F\x91\x87 Выбрать можно несколько,".
			" или ввести название банка которого нет в списке. По окончанию жмите *ДАЛЕЕ!*";
		$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine6);		
	}	
}


function vibor_otdela($text) { // функция выбора отдела в категориях PZMarketBota

	global $DopKnopa;

	$otdel = null;
	
	for ($i=1; $i<=12; $i++){
		if ($text==$i) $otdel=$DopKnopa[$i-1];
	}	
	
	return $otdel;	
	
}



function _start_PZMarket_bota($this_admin=false) { // функция старта PZMarketBota

	global $first_name, $tg, $chat_id, $tehPodderjka, $keyboard, $keyboardAdmin;

	$keyB=$keyboard;
	if ($this_admin==true) $keyB=$keyboardAdmin;
	
	_est_li_v_base();
	
    $reply = "Здравствуйте " . $first_name . "! \nДобро пожаловать! \xE2\x9C\x8B\n";
		
	$tg->sendMessage($chat_id, $reply);
	
	$reply  = "✅ *PRIZMarket* ❗️ \n\n▪️*PRIZMarket* - место где можно увидеть ".
		"товары и услуги за PRIZM. {$zakaz}\n\n▪️*КАТЕГОРИИ товаров* - поиск нужного вам товара ".
		"или услуги!\n\n▪️*Курс PRIZM* - актуальна инфа с [CoinMarketCap]".
		"(https://coinmarketcap.com/ru/currencies/prizm/)\n\n▪️*ВЭС* - ".
		"для тех кто понятия не имеет о PRIZM {$tehPodderjka}";		
		
	$tg->sendMessage($chat_id, $reply, markdown, true, null, $keyB);	
	
	
}


function _start_PZMgarant_bota($this_admin=false) {		// функция старта бота БЕЗОПАСНЫХ СДЕЛОК

	global $first_name, $tehPodderjka, $tg, $chat_id, $keyInLine0, $key_one_Admin;
	
	if ($this_admin==true){
	
		$reply = "Здравствуйте *". $first_name . "*! \xE2\x9C\x8B Добро пожаловать в ".
			"*БЕЗОПАСНЫЕ СДЕЛКИ!*";
		$tg->sendMessage($chat_id, $reply, markdown, true, null, $key_one_Admin);
		
		$reply = "Этот бот поможет Вам подать заявку на покупку или продажу *PRIZM.*" . $tehPodderjka .
			"Перед тем как начать, прочитайте \xF0\x9F\x91\x89 [ПРАВИЛА.]".
			"(https://t.me/Secure_deal_PZM/5)\n\nОЗНАКОМИЛИСЬ?! Жмите \xF0\x9F\x91\x87 *ПОДАТЬ ЗАЯВКУ!*";
		
		$tg->sendMessage($chat_id, $reply, markdown, true, null, $keyInLine0);		
		
		exit('ok');
	}
	
	$est_li_v_base=_est_li_v_base();	

	if ($est_li_v_base==true) {		
	
		$est_li_BAN = _est_li_BAN();
		
	}else throw new Exception("Нет такого пользователя");	
	
	
	if ($est_li_BAN=='0') {			
	
		$reply = "Здравствуйте *". $first_name . "*! \xE2\x9C\x8B Добро пожаловать в ".
			"*БЕЗОПАСНЫЕ СДЕЛКИ!* \n\n".	
			"Этот бот поможет Вам подать заявку на покупку или продажу *PRIZM.*" . $tehPodderjka .
			"Перед тем как начать, прочитайте \xF0\x9F\x91\x89 [ПРАВИЛА.]".
			"(https://t.me/Secure_deal_PZM/5)\n\nОЗНАКОМИЛИСЬ?! Жмите \xF0\x9F\x91\x87 *ПОДАТЬ ЗАЯВКУ!*";
		
		$tg->sendMessage($chat_id, $reply, markdown, true, null, $keyInLine0);		
	}
	
}



function _est_li_v_base() { // функция проверки есть ли юзер в базе 

	global $table, $from_id, $first_name, $mysqli, $tg, $admin_group;
	
	$est_li_v_base=false;
	
	$query = "SELECT id_client FROM ". $table; 
	if ($result = $mysqli->query($query)) {					
		if($result->num_rows>0){
			$arrStrok = $result->fetch_all();				
			foreach($arrStrok as $arrS){						
				foreach($arrS as $stroka) if ($stroka==$from_id) $est_li_v_base=true;				
			}												
		}
		$last_id = $result->num_rows;				
	}				
		
	if ($est_li_v_base==false) {				
		$query = "INSERT INTO ".$table." VALUES ('". ++$last_id ."', '". $from_id ."' , '" . $first_name . "', 'client', '0')";
		if ($result = $mysqli->query($query)) {		
			$tg->sendMessage($admin_group, 'Добавлен новый клиент');
			$est_li_v_base=true;	
		}else $tg->sendMessage($admin_group, 'Не смог добавить нового клиента');
	}				

	return $est_li_v_base;
}


function _est_li_BAN() { // функция проверки есть ли у юзера БАН

	global $table, $chat_id, $mysqli;

	$query = "SELECT flag FROM ".$table." WHERE id_client=" . $chat_id;
	if ($result = $mysqli->query($query)) {					
		if($result->num_rows>0){
			$arrStrok = $result->fetch_all();
			foreach($arrStrok as $arrS){
				foreach($arrS as $stroka) $flag_client=$stroka;								
			}								
		}						
	}else throw new Exception("Не смог проверить есть ли БАН у юзера ".$chat_id);	
	
	return $flag_client;
			
}



function _this_admin() { // функция проверки есть ли у юзера БАН

	global $table, $chat_id, $mysqli, $tg, $from_id, $callback_from_id;
	
	$this_admin = false;
	
	// узнаю список администраторов бота и пополняю им массив $admin
	$query = "SELECT id_client FROM ".$table." WHERE status='admin'";
	if ($result = $mysqli->query($query)) {		
	
		$kolS=$result->num_rows;
		if($kolS>0){
			$arrStrok = $result->fetch_all();						
			for ($i=0; $i<$kolS; $i++) {					
				$admin[$i]=$arrStrok[$i][0];		
			}						
		}	
	}else $tg->sendMessage($chat_id, 'Чего то не получается узнать администраторов бота');	


	// Проверяю, кто пишет - админ/юзер
	foreach($admin as $value) if ($from_id==$value||$callback_from_id==$value) $this_admin = true;
	
	return $this_admin;
	
}



function _pechat($text=null, $max_kol_s = '6500') { // функция печати (разбивание сообщения на части)

	global $chat_id, $tg;
	
	$str=null;	
		
	$kol = strlen ($text) ;
	if ($kol>'0'){
		if ($kol<=$max_kol_s){
						
			$tg->sendMessage($chat_id, $text, null, true);				
			
		}else{					
			$len_str=strlen($text);				
			$kolich=$len_str-$max_kol_s;
			$str = substr($text, 0, -$kolich);
			$kol=strlen($str);	
			
			$tg->sendMessage($chat_id, $str, null, true);		
						
			$str = substr($text, $kol);		
			
			_pechat($str, $max_kol_s);
		}		
	}
	
	//return $str;
	
}
	

function _pechat_lotov($chatId, $arrS, $kol, $max) { // функция вывода лотов на экране

	global $tg, $master;
	
	$i = $max;
	
	for ($schetchik=$kol; $schetchik<=$max; $schetchik++){
		
		$otdel=$arrS[$i][1];
		$format=$arrS[$i][2];
		$file_id=$arrS[$i][3];
		$url=$arrS[$i][4];
		$caption1=$arrS[$i][5];
		$caption2=$arrS[$i][6];
		$caption3=$arrS[$i][7];
		$caption4=$arrS[$i][8];
		$caption5=$arrS[$i][9];
		$doverie=$arrS[$i][10];
		$podrobno_url=$arrS[$i][11];
		
		$otdel = str_replace('_', '\_', $otdel);
		$caption1 = str_replace('_', '\_', $caption1);
		$caption2 = str_replace('_', '\_', $caption2);
		$caption3 = str_replace('_', '\_', $caption3);
		$caption4 = str_replace('_', '\_', $caption4);
		$caption5 = str_replace('_', '\_', $caption5);
		//$doverie = str_replace('_', '\_', $doverie);
					
		$caption="{$caption1}\n\n{$otdel}\n[{$caption2}]({$url})\n".
			"{$caption3}\n️{$caption4}\n️{$caption5}";  					
					
		if ($doverie!=='0') $caption.= "\n\n{$doverie}";
				
		$inLineBut1=["text"=>"Подробнее","url"=>$podrobno_url];
		$inLineStr1=[$inLineBut1];
		$inLineKeyb=[$inLineStr1];
		$keyInLine = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLineKeyb);
try{					
		if ($format=='photo'){
			$tg->sendPhoto($chatId, $file_id, $caption, null, $keyInLine, false, markdown); 
		}elseif ($format=='video') {
			$tg->sendVideo($chatId, $file_id, null, $caption, null, $keyInLine, false, false, markdown); 
		}
}catch (Exception $e) {
	$tg->sendMessage($master, 'вот одна ошибка '.$podrobno_url);
}			
		$i--;
			
	}	
	
}

	
	
	
?>