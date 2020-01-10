<?php

// текст сообщения до "."
$sms = strstr($callbackText, '.', true);
$str = $sms;
// переменная последнего символа и предпоследнего
$simbol = substr($sms, -1);
$simbol2 = substr($sms, -2);


/*
**
** +--------------------------+
** | ОПРОС КОМАНД  - INLINE - |
** +--------------------------+
**
*/
	
if ($callbackQuery=="nachalo") {

	udalenie_starih_zapisey($table2);
	udalenie_starih_zapisey($table3);

	if ($callback_user_name=='неизвестно') {	
		$sms = "Обязательно укажите @username в профиле своего аккаунта. Без @username".
			" заявки не принимаются, читайте ПРАВИЛА.";
		$tg->answerCallbackQuery($callbackQueryId, $sms, true);
	}else{
		$sms = "Что бы вы хотели сделать, *продать* имеющиеся у Вас монеты *PZM* или *приобрести?*" . $tehPodderjka . 
			"Выберите позицию! \xF0\x9F\x91\x87";
	
		$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine1);
	}		
	
	
	
}elseif ($callbackQuery=="rassmotrenie") {

	$tg->answerCallbackQuery($callbackQueryId, "Ожидайте!!!");	
	
	

}elseif ($callbackQuery=="menu") {
	
	udalenie_starih_zapisey($table2);
	udalenie_starih_zapisey($table3);
	
	$sms = "Здравствуйте *". $first_name . "*! \xE2\x9C\x8B Добро пожаловать в ".
			"*БЕЗОПАСНЫЕ СДЕЛКИ!* \n\n".	
			"Этот бот поможет Вам подать заявку на покупку или продажу *PRIZM.*" . $tehPodderjka .
			"Перед тем как начать, прочитайте \xF0\x9F\x91\x89 [ПРАВИЛА.]".
			"(https://t.me/Secure_deal_PZM/5)\n\nОЗНАКОМИЛИСЬ?! Жмите \xF0\x9F\x91\x87 *ПОДАТЬ ЗАЯВКУ!*";
		
	$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine0);




//УСТАРЕВШАЯ КНОПКА С ПЕРЕХОДОМ НА ВЫБОР КРИПТОВАЛЮТ
}elseif ($callbackQuery=="teg1") {
	$sms = "\xF0\x9F\x97\xA3 #продам\n." . $tehPodderjka . "Хорошо, выберите валюту, которую хотите продать \xF0\x9F\x91\x87";			
	$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine2);				
}elseif ($callbackQuery=="teg2") { //УСТАРЕВШАЯ КНОПКА С ПЕРЕХОДОМ НА ВЫБОР КРИПТОВАЛЮТ	
		$sms = "\xF0\x9F\x97\xA3 #куплю\n." . $tehPodderjka . "Хорошо, ".
			"выберите валюту, которую хотите купить \xF0\x9F\x91\x87";				
		$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine2);				
//УСТАРЕВШАЯ КНОПКА С ПЕРЕХОДОМ НА ВЫБОР КРИПТОВАЛЮТ	



	
}elseif ($callbackQuery=="prodam") {
	
	udalenie_starih_zapisey($table2);	
	kuplu_prodam_vibor('продам');

}elseif ($callbackQuery=="kuplu") {

	udalenie_starih_zapisey($table2);
	kuplu_prodam_vibor('куплю');

}elseif ($callbackQuery=="nazad_v_nachalo") {

	udalenie_starih_zapisey($table2);

	$sms = "Здравствуйте *". $callback_first_name . "*! \xE2\x9C\x8B Добро пожаловать в *БЕЗОПАСНЫЕ СДЕЛКИ!* \n\n".	
		"Этот бот поможет Вам подать заявку на покупку или продажу *PRIZM.*" . $tehPodderjka .
		"Перед тем как начать, прочитайте \xF0\x9F\x91\x89 [ПРАВИЛА.]".
		"(https://t.me/Secure_deal_PZM/5)\n\nОЗНАКОМИЛИСЬ?! ".
		"Жмите \xF0\x9F\x91\x87 *ПОДАТЬ ЗАЯВКУ!*";
	
	$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine0);	
	
	
		
		
