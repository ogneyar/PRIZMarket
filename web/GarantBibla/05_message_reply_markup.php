<?php

//   $chat_id  -  айди чата-обменника


if ($arr['message']['reply_markup']['inline_keyboard']['0']['0']['url']=="http://t.me/".$username_bot){
		
	$query = "SELECT id_p2p, chat_url, id_admin_group FROM ".$table6." WHERE id_chat=".$chat_id;
	if ($result = $mysqli->query($query)){	
		if($result->num_rows>0){		
		
			$arrayResult = $result->fetch_all(MYSQLI_ASSOC);	
					
			$id_p2p = $arrayResult[0]['id_p2p'];
			$chat_url = $arrayResult[0]['chat_url'];
			$chat_garant = $arrayResult[0]['id_admin_group'];
			
		}else exit('ok');
	}
	
	
	$kod = substr(strrchr($text, 10), 1);  // код с id клиента приславшего заказ и номером заказа

	$kol=strlen($kod)+1;
	$sms = substr($text,0,-$kol);	

	// текст сообщения после "." - номер заказа
	$id_zakaza =  substr(strrchr($kod, '.'), 1); // данные о номере заказа и/или номер id админа, взявшего заказ

	$id_client = strstr($kod, '.', true);
	
	
	// удаляется сообщение, переданное inline методом
	// и печатается на его месте новое
	try{
		$result = $tg->call('deleteMessage', [
			'chat_id' => $chat_id, 
			'message_id' => $message_id
		]);			
		
	}catch (Exception $e){
		$tg->sendMessage($master, "Не смог удалить сообщение... \nномер строки: ".
			__LINE__."\n".__FILE__."\n".$e->getCode()." ".$e->getMessage());	
	}	
		
	$result = $tg->call('sendMessage', [
           'chat_id' => $chat_id,
           'text' => "В процессе.."              
    ]);	

	$message_id = $result['message_id'];
		
	
	
	
	$reply = $sms."\xF0\x9F\x91\xA4 @" . $user_name;
//	. "\n\n{$price}\n" .
//			$id_client . "." . $message_id;
		
	$inLineKey_menu = [[["text"=>"На рассмотрении..","callback_data"=>"rassmotrenie"]]];
	$keyInLine = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLineKey_menu);
	
	try{
		$tg->editMessageText($chat_id, $message_id, $reply, null, true, $keyInLine);	
	}catch (Exception $e){
		$tg->sendMessage($chat_id, $reply);
		$tg->sendMessage($master, "Не смог удалить сообщение... \nномер строки: ".
			__LINE__."\n".__FILE__."\n".$e->getCode()." ".$e->getMessage());	
	}	

	
	
	// перемещение заявки из третьей таблицы в четвёртую
	// из "зая" в "обз"))
	$query = "SELECT * FROM ".$table3." WHERE id_client=" . $id_client;
	if ($result = $mysqli->query($query)) {			
		if($result->num_rows>0){
			$arrStrok = $result->fetch_all(MYSQLI_ASSOC);		
			
			$valuta = $arrStrok[0]['valuta'];
			
			$query = "INSERT INTO ".$table4." VALUES ('". $arrStrok[0]['id_client'] ."', '".
				$id_p2p.".".$message_id ."', '" . $arrStrok[0]['vibor'] . "', '".$arrStrok[0]['monet']."', '".
				$arrStrok[0]['kol_monet']."', '".$valuta."', '".$arrStrok[0]['cena']."', '".
				$arrStrok[0]['itog']."', '".$arrStrok[0]['bank']."', '".$arrStrok[0]['flag_isp']."', '".
				$chat_id."', '".$chat_garant."', '@".$user_name."')";
			$mysqli->query($query);	

//			$query = "DELETE FROM ".$table3." WHERE id_client=" . $id_client;				
//			$mysqli->query($query);
		}else exit('ok');	
	}

	
	$price=_PricePZM_in_Monet($valuta);	

	


	
	


	$reply = "Заявка №".$id_p2p."-".$message_id."\n\n". $sms .
		"\xF0\x9F\x91\xA4 @" . $user_name . "\n\n{$price}\n".$id_p2p.$message_id. ":" . $id_client .
			"." . $id_zakaza;
	$tg->sendMessage($chat_garant, $reply, null, true, null, $keyInLine9);

	$str = "Ваша заказ отправлен на рассмотрение Администрацией p2p-обменника - ".$chat_url.
		", для отправки этой заявки в любой ".
		"другой чат снова нажмите \xE2\x98\x9D отправить, для создания новой - нажмите /start" .
		$tehPodderjka ;	
	
	$tg->sendMessage($id_client, $str, markdown);
	
/*	
	try{
		$tg->editMessageText($id_client, $id_zakaza, $str, markdown);		
	}catch (Exception $e){
		$tg->sendMessage($master, "Выброшено исключение, не смог изменить сообщение...\n".
			$except.$e->getCode()." ".$e->getMessage());
		$tg->sendMessage($id_client, $str, markdown);
		$tg->deleteMessage($id_client, $id_zakaza);		
	}
*/

}


?>