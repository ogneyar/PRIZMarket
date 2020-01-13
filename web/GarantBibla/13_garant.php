<?php

/*id_message
**
**--------------------------------------------------
** обработка callback_query <- ответных сообщений!
**--------------------------------------------------
**
*/

$kod = substr(strrchr($callbackText, 10), 1);  // код с id клиента приславшего заказ и номером заказа

$kol=strlen($kod);
$sms = substr($callbackText,0,-$kol);

if ($callbackQuery!=='prinyal_zayavku_admin'){			

	// текст сообщения после "." - номер заказа
	$id_zakaza =  substr(strrchr($kod, '.'), 1); // данные о номере заказа

	$kod2 = strstr($kod, '.', true);	
	$id_client =  substr(strrchr($kod2, ':'), 1); // айди клиента	
	$id_message_chat =  strstr($kod, ':', true);

}else {				

	// текст сообщения после "-" 
	// номер заказа и айди покупателя
	$id_zakaza_i_pokupatelya =  substr(strrchr($kod, '-'), 1); 
	
	// текст сообщения перед "-" 
	// айди клиента и номер поста в чате
	$id_clienta_i_posta = strstr($kod, '-', true);
	
	// текст после "." - айди покупателя
	$id_pokupatelya =  substr(strrchr($id_zakaza_i_pokupatelya, '.'), 1);
	// текст перед "." - номер заказа
	$id_zakaza = strstr($id_zakaza_i_pokupatelya, '.', true);
	
	// текст после ":" - номер поста в чате
	$id_posta=  substr(strrchr($id_clienta_i_posta, ':'), 1);
	// текст перед ":" - айди клиента
	$id_client  =  strstr($kod, ':', true);
	
}



//if ($callbackQuery=="otklon"||$callbackQuery=="prinyat") {	
		
	
//----------------------------------	
	$this_garant = false;
	$result = $tg->call('getChatAdministrators',
		[
			'chat_id' => $callbackChatId
		]
	);

	foreach($result as $stroka){	
		if ($stroka['user']['id']==$callback_from_id) $this_garant = true;
	}

	if ($this_garant == false) {
		$tg->answerCallbackQuery($callbackQueryId, "Вы не являетесь администратором этого чата!");	
		exit('ok');	
	}
//---------------------------------

	$query = "SELECT id_chat, chat_url FROM ".$table6." WHERE id_admin_group=".$callbackChatId;
	if ($result = $mysqli->query($query)){	
		if($result->num_rows>0){		
		
			$arrayResult = $result->fetch_all(MYSQLI_ASSOC);	
			
			$chat_obmennik = $arrayResult[0]['id_chat'];
			$chat_url = $arrayResult[0]['chat_url'];
			
		}else exit('ok');
	}	
	
//}


	
	
if ($callbackQuery=="otklon") { 
	
	// ДЕВЯТАЯ клавиатура кнопка "отклонить"
		
	$query = "DELETE FROM ".$table4." WHERE id_client=" . $id_client;				
	$mysqli->query($query);
		
	//	$query = "UPDATE ".$table." SET flag=0 WHERE id_client=" . $id_client;
	//	$mysqli->query($query);		
		
	$str = "Ваша заявка отклонена Администрацией p2p-обменника - ".$chat_url."\n\n".
		"читайте правила \xF0\x9F\x91\x87".$tehPodderjka;
		
	$tg->sendMessage($id_client, $str, markdown, true, null, $keyInLine0);
				
	$tg->editMessageText($callbackChatId, $callbackMessageId, $sms."\nЗАЯВКУ ОТКЛОНИЛ - @".$callback_user_name);	
	
	
	try{	
		$tg->editMessageText($chat_obmennik, $id_message_chat, $sms."\nЗАЯВКА ОТКЛОНЕНА");
	}catch (Exception $e){
		$tg->sendMessage($master, "Не смог изменить сообщение...\n".
			"номер строки в файле - ".__LINE__."\n".__FILE__."\n".$e->getCode()." ".$e->getMessage());	
	}		
	
/*	
	try{
		$tg->deleteMessage($id_client, $id_zakaza);				
	}catch (Exception $e){
		$tg->sendMessage($master, "Выброшено исключение, не смог удалить сообщение...\n".
			"номер строки в файле - ".__LINE__."\n".__FILE__."\n".$e->getCode()." ".$e->getMessage());	
	}	
*/
		
		
}elseif ($callbackQuery=="prinyat") { 
						
	//	$query = "UPDATE ".$table." SET flag=0 WHERE id_client=" . $id_client;
	//	$result = $mysqli->query($query);		

	
	$tg->sendMessage($id_client, "И снова, Здравствуйте!", null, true, null, $keyboardStartNastr);
	
		
	$str = "Ваша заявка одобрена Администрацией p2p-обменника - ".$chat_url."\n\n".
		"Как появится клиент на Вашу заявку - Я Вам сообщу! Будьде бдительны, если Вам кто либо напишиет ".
		"в личку, знайте - это МОШЕННИКИ. Они могут представиться Администратором, Гарантом или ещё кем.. ".
		"\n\n сообщите об этом в чат p2p-обменника!\n\nДля подачи новой заявки - нажмите /start".
		$tehPodderjka;
		
	$tg->sendMessage($id_client, $str, markdown);		//, true, null, $keyInLine0
		
	$tg->editMessageText($callbackChatId, $callbackMessageId, "Заявка №".$id_zakaza.
		"\n\n".$sms."\nЗАЯВКУ ОДОБРИЛ - @".$callback_user_name);

/*		
	try{
		$tg->deleteMessage($id_client, $id_zakaza);		
	}catch (Exception $e){
		$tg->sendMessage($master, "Выброшено исключение, не смог удалить сообщение...\n".
			"номер строки в файле - ".__LINE__."\n".__FILE__."\n".$e->getCode()." ".$e->getMessage());	
	}	
*/	
	
		
	//$inLineKey_menu = [[["text"=>"КуплюПродам","callback_data"=>"kuplu_prodam"]]];
	$inLineKey_menu = [[["text"=>"КуплюПродам","url"=>"t.me/".$username_bot."?start=".
		$id_message_chat."-".$id_zakaza]]]; //":" и "." не подходят
	$keyInLine = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLineKey_menu);
		
	$sms.= $id_message_chat.":".$id_client.".".$id_zakaza;
	
		
	try{
		$tg->editMessageText($chat_obmennik, $id_message_chat, $sms, null, true, $keyInLine);
	}catch (Exception $e){	
		$tg->sendMessage($chat_obmennik, $sms, null, true, null, $keyInLine);
		$tg->deleteMessage($chat_obmennik, $id_message_chat);
	}