// ВТОРАЯ клавиатура ОТКЛЮЧЕНА!!! С ПЕРВОЙ ПЕРЕХОД СРАЗУ НА ТРЕТЬЮ!
}elseif ($callbackQuery=="nal1") {
		$sms.= "PZM\n." . $tehPodderjka . "Отлично, теперь *введите КОЛИЧЕСТВО*, огромная просьба \xF0\x9F\x99\x8F".
			" делайте это не спеша, а после нажмите \xE2\x9C\x85";
		$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine3);		
}elseif ($callbackQuery=="nal2"||$callbackQuery=="nal3") {
		$sms = "\xE2\x9D\x97 Нет ещё возможности выбрать эту позицию.";
		$tg->answerCallbackQuery($callbackQueryId, $sms);				
// МОЖЕТ ПОЗЖЕ ЕЁ ПОДКЛЮЧУ!
		
		
$kolichestvo = 'КОЛИЧЕСТВО монет';
		
// ОБРАТИ ВНИМАНИЕ  это 3я клавиатура для ввода КОЛИЧЕСТВА которое хотят #продать/#купить	
}elseif ($callbackQuery=="key1") { // 1		
		num_keybord('1', $kolichestvo, $keyInLine3);		
}elseif ($callbackQuery=="key2") { // 2		
		num_keybord('2', $kolichestvo, $keyInLine3);		
}elseif ($callbackQuery=="key3") { // 3		
		num_keybord('3', $kolichestvo, $keyInLine3);		
}elseif ($callbackQuery=="key4") { // 4		
		num_keybord('4', $kolichestvo, $keyInLine3);		
}elseif ($callbackQuery=="key5") { // 5		
		num_keybord('5', $kolichestvo, $keyInLine3);		
}elseif ($callbackQuery=="key6") { // 6	
		num_keybord('6', $kolichestvo, $keyInLine3);		
}elseif ($callbackQuery=="key7") { // 7		
		num_keybord('7', $kolichestvo, $keyInLine3);		
}elseif ($callbackQuery=="key8") { // 8		
		num_keybord('8', $kolichestvo, $keyInLine3);		
}elseif ($callbackQuery=="key9") { // 9		
		num_keybord('9', $kolichestvo, $keyInLine3);		
}elseif ($callbackQuery=="key10") { // НОЛЬ	
		num_keybord('0', $kolichestvo, $keyInLine3);		
}elseif ($callbackQuery=="key11") { // 0 0 		
		num_keybord('20', $kolichestvo, $keyInLine3);		
}elseif ($callbackQuery=="key12") { // 0 0 0	
		num_keybord('30', $kolichestvo, $keyInLine3);		
}elseif ($callbackQuery=="key13") { // НАЗАД	
		num_keybord('50', $kolichestvo, $keyInLine3);		
}elseif ($callbackQuery=="key14") { // запятая	
		num_keybord('90', $kolichestvo, $keyInLine3);		
}elseif ($callbackQuery=="key15") { // ВВОД		

	
	$query = "SELECT id, knopka FROM ". $table2 ." WHERE id_client=". $callback_from_id ." ORDER BY id"; 
	if ($result = $mysqli->query($query)) {						
		$last_id=$result->num_rows;
		if($last_id>0){
			$arrStrok = $result->fetch_all();						
			for ($i=0; $i<$last_id; $i++) $summa.=$arrStrok[$i]['1'];			
		}else {
			$sms = "Нет введённых данных\xE2\x9D\x97\xE2\x9D\x97\xE2\x9D\x97";
			$tg->answerCallbackQuery($callbackQueryId, $sms);			
			exit('ok');
		}
	}
	
	$sum=str_replace(',', '.', $summa);
	
	if ($sum==0) {
		$sms = "Нужно ввести больше чем ноль\xE2\x9D\x97\xE2\x9D\x97\xE2\x9D\x97";
		$tg->answerCallbackQuery($callbackQueryId, $sms);			
		exit('ok');
	}	
	
	$query = "UPDATE ".$table3." SET kol_monet='".$sum."' WHERE id_client=" . $callback_from_id;
	$mysqli->query($query);
	
	$query = "INSERT INTO ".$table2." VALUES ('". $callback_from_id ."', '0' , '0', '1', '0')";	
	$mysqli->query($query);	

	$query = "DELETE FROM ".$table2." WHERE id_client=" . $callback_from_id . " AND id>'0'";
	$mysqli->query($query);	
	
	$sms = strstr($str, 10, true);

	$sms.= "\n\xF0\x9F\x92\xB0 " . $summa . " PZM";
			
	$sms.= "\n." . $tehPodderjka . "Замечательно, а сейчас выберите *валюту* \xF0\x9F\x91\x87";
	$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine5);



	
			

