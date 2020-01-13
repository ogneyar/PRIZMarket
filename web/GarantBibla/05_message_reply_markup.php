<?php

//   $chat_id  -  айди чата-обменника


if ($arr['message']['reply_markup']['inline_keyboard']['0']['0']['url']=="http://t.me/".$username_bot){
		
	$query = "SELECT chat_url, id_admin_group FROM ".$table6." WHERE id_chat=".$chat_id;
	if ($result = $mysqli->query($query)){	
		if($result->num_rows>0){		
		
			$arrayResult = $result->fetch_all(MYSQLI_ASSOC);	
					
			$chat_url = $arrayResult[0]['chat_url'];
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
			$arrStrok = $result->fetch_all(MYSQLI_ASSOC);		
			
			$valuta = $arrStrok[0]['valuta'];
			
			$query = "INSERT INTO ".$table4." VALUES ('". $arrStrok[0]['id_client'] ."', '".
				$message_id ."', '" . $arrStrok[0]['vibor'] . "', '".$arrStrok[0]['monet']."', '".
				$arrStrok[0]['kol_monet']."', '".$valuta."', '".$arrStrok[0]['cena']."', '".
				$arrStrok[0]['itog']."', '".$arrStrok[0]['bank']."', '".$arrStrok[0]['flag_isp']."', '".
				$chat_id."', '".$chat_garant."', '@".$user_name."')";
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
		
		$result = $tg->call('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "В процессе.."              
        ]);
		
/*	
		$result = $tg->call('sendMessage', [
            'chat_id' => $chat_id,
            'text' => $reply,
            'parse_mode' => null,
            'disable_web_page_preview' => true,
            'reply_to_message_id' => null,
            'reply_markup' => is_null($keyInLine) ? $keyInLine : $keyInLine->toJson(),            
        ]);
*/		
		$message_id = $result['message_id'];
		
		$reply = $sms."\xF0\x9F\x91\xA4 @" . $user_name . "\n\n{$price}\n" .
			$id_client . "." . $message_id;
		
		$inLineKey_menu = [[["text"=>"На рассмотрении..","callback_data"=>"rassmotrenie"]]];
		$keyInLine = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLineKey_menu);
		
		$tg->editMessageText($chat_id, $message_id, $reply, markdown, true, $keyInLine);		
		
		
		
		
	}catch (Exception $e){
		$tg->sendMessage($master, "Не смог удалить сообщение... \nномер строки: ".
			__LINE__."\n".__FILE__."\n".$e->getCode()." ".$e->getMessage());	
	}	
	





	$sms.= "\xF0\x9F\x91\xA4 @" . $user_name . "\n\n{$price}\n".$message_id. ":" . $id_client . "." . $id_message;
	$tg->sendMessage($chat_garant, $sms, null, true, null, $keyInLine9);

	$str = "Ваша заказ отправлен на рассмотрение Администрацией p2p-обменника - ".$chat_url.
		", для отправки этой заявки в любой ".
		"другой чат снова нажмите \xE2\x98\x9D отправить, для создания новой - нажмите /start" .
		$tehPodderjka ;	
	
	$tg->sendMessage($id_client, $str, markdown);
	
/*	
	try{
		$tg->editMessageText($id_client, $id_message, $str, markdown);		
	}catch (Exception $e){
		$tg->sendMessage($master, "Выброшено исключение, не смог изменить сообщение...\n".
			$except.$e->getCode()." ".$e->getMessage());
		$tg->sendMessage($id_client, $str, markdown);
		$tg->deleteMessage($id_client, $id_message);		
	}
*/

}


?>