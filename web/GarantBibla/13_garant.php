<?php

/*
**
**--------------------------------------------------
** обработка callback_query <- ответных сообщений!
**--------------------------------------------------
**
*/


$kod = substr(strrchr($callbackText, 10), 1);  // код с id клиента приславшего заказ и номером заказа
	
$kol=strlen($kod);
$sms = substr($callbackText,0,-$kol);	

// текст сообщения после "." - номер заказа
$id_message =  substr(strrchr($kod, '.'), 1); // данные о номере заказа

$kod2 = strstr($kod, '.', true);	
$id_client =  substr(strrchr($kod2, ':'), 1); // айди клиента	
$id_message_chat =  strstr($kod, ':', true);




if ($callbackQuery=="otklon"||$callbackQuery=="prinyat") {	
		
	
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

	$query = "SELECT id_chat FROM ".$table6." WHERE id_admin_group=".$callbackChatId;
	if ($result = $mysqli->query($query)){	
		if($result->num_rows>0){		
		
			$arrayResult = $result->fetch_all(MYSQLI_ASSOC);	
			
			$chat_obmennik = $arrayResult[0]['id_chat'];
			
		}else exit('ok');
	}	
	
}


	
	
if ($callbackQuery=="otklon") { 
	
	// ДЕВЯТАЯ клавиатура кнопка "отклонить"
		
	$query = "DELETE FROM ".$table4." WHERE id_client=" . $id_client;				
	$mysqli->query($query);
		
	//	$query = "UPDATE ".$table." SET flag=0 WHERE id_client=" . $id_client;
	//	$mysqli->query($query);		
		
	$str = $tehPodderjka."Заявка отклонена, читайте правила \xF0\x9F\x91\x87";
		
	$tg->sendMessage($id_client, $str, markdown, true, null, $keyInLine0);
				
	$tg->editMessageText($callbackChatId, $callbackMessageId, "Заявка №".$id_message.
			"\n\n".$sms."\nЗАЯВКУ ОТКЛОНИЛ - @".$callback_user_name);	
	
	
	try{	
		$tg->editMessageText($chat_obmennik, $id_message_chat, $sms."\nЗАЯВКА ОТКЛОНЕНА");
	}catch (Exception $e){
		$tg->sendMessage($master, "Не смог изменить сообщение...\n".
			"номер строки в файле - ".__LINE__."\n".__FILE__."\n".$e->getCode()." ".$e->getMessage());	
	}		
	
	try{
		$tg->deleteMessage($id_client, $id_message);				
	}catch (Exception $e){
		$tg->sendMessage($master, "Выброшено исключение, не смог удалить сообщение...\n".
			"номер строки в файле - ".__LINE__."\n".__FILE__."\n".$e->getCode()." ".$e->getMessage());	
	}	

		
		
}elseif ($callbackQuery=="prinyat") { 
						
	//	$query = "UPDATE ".$table." SET flag=0 WHERE id_client=" . $id_client;
	//	$result = $mysqli->query($query);		


	$MenuStart	= [["Старт", "Настройки"]];	
	$keyboardStartNastr = new \TelegramBot\Api\Types\ReplyKeyboardMarkup($MenuStart, false, true);  
	
	$tg->sendMessage($id_client, "И снова, Здравствуйте!", null, true, null, $keyboardStartNastr);
	
		
	$str = $tehPodderjka."Заявка одобрена, можете сделать новый заказ \xF0\x9F\x91\x87";
		
	$tg->sendMessage($id_client, $str, markdown, true, null, $keyInLine0);		
		
	$tg->editMessageText($callbackChatId, $callbackMessageId, "Заявка №".$id_message.
		"\n\n".$sms."\nЗАЯВКУ ОДОБРИЛ - @".$callback_user_name);
		
	try{
		$tg->deleteMessage($id_client, $id_message);		
	}catch (Exception $e){
		$tg->sendMessage($master, "Выброшено исключение, не смог удалить сообщение...\n".
			"номер строки в файле - ".__LINE__."\n".__FILE__."\n".$e->getCode()." ".$e->getMessage());	
	}	
		
	$user = $tg->getMe();
	$bot_username = $user->getUsername();	
		
	//$inLineKey_menu = [[["text"=>"КуплюПродам","callback_data"=>"kuplu_prodam"]]];
	$inLineKey_menu = [[["text"=>"КуплюПродам","url"=>"t.me/".$bot_username."?start=".$id_message_chat."-".$id_client.$id_message]]]; //":".   ".".
	$keyInLine = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLineKey_menu);
		
	$sms.= $id_message_chat.":".$id_client.".".$id_message;
	
		
	try{
		$tg->editMessageText($chat_obmennik, $id_message_chat, $sms, null, true, $keyInLine);
	}catch (Exception $e){	
		$tg->sendMessage($chat_obmennik, $sms, null, true, null, $keyInLine);
		$tg->deleteMessage($chat_obmennik, $id_message_chat);
	}

//	$tg->sendMessage($chat_obmennik, $sms, null, true, null, $keyInLine);
//	$tg->deleteMessage($chat_obmennik, $id_message_chat);
	
		
		
		
}elseif ($callbackQuery=="kuplu_prodam") { 

		$est_li_v_gruppe = _est_li_v_gruppe();
		
		if ($est_li_v_gruppe) {					
			
			$reply = "Появился потенциальный покупатель!\n".
				"@".$callback_user_name."\nна эту заявку \xF0\x9F\x91\x87\n\n";
			
			$inLineKey_menu = [[["text"=>"Принять заявку","callback_data"=>"prinyal_zayavku_admin"]]];
			$keyInLine = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLineKey_menu);
			
			$tg->sendMessage($est_li_v_gruppe, $reply.$callbackText, null, true, null, $keyInLine);
			
			
			$tg->answerCallbackQuery($callbackQueryId, "Информация отправленна администратору!");
			
		}
}
	




?>