//УСТАРЕВШАЯ КНОПКА С ПЕРЕХОДОМ НА ВТОРУЮ КЛАВИАТУРУ	 
}elseif ($callbackQuery=="nazad_iz_kol") { 	 
	$number_str = strpos($str, 10);	
	$len_str=strlen($str);	
	$kolich=$len_str-$number_str;
	$sms = substr($str, 0, -$kolich);	
	$sms.= "\n." . $tehPodderjka . "Хорошо, выберите валюту \xF0\x9F\x91\x87";	
	$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine2);			
//СЕЙЧАС ТАМ ПЕРЕХОД В НАЧАЛО

		
		

}elseif ($callbackQuery=="rubl") { // ДЕЙСТВИЯ ПОСЛЕ выбора валюты
	
	udalenie_starih_zapisey($table2);
	vibor_valut("\xE2\x82\xBD");

}elseif ($callbackQuery=="dollar") {
	
	udalenie_starih_zapisey($table2);
	vibor_valut('$');

}elseif ($callbackQuery=="BTC") { // ДЕЙСТВИЯ ПОСЛЕ выбора валюты
	
	udalenie_starih_zapisey($table2);
	vibor_valut('BTC');
		
}elseif ($callbackQuery=="Efirium") {
	
	udalenie_starih_zapisey($table2);
	vibor_valut('ETH');

}elseif ($callbackQuery=="nazad_iz_val") {

/*	УСТАРЕВШАЯ, ЗМЕНЁННАЯ КНОПКА С ПЕРЕХОДОМ НА ВТОРУЮ КЛАВИАТУРУ	
	$number_str = strpos($str, 10);	
	$len_str=strlen($str);	
	$kolich=$len_str-$number_str;
	$sms = substr($str, 0, -$kolich);	
	$sms.= "\n." . $tehPodderjka . "Хорошо, выберите валюту \xF0\x9F\x91\x87";	
	$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine2);	
*/
	udalenie_starih_zapisey($table2);
	
	$str = substr($sms,0,-1);	// удаляем первый символ
	$last = substr(strrchr($str, 10), 1);
	$kol=strlen($last);
	$sms = substr($str,0,-$kol);
	$sms.="PZM\n." . $tehPodderjka . "Отлично, теперь *введите КОЛИЧЕСТВО монет*,".
		" огромная просьба \xF0\x9F\x99\x8F делайте это не спеша, а после нажмите \xE2\x9C\x85";			
	$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine3);	
	
	
	
	
