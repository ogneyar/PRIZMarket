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
	$id_p2p_id_zakaza =  strstr($kod, ':', true);
	
	$id_chata =  substr(strrchr($id_p2p_id_zakaza, '-'), 1);
	

}else {				

	// текст сообщения после "." 
	// номер заказа и айди покупателя
	$id_client =  substr(strrchr($kod, '.'), 1); 
	
	// текст сообщения перед "." 
	// айди клиента и номер поста в чате
	$id_pokupatelya_i_id_zakaza = strstr($kod, '.', true);
	
	// текст после ":" - айди покупателя
	$id_zakaza =  substr(strrchr($id_pokupatelya_i_id_zakaza, ':'), 1);
	
	// текст перед ":" - номер заказа
	$id_pokupatelya = strstr($id_pokupatelya_i_id_zakaza, ':', true);
	
	// текст после "-" - номер поста в чате
	$id_posta=  substr(strrchr($id_zakaza, '-'), 1);
	
	// текст перед "-" - айди клиента
	$id_p2p  =  strstr($id_zakaza, '-', true);
	
	$id_zakaza = str_replace ("-", ".", $id_zakaza);
	
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

	$query = "SELECT id_p2p, id_chat, chat_url FROM ".$table6." WHERE id_admin_group=".$callbackChatId;
	if ($result = $mysqli->query($query)){	
		if($result->num_rows>0){		
		
			$arrayResult = $result->fetch_all(MYSQLI_ASSOC);	
			
			$id_p2p = $arrayResult[0]['id_p2p'];
			$chat_obmennik = $arrayResult[0]['id_chat'];
			$chat_url = $arrayResult[0]['chat_url'];
			
		}else exit('ok');
	}	
	
//}


	
	
if ($callbackQuery=="otklon") { 
	
	// ДЕВЯТАЯ клавиатура кнопка "отклонить"
		
	$id_p2p_id_z = str_replace("-", ".", $id_p2p_id_zakaza);	
		
	$query = "DELETE FROM ".$table4." WHERE id_zakaz=" . $id_p2p_id_z;				
	$mysqli->query($query);
		
	//	$query = "UPDATE ".$table." SET flag=0 WHERE id_client=" . $id_client;
	//	$mysqli->query($query);		
		
	$str = "Ваша заявка отклонена Администрацией p2p-обменника - ".$chat_url."\n\n".
		"читайте правила \xF0\x9F\x91\x87".$tehPodderjka;
		
	$tg->sendMessage($id_client, $str, markdown, true, null, $keyInLine0);
				
	$tg->editMessageText($callbackChatId, $callbackMessageId, $sms."\nЗАЯВКУ ОТКЛОНИЛ - @".$callback_user_name);	
	
	
	try{	
		$tg->editMessageText($chat_obmennik, $id_chata, $sms."\nЗАЯВКА ОТКЛОНЕНА");
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
		
	$tg->editMessageText($callbackChatId, $callbackMessageId, $sms."\nЗАЯВКУ ОДОБРИЛ - @".$callback_user_name);



	
	$inLineKey_menu = [[["text"=>"КуплюПродам","url"=>"t.me/".$username_bot."?start=".
		$id_p2p_id_zakaza]]]; //":" и "." не подходят
	$keyInLine = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLineKey_menu);
		
	$sms.= $id_p2p_id_zakaza.":".$id_client.".".$id_zakaza;
	
		
	try{
		$tg->editMessageText($chat_obmennik, $id_chata, $sms, null, true, $keyInLine);
	}catch (Exception $e){	
	
		$tg->sendMessage($master, "Какая-то ошибка, это айди чата - ".$id_chata);
	
		$tg->sendMessage($chat_obmennik, $sms, null, true, null, $keyInLine);
		$tg->deleteMessage($chat_obmennik, $id_chata);
	}

//	$tg->sendMessage($chat_obmennik, $sms, null, true, null, $keyInLine);
//	$tg->deleteMessage($chat_obmennik, $id_chata);
	
	
	
		
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
		"\nнапишите ему в личку нажав на эту ссылку, он ожидает Вас!");
	
	$tg->sendMessage($id_client, "Появился клиент на Вашу заявку.\n\nВаш гарант: @".
		$callback_user_name."\nнапишите ему в личку нажав на эту ссылку, он ожидает Вас!");

	$tg->answerCallbackQuery($callbackQueryId, "Ожидайте, клиенты уведомлены!", true);

	
	$inLineKey_menu = [[["text"=>"Сделка СОВЕРШЕНА!","callback_data"=>"sovershena"]]];
	$keyInLine = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLineKey_menu);
	
	
	try{
		$tg->editMessageReplyMarkup($chat_obmennik, $id_posta);
	}catch(Exception $e){
		$tg->sendMessage($master, "Выброшен эксцепшн..\nна линии - ".__LINE__."\n".__FILE__);
	}


}
	




?>