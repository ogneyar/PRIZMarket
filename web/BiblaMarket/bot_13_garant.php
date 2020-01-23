<?php

/*
**
**--------------------------------------------------
** обработка callback_query <- ответных сообщений!
**--------------------------------------------------
**
*/


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


if ($callbackQuery=="otklon"||$callbackQuery=="prinyat") {	

	$kod = substr(strrchr($callbackText, 10), 1);  // код с id клиента приславшего заказ и номером заказа

	$simbol = substr($kod, -1);

	$kol=strlen($kod);
	$sms = substr($callbackText,0,-$kol);	

	// текст сообщения после "." - номер заказа
	$id_message =  substr(strrchr($kod, '.'), 1); // данные о номере заказа и/или номер id админа, взявшего заказ

	$id_client = strstr($kod, '.', true);
	
}
	
	
	if ($callbackQuery=="otklon") { 
	
		// ДЕВЯТАЯ клавиатура кнопка "отклонить"
		
		$query = "DELETE FROM ".$table3." WHERE id_client=" . $id_client;				
		$mysqli->query($query);
		
		$query = "UPDATE ".$table." SET flag=0 WHERE id_client=" . $id_client;
		$mysqli->query($query);		
		
		$str = $tehPodderjka."Заявка отклонена, читайте правила \xF0\x9F\x91\x87";
		
		$tg->sendMessage($id_client, $str, markdown, true, null, $keyInLine0);
				
		$tg->editMessageText($callbackChatId, $callbackMessageId, $sms . $id_client . "\nЗАЯВКА ОТКЛОНЕНА");	
		
		$tg->deleteMessage($id_client, $id_message);
		
		
		
	}elseif ($callbackQuery=="prinyat") { 
	
		// ДЕВЯТАЯ клавиатура кнопка "принять"		
		/*
		$sms.= "\xE2\x9D\x97 Заказ принял: @" . $callback_user_name . " \xE2\x9D\x97\n";
		$sms.= $kod . ":" . $callback_from_id . "!";
		$tg->editMessageText($callbackChatId, $callbackMessageId, $sms);
		*/
		
		$query = "SELECT * FROM ".$table3." WHERE id_client=" . $id_client;
		if ($result = $mysqli->query($query)) {			
			if($result->num_rows>0){
				$arrStrok = $result->fetch_all();		
			
				$query = "INSERT INTO ".$table4." VALUES ('". $arrStrok[0][0] ."', '". $arrStrok[0][1] ."', '" . $arrStrok[0][2] . "', '".$arrStrok[0][3]."', '".$arrStrok[0][4]."', '".$arrStrok[0][5]."', '".$arrStrok[0][6]."', '".$arrStrok[0][7]."', '".$arrStrok[0][8]."', '".$arrStrok[0][9]."')";
				$mysqli->query($query);	

				$query = "DELETE FROM ".$table3." WHERE id_client=" . $id_client;				
				$mysqli->query($query);
			}		
		}
		
		
		// КНОПКА репост
		$inLine10_but1=["text"=>"Репост","switch_inline_query"=>$id_message];
		$inLine10_str1=[$inLine10_but1];
		$inLine10_keyb=[$inLine10_str1];
		$keyInLine10 = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLine10_keyb);
		
	
		$query = "UPDATE ".$table." SET flag=0 WHERE id_client=" . $id_client;
		$result = $mysqli->query($query);		
		
		$str = $tehPodderjka."Заявка одобрена, можете сделать новый заказ \xF0\x9F\x91\x87";
		
		$tg->sendMessage($id_client, $str, markdown, true, null, $keyInLine1);		
		
		$tg->editMessageText($callbackChatId, $callbackMessageId, $sms.$id_client.".".$id_message."\nЗАЯВКА ОДОБРЕНА", null, true, $keyInLine10);
		
		$tg->deleteMessage($id_client, $id_message);		

		
		
	}elseif ($callbackQuery=="repost") { 
		
		$tg->answerCallbackQuery($callbackQueryId, "Ещё не работает эта кнопка!");
		
	}
	




?>