// ОБРАТИ ВНИМАНИЕ  это ЧЕТВЁРТАЯ клавиатура для ввода ЦЕНЫ за которую хотят #продать/#купить
}elseif ($callbackQuery=="4key1") { //  1		
		num_keybord('1', $cenaText, $keyInLine4);		
}elseif ($callbackQuery=="4key2") { //  2	
		num_keybord('2', $cenaText, $keyInLine4);		
}elseif ($callbackQuery=="4key3") { //  3	
		num_keybord('3', $cenaText, $keyInLine4);		
}elseif ($callbackQuery=="4key4") { //  4	
		num_keybord('4', $cenaText, $keyInLine4);		
}elseif ($callbackQuery=="4key5") { //  5	
		num_keybord('5', $cenaText, $keyInLine4);		
}elseif ($callbackQuery=="4key6") { //  6	
		num_keybord('6', $cenaText, $keyInLine4);		
}elseif ($callbackQuery=="4key7") { //  7	
		num_keybord('7', $cenaText, $keyInLine4);		
}elseif ($callbackQuery=="4key8") { //  8	
		num_keybord('8', $cenaText, $keyInLine4);		
}elseif ($callbackQuery=="4key9") { //  9	
		num_keybord('9', $cenaText, $keyInLine4);		
}elseif ($callbackQuery=="4key10") { //  0 				
		num_keybord('0', $cenaText, $keyInLine4);			
}elseif ($callbackQuery=="4key11") { //  0 0		
		num_keybord('20', $cenaText, $keyInLine4); 				
}elseif ($callbackQuery=="4key12") { // 0 0 0 	
		num_keybord('30', $cenaText, $keyInLine4); 		
}elseif ($callbackQuery=="4key13") { // удаление последней введёной цифры	
		num_keybord('50', $cenaText, $keyInLine4); 		
}elseif ($callbackQuery=="4key14") { // запятая	
		num_keybord('90', $cenaText, $keyInLine4);
}elseif ($callbackQuery=="4key15") { // ВВОД		
		
	$query = "SELECT id, knopka FROM ". $table2 ." WHERE id_client=". $callback_from_id ." ORDER BY id"; 
	if ($result = $mysqli->query($query)) {						
		$last_id=$result->num_rows;
		if($last_id>0){
			$arrStrok = $result->fetch_all();						
			for ($i=0; $i<$last_id; $i++) $summa.=$arrStrok[$i]['1'];			
		}else {
			$sms = "Нет введённых данных\xE2\x9D\x97\xE2\x9D\x97\xE2\x9D\x97";
			$tg->answerCallbackQuery($callbackQueryId, $sms);			
			exit('ok');
		}
	}
	
	$sum=str_replace(',', '.', $summa);
	
	if ($sum==0) {
		$sms = "Нужно ввести больше чем ноль\xE2\x9D\x97\xE2\x9D\x97\xE2\x9D\x97";
		$tg->answerCallbackQuery($callbackQueryId, $sms);			
		exit('ok');
	}	
	
	$query = "UPDATE ".$table3." SET cena='".$sum."' WHERE id_client=" . $callback_from_id;
	$mysqli->query($query);
	
	$query = "INSERT INTO ".$table2." VALUES ('". $callback_from_id ."', '0' , '0', '1', '0')";	
	$mysqli->query($query);	

	$query = "DELETE FROM ".$table2." WHERE id_client=" . $callback_from_id . " AND id>'0'";
	$mysqli->query($query);	
	
	$sms1 = strstr($str, 10, true);
	$kol=strlen($sms1)+1;			
	$sms = substr($str, $kol);
	$sms2 = strstr($sms, 10, true);	
	
	$cena = substr(strrchr($str, 10), 1);  // это цена!!!
	$kol=strlen($cena)+1;				
	$sms = substr($str,0,-$kol);	
			
	$valut = substr(strrchr($sms, 10), 1);   // это валюта!	
	
	$pzm = substr(strrchr($sms2, ' '), 0);
	$kol=strlen($pzm);
	$sms = substr($sms2,0,-$kol);	
		
	$kol_pzm = substr(strrchr($sms, ' '), 1);  // количество монет
		
	$itogo = str_replace(',', '.', $kol_pzm) * str_replace(',', '.', $cena);	

	$query = "UPDATE ".$table3." SET itog='".$itogo."' WHERE id_client=" . $callback_from_id;
	$mysqli->query($query);
		
	$itog = str_replace('.', ',', $itogo);
		
	$str = $sms1 . "\n". $sms2. "\n";		
			
	$str.= "\xF0\x9F\x92\xB8 ".$cena." ".$valut."\n*ИТОГО:* ".$kol_pzm." x ".$cena." = *".$itog."* ".$valut;	  
		
	$str.= "\n." . $tehPodderjka . "Превосходно, теперь выберите с какими банками/эл.кошельками Вы сотрудничаете?".
			" \xF0\x9F\x91\x87 Выбрать можно несколько, или ввести название банка которого нет в ".
			"списке. По окончанию жмите *ДАЛЕЕ!*";
	$tg->editMessageText($callbackChatId, $callbackMessageId, $str, markdown, true, $keyInLine6);
	
			

}elseif ($callbackQuery=="nazad_iz_ceni") { // Шаг НАЗАД
	
	udalenie_starih_zapisey($table2);
	
	$number_str = strpos($str, 10);		
	$len_str=strlen($str);	
	$kolich=$len_str-$number_str;
	$Pervaya_Stroka = substr($str, 0, -$kolich);	
	
	$sms = substr($str, $number_str+1);
		
	$number_str = strpos($sms, 10);		
	$len_str=strlen($sms);	
	$kolich=$len_str-$number_str;
	$Vtoraya_Stroka = substr($sms, 0, -$kolich);	
	
	$sms = $Pervaya_Stroka . "\n" . $Vtoraya_Stroka . "\n." . $tehPodderjka . "Замечательно, ".
		"а сейчас выберите *валюту* \xF0\x9F\x91\x87";				
		
	$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine5);	

	
	
	
	
}elseif ($callbackQuery=="bank1") {
	
	vibor_banka("Сбербанк");

}elseif ($callbackQuery=="bank2") {	
	
	vibor_banka("Альфа");

}elseif ($callbackQuery=="bank3") {
	
	vibor_banka("Тинькофф");

}elseif ($callbackQuery=="bank4") {
	
	vibor_banka("РусСтандарт");

}elseif ($callbackQuery=="bank5") {
	
	vibor_banka("ВТБ");
	
}elseif ($callbackQuery=="bank6") {
	
	vibor_banka("QIWI");

}elseif ($callbackQuery=="bank7") {
	
	vibor_banka("ЯД");

}elseif ($callbackQuery=="bank8") {
	
	vibor_banka("Advcash");

}elseif ($callbackQuery=="bank9") {
	
	vibor_banka("Payeer");
	
}elseif ($callbackQuery=="bank10") {
	
	vibor_banka("ePayment's");
	
}elseif ($callbackQuery=="gotovo_bank") {
	
	vibor_banka();		
		
}elseif ($callbackQuery=="vibor_banka") {
	
	$sms.= "." . $tehPodderjka . "Выберайте любое количество банков/эл.кошельков \xF0\x9F\x91\x87 Когда закончите".
			" выбирать \xF0\x9F\x91\x89 нажмите *Готово*.";
	$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine_bank);	
			
		
}elseif ($callbackQuery=="vvod_banka") {
	
		$str = "\xE2\x9D\x97 В -ответном сообщении- введите название своего банка \xE2\x9D\x97";
		$tg->answerCallbackQuery($callbackQueryId, $str);						
		
		$sms.= "b." . $tehPodderjka . "Жду ввода названия \xF0\x9F\x91\x87 (в ответ на это сообщение)";		
		
		$tg->sendMessage($callbackChatId, $sms, markdown, true, null, $forceRep);
		$tg->deleteMessage($callbackChatId, $callbackMessageId);		
	
	
}elseif ($callbackQuery=="ochist_bank") {	
	
	$last = substr(strrchr($str, 10), 1);
	$kol=strlen($last);
	if ($kol=='0') {
		$tg->answerCallbackQuery($callbackQueryId, "Нет данных для очистки!");			
	}else {
		$sms = substr($str,0,-$kol);		
		$sms.= "." . $tehPodderjka . "Превосходно, теперь выберите с какими банками Вы сотрудничаете?".
			" \xF0\x9F\x91\x87 Выбрать можно несколько, или ввести название банка которого нет в ".
			"списке. По окончанию жмите *ДАЛЕЕ!*";
		$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine6);	
	}				
		
}elseif ($callbackQuery=="nazad_iz_banka") { 			
			
	udalenie_starih_zapisey($table2);
	
	$last = substr(strrchr($sms, 10), 0);
	$kol=strlen($last);
	$str = substr($sms,0,-$kol);
			
	$last2 = substr(strrchr($str, 10), 0);
	$kol2=strlen($last2);
	$sms = substr($str,0,-$kol2);

	$valuta = substr(strrchr($sms, ' '), 1);
	$last3 = substr(strrchr($sms, 10), 1);
	$kol=strlen($last3);
	$str = substr($sms,0,-$kol);	
		
	$price=_PricePZM_in_Monet($valuta);	
	
	$sms = $str . $valuta;
			
	$sms.= "\n.\n[{$price}](https://coinmarketcap.com/ru/currencies/prizm/)" . $tehPodderjka . "Отлично, теперь *введите ".$cenaText."*, огромная просьба".
		" \xF0\x9F\x99\x8F делайте это не спеша, а после нажмите \xE2\x9C\x85";	
		
	$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine4);			
		
		
}elseif ($callbackQuery=="dalee_iz_banka") {
	
	udalenie_starih_zapisey($table2);
				
	if ($simbol2==', ') {
		
		$str = substr($sms,0,-2);	
		
		$spisok_bankov = substr(strrchr($str, 10), 1);
		
		$Sbanks=str_replace("'", "\'", $spisok_bankov);
		
		$query = "UPDATE ".$table3." SET bank='".$Sbanks."' WHERE id_client=" . $callback_from_id;
		$mysqli->query($query);	
				
		$kol=strlen($spisok_bankov);
		$sms = substr($str,0,-$kol);	
		$sms.= "\xF0\x9F\x8F\xA6 " . $spisok_bankov;					
			
		$sms.= "\n." . $tehPodderjka . "Великолепно, осталось 'дело за малым'!\n".
			"Если Вы ознакомились с [Правилами](https://t.me/Secure_deal_PZM/5)\xF0\x9F\x91\x88 и ".
			"согласны с указанными в них условиями *PRIZMarket-Гарант*, жмите \xF0\x9F\x91\x87 *Согласен(на)*";
		$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine7);	
			
	}else {
			
		$sms = "\xE2\x9D\x97 Выберите банк из списка " . $first_name . ", или введите название своего банка нажав на кнопку 'Ввести свой' \xE2\x9D\x97";
		$tg->answerCallbackQuery($callbackQueryId, $sms, true);				
	}
		
		
		