//	$tg->sendMessage($chat_obmennik, $sms, null, true, null, $keyInLine);
//	$tg->deleteMessage($chat_obmennik, $id_message_chat);
	
		
		
		
}elseif ($callbackQuery=="kuplu_prodam") { 
/*
		$est_li_v_gruppe = _est_li_v_gruppe();
		
		if ($est_li_v_gruppe) {					
			
			$reply = "Появился потенциальный покупатель!\n".
				"@".$callback_user_name."\nна эту заявку \xF0\x9F\x91\x87\n\n";
			
			$inLineKey_menu = [[["text"=>"Принять заявку","callback_data"=>"prinyal_zayavku_admin"]]];
			$keyInLine = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLineKey_menu);
			
			$tg->sendMessage($est_li_v_gruppe, $reply.$callbackText, null, true, null, $keyInLine);
			
			
			$tg->answerCallbackQuery($callbackQueryId, "Информация отправленна администратору!");
			
		}
*/
}elseif ($callbackQuery=="prinyal_zayavku_admin") { 

	$chat_garant = $callbackChatId;	
	
	$query = "SELECT flag_isp FROM ". $table4 . " WHERE id_zakaz=".$id_zakaza; 
	if ($result = $mysqli->query($query)) {					
		if($result->num_rows>0){
			$arrayResult = $result->fetch_all(MYSQLI_ASSOC);
			if ($arrayResult[0]['flag_isp']!=='0') {
				$tg->answerCallbackQuery($callbackQueryId, "Заявка уже занята!");	
				exit('ok');
			}
		}else exit('ok');
	}else exit('ok');
	
	$query = "UPDATE ".$table4." SET flag_isp='1' WHERE id_zakaz=".$id_zakaza;
	if ($result = $mysqli->query($query)) {
		$tg->editMessageText($chat_garant, $callbackMessageId, $callbackText.
			"\n\nЗаявка ЗАРЕЗЕРВИРОВАНА\nГарант: @".$callback_user_name);
	}else exit('ok');
	
	$tg->sendMessage($id_pokupatelya, "Ваш гарант: @".$callback_user_name.
		"\nнапишите ему в личку, нажав на эту ссылку, он ожидает Вас!");
	
	$tg->sendMessage($id_client, "Появился покупатель на Вашу заявку.\n\nВаш гарант: @".
		$callback_user_name."\nнапишите ему в личку, нажав на эту ссылку, он ожидает Вас!");

	$tg->answerCallbackQuery($callbackQueryId, "Ожидайте, клиенты уведомлены!", true);

	try{
		$tg->editMessageReplyMarkup($chat_obmennik, $id_posta);
	}catch(Exception $e){
		$tg->sendMessage($master, "Выброшен эксцепшн..\nна линии - ".__LINE__."\n".__FILE__);
	}


}
	




?>