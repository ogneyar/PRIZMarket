<?php

//   $chat_id  -  айди чата-обменника


if ($arr['message']['reply_markup']['inline_keyboard']['0']['0']['url']=="http://t.me/".$username_bot){
		
	$query = "SELECT id_admin_group FROM ".$table6." WHERE id_chat=".$chat_id;
	if ($result = $mysqli->query($query)){	
		if($result->num_rows>0){		
		
			$arrayResult = $result->fetch_all(MYSQLI_ASSOC);	
					
			$chat_garant = $arrayResult[0]['id_admin_group'];
			
		}else exit('ok');
	}
	
	
	$kod = substr(strrchr($text, 10), 1);  // код с id клиента приславшего заказ и номером заказа

	//$simbol = substr($kod, -1);

	$kol=strlen($kod)+1;
	$sms = substr($text,0,-$kol);	

	// текст сообщения после "." - номер заказа
	$id_message =  substr(strrchr($kod, '.'), 1); // данные о номере заказа и/или номер id админа, взявшего заказ

	$id_client = strstr($kod, '.', true);
	
	// перемещение заявки из третьей таблицы в четвёртую
	// из "зая" в "обз"))
	$query = "SELECT * FROM ".$table3." WHERE id_client=" . $id_client;
	if ($result = $mysqli->query($query)) {			
		if($result->num_rows>0){
			$arrStrok = $result->fetch_all();		
			
			$valuta = $arrStrok[0][5];
			
			$query = "INSERT INTO ".$table4." VALUES ('". $arrStrok[0][0] ."', '". $arrStrok[0][1] ."', '" . $arrStrok[0][2] . "', '".$arrStrok[0][3]."', '".$arrStrok[0][4]."', '".$arrStrok[0][5]."', '".$arrStrok[0][6]."', '".$arrStrok[0][7]."', '".$arrStrok[0][8]."', '".$arrStrok[0][9]."', '".$chat_id."', '".$chat_garant."', '@".$user_name."')";
			$mysqli->query($query);	

//			$query = "DELETE FROM ".$table3." WHERE id_client=" . $id_client;				
//			$mysqli->query($query);
		}else exit('ok');	
	}
		
	
	$price=_PricePZM_in_Monet($valuta);	




// удаляется сообщение, переданное inline методом
// и печатается на его месте новое
	try{
		$result = $tg->call('deleteMessage', [
			'chat_id' => $chat_id, 
			'message_id' => $message_id
		]);	
		
		$reply = $sms."\xF0\x9F\x91\xA4 @" . $user_name . "\n\n{$price}\n" .
			$id_client . "." . $id_message;
		
		$inLineKey_menu = [[["text"=>"На рассмотрении..","callback_data"=>"rassmotrenie"]]];
		$keyInLine = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLineKey_menu);
		
		
		$result = $tg->call('sendMessage', [
            'chat_id' => $chat_id,
            'text' => $reply,
            'parse_mode' => null,
            'disable_web_page_preview' => true,
            'reply_to_message_id' => null,
            'reply_markup' => is_null($keyInLine) ? $keyInLine : $keyInLine->toJson(),            
        ]);
		
		$message_id = $result['message_id'];
		
		
		
		//$tg->sendMessage($chat_id, $reply, null, true, null, $keyInLine);
		
		
	}catch (Exception $e){
		$tg->sendMessage($master, "Не смог удалить сообщение... \nномер строки: ".
			__LINE__."\n".__FILE__."\n".$e->getCode()." ".$e->getMessage());	
	}	
	





	$sms.= "\xF0\x9F\x91\xA4 @" . $user_name . "\n\n{$price}\n".$message_id. ":" . $id_client . "." . $id_message;
	$tg->sendMessage($chat_garant, $sms, null, true, null, $keyInLine9);

	$str = "Ваша заказ отправлен Администратору, ожидайте ответа..." . $tehPodderjka ;	
	
	try{
		$tg->editMessageText($id_client, $id_message, $str, markdown);		
	}catch (Exception $e){
		$tg->sendMessage($master, "Выброшено исключение, не смог изменить сообщение...\n".
			$except.$e->getCode()." ".$e->getMessage());
		$tg->sendMessage($id_client, $str, markdown);
		$tg->deleteMessage($id_client, $id_message);		
	}
	

}


?>