// СЕДЬМАЯ клавиатура


//УСТАРЕВШИЕ КНОПКИ ------------------------------------
//------------------------------------------------------
}elseif ($callbackQuery=="dobav_garanta") {	
		$str = "\xE2\x9D\x97 В -ответном сообщении- введите -@username- гаранта \xE2\x9D\x97";
		$tg->answerCallbackQuery($callbackQueryId, $str);										
		$sms.= "g." . $tehPodderjka . "Жду ввода -@username- \xF0\x9F\x91\x87 (в ответ на это сообщение)";			
		$tg->sendMessage($callbackChatId, $sms, markdown, true, null, $forceRep);
		$tg->deleteMessage($callbackChatId, $callbackMessageId);		
}elseif ($callbackQuery=="bez_garanta") {			
		$str = "\xE2\x9D\x97 Без гаранта не работаем \xE2\x9D\x97";
		$tg->answerCallbackQuery($callbackQueryId, $str, true);								
}elseif ($callbackQuery=="garant_privet") {			
		$sms.= "\xF0\x9F\x91\xA8\xE2\x80\x8D\xE2\x9A\x96\xEF\xB8\x8F Гарант \xF0\x9F\xA4\x9D\n." . $tehPodderjka . 		"Чудесно! Всё, заявка готова! Для отправки её администратору".
			" *Безопасных сделок* нажмите *Готово!* \xF0\x9F\x91\x87";
		$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine8);	
}elseif ($callbackQuery=="nazad_garant") {		
	$str = substr($sms,0,-1);
	$last = substr(strrchr($str, 10), 1);
	$kol=strlen($last);
	$sms = substr($str,0,-$kol);			
	$sms.= "." . $tehPodderjka . "Превосходно, теперь выберите с какими банками Вы сотрудничаете? \xF0\x9F\x91\x87 ".
		"Выбрать можно несколько, или ввести название банка которого нет в списке. По окончанию жмите *ДАЛЕЕ!*";
	$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine6);	
//------------------------------------------------------
//УСТАРЕВШИЕ КНОПКИ ------------------------------------					
		
		
		
}elseif ($callbackQuery=="soglasen") {
	
	if ($callback_user_name=='неизвестно') {
		$sms = "Извините, не могу принять заявку, т.к. у Вас отсутствует @username, введите его в профиле".
			" своего аккаунта." . $tehPodderjka . "Обязательно ознакомьтесь с [ПРАВИЛАМИ.]".
			"(https://t.me/Secure_deal_PZM/5) \xF0\x9F\x91\x87";
		$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine0);
	}else {

	
		$query = "UPDATE ".$table3." SET id_zakaz='".$callbackMessageId."' WHERE id_client=" . $callback_from_id;
		$mysqli->query($query);
			
		$sms.= "." . $tehPodderjka . "Чудесно! Всё, заявка готова! Для отправки её в чат-обменник нажмите *Отправить!* \xF0\x9F\x91\x87";
					
		$inLine10_but1=["text"=>"Отправить!","switch_inline_query"=>$callbackMessageId];
		$inLine10_but2=["text"=>"в НАЧАЛО","callback_data"=>"menu"];
		//$inLine10_but9=["text"=>"Шаг НАЗАД","callback_data"=>"nazad_k_garant"];
		$inLine10_str1=[$inLine10_but1];
		$inLine10_str2=[$inLine10_but2];		
		$inLine10_keyb=[$inLine10_str1, $inLine10_str2];
		$keyInLine10 = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLine10_keyb);
				
		$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine10);
	
	}
	
	
	
// ЭТА КНОПКА ОТКЛЮЧЕНА И НЕ ИСПОЛЬЗУЕТСЯ	
}elseif ($callbackQuery=="otpravka") {
	
	// ВОСЬМАЯ клавиатура с кнопкой "ГОТОВО"
	
	if ($callback_user_name=='неизвестно') {
		$sms = "Извините, не могу принять заявку, т.к. у Вас отсутствует @username, введите его в профиле".
			" своего аккаунта." . $tehPodderjka . "Обязательно ознакомьтесь с [ПРАВИЛАМИ.]".
			"(https://t.me/Secure_deal_PZM/5) \xF0\x9F\x91\x87";
		$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine0);
	}else {
		
	
		$est_li_v_base=false;
	
		$query = "SELECT id_client FROM ".$table;
		if ($result = $mysqli->query($query)) {			
			if($result->num_rows>0){
				$arrStrok = $result->fetch_all();				
				foreach($arrStrok as $arrS){					
					foreach($arrS as $stroka) if ($stroka==$callback_from_id) $est_li_v_base=true;	
				}												
			}						
		}
		
		if ($est_li_v_base==true) {
			$query = "SELECT flag FROM ".$table." WHERE id_client=" . $callback_from_id;
			if ($result = $mysqli->query($query)) {		
				if($result->num_rows>0){
					$arrStrok = $result->fetch_all();
					foreach($arrStrok as $arrS){
						foreach($arrS as $stroka) $flag_client=$stroka;								
					}								
				}				
			}
		}		
		
		if ($est_li_v_base==false) {
			$query = "INSERT INTO ".$table." VALUES ('". $callback_from_id ."' , '" . $callback_first_name . "', '". $callback_user_name ."' , 'client', '0')";
			if ($result = $mysqli->query($query)) {	
				$tg->sendMessage($admin_group, 'Добавлен новый клиент');
				$flag_client='0';				
			}else $tg->sendMessage($admin_group, 'Не смог добавить нового клиента');
		}		
		
		if ($flag_client=='0') {
		
			$query = "UPDATE ".$table." SET flag=1 WHERE id_client=" . $callback_from_id;
			if ($result = $mysqli->query($query)) {		
		
				$query = "SELECT valuta FROM ".$table3." WHERE id_zakaz=" . $callbackMessageId;
				$result=$mysqli->query($query);		
				if ($result->num_rows>0){
					$arrayStrok = $result->fetch_all();
					$price=_PricePZM_in_Monet($arrayStrok[0][0]);
				}				
		
				$sms.= "\xF0\x9F\x91\xA4 ```@" . $callback_user_name . "```\n\n{$price}\n" . $callback_from_id . "." . $callbackMessageId;
				$tg->sendMessage($admin_group, $sms, markdown, true, null, $keyInLine9);
				
				$str = "Ваша заказ отправлен Администратору, ожидайте ответа..." . $tehPodderjka ;
				$tg->editMessageText($callbackChatId, $callbackMessageId, $str, markdown);		
			
			}else $tg->sendMessage($admin_group, "Не получается обновить флаг клиента". $callback_from_id);		 		
		}else $tg->answerCallbackQuery($callbackQueryId, "Ожидайте!!!");			
		
	}				

	
//ЭТУ КНОПКУ ТОЖЕ ОТКЛЮЧИЛ ЗА НЕНАДОБНОСТЬЮ	
}elseif ($callbackQuery=="nazad_k_garant") {
	//  клавиатура с кнопкой "Шаг НАЗАД" к выбору гаранта
/*	$str = substr($sms,0,-1);						
	$last = substr(strrchr($str, 10), 1);
	$kol=strlen($last);
	$sms = substr($str,0,-$kol);		*/			
	$sms.= "." . $tehPodderjka . "Великолепно, осталось 'дело за мылым'!\n".
			"Если Вы ознакомились с [Правилами](https://t.me/Secure_deal_PZM/5)\xF0\x9F\x91\x88 и ".
			"согласны с указанными в них условиями *PRIZMarket-Гарант*, жмите \xF0\x9F\x91\x87 *Согласен(на)*";
	$tg->editMessageText($callbackChatId, $callbackMessageId, $sms, markdown, true, $keyInLine7);
}	
//-------------------------------------------
//-------------------------------------------





?>