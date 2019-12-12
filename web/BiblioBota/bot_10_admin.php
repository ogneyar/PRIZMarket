<?php

$hz=strpos($text, "админ:");
$hzz=strpos($text, "бан:");
$lot=strpos($text, "удали лот:");
$kat=strpos($text, "категория:");
$new_id=strpos($text, "смени айди лота:");
if (($hz!==false)||($hzz!==false)||($lot!==false)||($kat!==false)||($new_id!==false)){
	$komanda = strstr($text, ':', true);	
	$id = substr(strrchr($text, ":"), 1);
	$text=$komanda;
}


/*
**
**--------------------------------------------------
** обработка callback_query <- ответных сообщений!
**--------------------------------------------------
**
*/

if (is_array($arr['callback_query'])) {	

	$kod = substr(strrchr($callbackText, 10), 1);  // код с id клиента приславшего заказ и номером заказа

	$simbol = substr($kod, -1);

	$kol=strlen($kod);
	$sms = substr($callbackText,0,-$kol);	

	// текст сообщения после "." - номер заказа
	$id_message =  substr(strrchr($kod, '.'), 1); // данные о номере заказа и/или номер id админа, взявшего заказ

	$id_client = strstr($kod, '.', true);
	
	
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
		
		
		//ПОСТРОЧНОЕ ЗАПОЛНЕНИЕ КНОПОК клавиатуры ДЕСЯТОГО уровня KeybordInLine10    АДМИНИСТРИРОВАНИЕ
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
	
}




/*
**
**--------------------------------------------------
** обработка inline_query <- ответных сообщений!
**--------------------------------------------------
**
*/
if (is_array($arr['inline_query'])) {	
	
	$query = "SELECT * FROM ".$table4." WHERE id_zakaz=".$inline_query;
	if ($result = $mysqli->query($query)){	
	  if($result->num_rows>0){		
		$arrStrok = $result->fetch_all();				
		
		$zayavka="\xF0\x9F\x97\xA3 ".$arrStrok[0][2]."\n".
			"\xF0\x9F\x92\xB0 ".$arrStrok[0][4]." ".$arrStrok[0][3]."\n".
			"\xF0\x9F\x92\xB8 ".$arrStrok[0][6]." ".$arrStrok[0][5]." (".$arrStrok[0][7].")\n".
			"\xF0\x9F\x8F\xA6 ".$arrStrok[0][8];		
			
		$title="Вставьте пост.";
		$jmi="\xF0\x9F\x97\xA3 ".$arrStrok[0][2]."\n".
			"\xF0\x9F\x92\xB0 ".$arrStrok[0][4]." ".$arrStrok[0][3];
		
		//$title0="хз тут тож чего-то";
		
		//ПОСТРОЧНОЕ ЗАПОЛНЕНИЕ КНОПОК клавиатуры        АДМИНИСТРИРОВАНИЕ
		$inLine11_but1=["text"=>"Ссыль","url"=>"https://t.me/Secure_deal_PZM/5"];
		$inLine11_str1=[$inLine11_but1];
		$inLine11_keyb=[$inLine11_str1];
		$keyInLine11 = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLine11_keyb);
		
		$inputText = new \TelegramBot\Api\Types\Inline\InputMessageContent\Text($zayavka);		
		
		//$queryArticle0 = new \TelegramBot\Api\Types\Inline\QueryResult\Article($inline_query_from_id, $title0, null, null,null,null, $inputText, $keyInLine11);				
		
		$queryArticle = new \TelegramBot\Api\Types\Inline\QueryResult\Article($inline_query_from_id, $title, $jmi, null,null,null, $inputText, $keyInLine11);		
		$res=[$queryArticle];				
		$tg->answerInlineQuery($inline_query_id, $res);			
			
	  }	
	}	
	
}



/*
**
**      +------------------------------------+
**      | ЗДЕСЬ РАБОТА С - message - ТЕКСТОМ |
**      +------------------------------------+
**
*/
if ($text){

	if ($text == "база") {		
	
		$query = "SELECT * FROM ".$table;
		if ($result = $mysqli->query($query)) {		
			$sms="Клиентская база:\n";
			if($result->num_rows>0){
				$arrStrok = $result->fetch_all();				
				foreach($arrStrok as $arrS){						
					foreach($arrS as $stroka) $sms.= "| ".$stroka." ";
					$sms.="|\n";							
				}					
					
				_pechat($sms, '4000');
				
			}			
		}		
		
		
	}elseif ($text == "удали таблицу каль") {		
	
		$query = "DROP TABLE ".$table2;
		if ($result = $mysqli->query($query)) {		
			$sms="Таблица удалена!";		
			$tg->sendMessage($chat_id, $sms);				
		}else $tg->sendMessage($chat_id, "Не могу удалить таблицу");		
		
				
	}elseif ($text == "удали таблицу зая") {		
	
		$query = "DROP TABLE ".$table3;
		if ($result = $mysqli->query($query)) {		
			$sms="Таблица удалена!";		
			$tg->sendMessage($chat_id, $sms);				
		}else $tg->sendMessage($chat_id, "Не могу удалить таблицу");		
				
		
	}elseif ($text == "покажи таблицы") {		
	
		$query = "SHOW TABLES";
		if ($result = $mysqli->query($query)) {	
			if($result->num_rows>0){
				$arrStrok = $result->fetch_all();				
				foreach($arrStrok as $arrS){						
					foreach($arrS as $stroka) $sms.= "| ".$stroka." ";
					$sms.="|\n";							
				}		
					
				_pechat($sms);
				
			}					
		}else $tg->sendMessage($chat_id, "Не могу показать таблицы");		
				
		
	}elseif ($text == "админы") {		
		
		$query = "SELECT id, id_client, name_client, status FROM ".$table." WHERE status='admin'";
		if ($result = $mysqli->query($query)) {		
			$sms="Список админов:\n";
			if($result->num_rows>0){
				$arrStrok = $result->fetch_all();
				if (is_array($arrStrok)){
					foreach($arrStrok as $key => $arrS){
						if (is_array($arrS)){
							foreach($arrS as $key2 => $stroka){			
								$sms.= "| ".$stroka." ";
							}
							$sms.="|\n";
						}	
					}				
				}				
				_pechat($sms);				
			}		
			
		}else $tg->sendMessage($chat_id, 'Чего то не получается');	
		
		
	}elseif ($text == "айди админов") {		
		
		$query = "SELECT id_client FROM ".$table." WHERE status='admin'";
		if ($result = $mysqli->query($query)) {					
			$kolS=$result->num_rows;
			if($kolS>0){
				$arrStrok = $result->fetch_all();				
				$sms="id админов:\n";
				for ($i=0; $i<$kolS; $i++) {					
					$admin[$i]=$arrStrok[$i][0];
					$sms.= "| ".$admin[$i]. " |\n";
				}				
				
				_pechat($sms);
				
			}				
		}else $tg->sendMessage($chat_id, 'Чего то не получается');	
		
		
	}elseif (($text == "админ")&&($id)) {		
		
		$query = "UPDATE ".$table." SET status='admin' WHERE id=".$id;
		if ($result = $mysqli->query($query)) {		
			$tg->sendMessage($chat_id, "Добавлен новый администратор");	
		}else $tg->sendMessage($chat_id, 'Чего то не получается добавить администратора');	
		
		
	}elseif (($text == "-админ")&&($id)) {		
		
		$query = "UPDATE ".$table." SET status='client' WHERE id=".$id;
		if ($result = $mysqli->query($query)) {		
			$tg->sendMessage($chat_id, "На одного администратора стало меньше");	
		}else $tg->sendMessage($chat_id, 'Чего то не получается убрать администратора');	
		
		
	}elseif (($text == "бан")&&($id)) {		
		
		$query = "UPDATE ".$table." SET flag='1' WHERE id=".$id;
		if ($result = $mysqli->query($query)) {		
			$tg->sendMessage($chat_id, "Клиент добавлен в бан");	
		}else $tg->sendMessage($chat_id, 'Чего то не получается добавить клиента в бан');	
		
		
	}elseif (($text == "унбан")&&($id)) {		
		
		$query = "UPDATE ".$table." SET flag='0' WHERE id=".$id;
		if ($result = $mysqli->query($query)) {		
			$tg->sendMessage($chat_id, "Клиент убран из бана");	
		}else $tg->sendMessage($chat_id, 'Чего то не получается убрать клиента из бана');	
		
		
	}elseif ($text == "ка") {		
	
		$query = "SELECT * FROM ".$table2;
		if ($result = $mysqli->query($query)) {		
			$sms="Калькуляционная таблица:\n";
			if($result->num_rows>0){
				$arrStrok = $result->fetch_all();				
				foreach($arrStrok as $arrS){						
					foreach($arrS as $stroka) $sms.= "| ".$stroka." ";
					$sms.="|\n";							
				}		
					
				_pechat($sms);
				
			}else $tg->sendMessage($chat_id, "пуста таблица");			
		}else $tg->sendMessage($chat_id, "нема");		

		
	}elseif ($text == "удали строки в таблице обз") {		
	
		$query = "DELETE FROM ".$table4." WHERE id_zakaz>0";				
		if ($result = $mysqli->query($query)) {					
			$tg->sendMessage($chat_id, "Удаление совершенно!");								
		}else $tg->sendMessage($chat_id, "Не получается удалить строки!");	
		
		
	}elseif ($text == "зая") {		
	
		$query = "SELECT * FROM ".$table3;
		if ($result = $mysqli->query($query)) {		
			$sms="Таблица заявок:\n";
			if($result->num_rows>0){
				$arrStrok = $result->fetch_all();				
				foreach($arrStrok as $arrS){						
					foreach($arrS as $stroka) $sms.= "| ".$stroka." ";
					$sms.="|\n";							
				}				
					
				_pechat($sms);
				
			}else $tg->sendMessage($chat_id, "пуста таблица \xF0\x9F\xA4\xB7\xE2\x80\x8D\xE2\x99\x82\xEF\xB8\x8F");		
			
		}else $tg->sendMessage($chat_id, "нема");		

		
	}elseif ($text == "еее") {		
	
		$tg->sendMessage($chat_id, "Так держать мастер!");		

		
	}elseif ($text == "эх") {		
	
		$tg->sendMessage($chat_id, "Всё у тебя получится мастер!");		

		
	}elseif ($text == "очистить таблицу от заявок") {		
	
		$tg->sendMessage($chat_id, "неее");		

		
	}elseif ($text == "обз") {		
	
		$query = "SELECT * FROM ".$table4;
		if ($result = $mysqli->query($query)) {		
			$sms="Таблица обработки заявок:\n";
			if($result->num_rows>0){
				$arrStrok = $result->fetch_all();				
				foreach($arrStrok as $arrS){						
					foreach($arrS as $stroka) $sms.= "| ".$stroka." ";
					$sms.="|\n";							
				}			
					
				_pechat($sms);
				
			}else $tg->sendMessage($chat_id, "пуста таблица \xF0\x9F\xA4\xB7\xE2\x80\x8D\xE2\x99\x82\xEF\xB8\x8F");		
			
		}else $tg->sendMessage($chat_id, "нема");		

		
		
	}elseif ($text == "курс") {			
	
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
	
		$reply="Курс PRIZM на CoinMarketCap:\n1PZM = ".$Round_PricePZM_in_USD." $\n1PZM = ".$Round_PricePZM_in_RUB.
			" \xE2\x82\xBD\n1PZM = ".$Round_PricePZM_in_ETH." ETH\n1PZM = ".$Round_PricePZM_in_BTC." BTC\n";
		$reply.="Данные на ".$Date_PricePZM." МСК";
	
		$tg->sendMessage($chat_id, $reply); 			
		

	}elseif ($text == "ану") {		
	
		include 'bot_05_MTProto.php';

		
	}elseif ($text == "гет") {		
	
		$urlF=$tg->getFileUrl();  // ссылка типа "https://api.telegram.org/file/bot".$token
	
		$file=$tg->getFile('AgADAgADPasxGy7QCEtmFvJhI4jeKSPqug8ABAEAAwIAA3kAAz72BQABFgQ');
	
		//$file=$tg->getFile('a_conect.php');
	
		$file_path=$file->getFilePath();
	
		//$file_id=$file->getFileId();
	
		$urlF.="/".$file_path;
	
		//$tg->sendDocument($master, $file_id);
	
		//include 'trd/curl.php';
	
		$tg->sendMessage($master, $urlF); 
	
	
	}elseif ($text == "даун") {		
	
		$url=$tg->getFileUrl();  // ссылка типа "https://api.telegram.org/file/bot".$token
	
		$string=$tg->downloadFile('AgADAgADPasxGy7QCEtmFvJhI4jeKSPqug8ABAEAAwIAA3kAAz72BQABFgQ');
	
		$tg->sendMessage($master, $string); 
	
	
	}elseif ($text == "пись") {		
	
		//$tg->getFile('session.madeline');

		$CRLF="\r\n";
	
		$to  = "ya13th@mail.ru"; 	

		$subject = "Заголовок письма"; 

		$message = "Текст письма{$CRLF}";  //{$CRLF}1-ая строчка{$CRLF}2-ая строчка{$CRLF}

		$headers = [
			'From' => 'ya13th@mail.ru',
			'Reply-To' => 'yaya13th@ya.ru'		
		];	
	
		//$otp=mail($to, $subject, $message, $headers); 
	
		$otp=mail('mwyakovlew@gmail.com', 'VVV', 'gggg', $headers); 
	
		if ($otp) {
			$tg->sendMessage($chat_id, "Отрправка!"); 
		}else $tg->sendMessage($chat_id, "Не выходит отправить почту"); 


	}elseif ($text == "сенд") {		
	
		$photo_id='AgADAgADPasxGy7QCEtmFvJhI4jeKSPqug8ABAEAAwIAA3kAAz72BQABFgQ';
	
		$caption="#продаю\n\n️[Петля Глиссона](https://t.me/podrobno_s_PZP/613)\n".
			"₽ / PZM\n️#весь\_мир\n️@pochaevm\n\n✅PRIZMarket доверяет❗️";			
			
		$inLineBut1=["text"=>"Подробнее","url"=>"https://t.me/podrobno_s_PZP/613"];
		$inLineStr1=[$inLineBut1];
		$inLineKeyb=[$inLineStr1];
		$keyInLine = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLineKeyb);
	
		$tg->sendPhoto($chat_id, $photo_id, $caption, null, $keyInLine, false, markdown); 
	
	}elseif ($text == "пзм") {		
	
		$query = "SELECT * FROM ".$table5;
		if ($result = $mysqli->query($query)) {		
			$sms="Таблица лотов:\n";
			if($result->num_rows>0){
				$arrStrok = $result->fetch_all();				
				foreach($arrStrok as $arrS){						
					foreach($arrS as $stroka) $sms.= "| ".$stroka." ";				
					$sms.="|\n\n";												
				}									
				
				_pechat($sms, '3000');				
				
			}else $tg->sendMessage($chat_id, "пуста таблица \xF0\x9F\xA4\xB7\xE2\x80\x8D\xE2\x99\x82\xEF\xB8\x8F");		
			
		}else throw new Exception("Не смог проверить таблицу ".$table5);
	
		
		
	}elseif ($text == "лоты") {		
	
		$query = "SELECT id, otdel, caption2 FROM ".$table5;
		if ($result = $mysqli->query($query)) {		
			$sms="Таблица лотов:\n";
			if($result->num_rows>0){
				$arrStrok = $result->fetch_all();				
				foreach($arrStrok as $arrS){						
					foreach($arrS as $stroka) $sms.= "| ".$stroka." ";				
					$sms.="|\n";												
				}
				
				_pechat($sms);
				
			}else $tg->sendMessage($chat_id, "пуста таблица \xF0\x9F\xA4\xB7\xE2\x80\x8D\xE2\x99\x82\xEF\xB8\x8F");		
			
		}else throw new Exception("Не смог проверить таблицу ".$table5);
	
		
		
	}elseif ($text == "удали строки в таблице пзм") {		
	
		$query = "DELETE FROM ".$table5." WHERE id>0";				
		if ($result = $mysqli->query($query)) {					
			$tg->sendMessage($chat_id, "Удаление совершенно!");								
		}else $tg->sendMessage($chat_id, "Не получается удалить строки!");	
		
		
	}elseif ($text == "удали таблицу пзм") {		
	
		$query = "DROP TABLE ".$table5;
		if ($result = $mysqli->query($query)) {		
			$sms="Таблица удалена!";		
			$tg->sendMessage($chat_id, $sms);				
		}else $tg->sendMessage($chat_id, "Не могу удалить таблицу");	
		
		
		
	}elseif ($text == "удали лот") {		
	
		$query = "DELETE FROM ".$table5." WHERE id=". $id;				
		if ($result = $mysqli->query($query)) {					
			$tg->sendMessage($chat_id, "Удаление совершенно!");								
		}else $tg->sendMessage($chat_id, "Не получается удалить строки!");	
		
		
	}elseif ($text == "категории") {		
		
		$tg->sendMessage($chat_id, $spisok);	
		
	}elseif ($text == "категория") {		
		
		$komanda = $id;		
		$id = strstr($komanda, '-', true);	
		$otdel = substr(strrchr($komanda, "-"), 1);
	
		$otdel = vibor_otdela($otdel);		
			
		$query = "UPDATE ".$table5." SET otdel='{$otdel}' WHERE id=".$id;
		if ($result = $mysqli->query($query)) {		
			$tg->sendMessage($chat_id, "Категория {$otdel} установлена");	
		}else $tg->sendMessage($chat_id, 'Чего то не получается установить категорию');	
	
		
	}elseif ($text == "измени кэпшн") {		
		
		$query = "ALTER TABLE `pzmarkt` CHANGE `caption2` `caption2` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL";
		if ($result = $mysqli->query($query)) {		
			$tg->sendMessage($chat_id, "Всё прекрасно");	
		}else $tg->sendMessage($chat_id, 'Чего то не получается');	
	
		
		
	}elseif ($text == "смени айди лота") {		
		
		$komanda = $id;		
		$id = strstr($komanda, '-', true);	
		$id_new = substr(strrchr($komanda, "-"), 1);		
		
		$query = "UPDATE ".$table5." SET id='{$id_new}' WHERE id=".$id;
		if ($result = $mysqli->query($query)) {		
			$tg->sendMessage($chat_id, "Новый номер присвоен");	
		}else $tg->sendMessage($chat_id, 'Чего то не получается присвоить новый номер');	
	
		
		
	}elseif ($text == "список команд") {		
		
		$tg->sendMessage($chat_id, $spisok_komand);
		
		
	}elseif ($text == "ДЛЯ АДМИНИСТРАЦИИ") {  
		
		$tg->sendMessage($chat_id, "Бдя Будь Бдительней", markdown, true, null, $keyboard_Admin);
		
			
	}elseif ($text == "уфь") {		
		
		$MP->messages->sendMessage(['peer' => '@Ogneyar_ya', 'message' => 'Ваще круто']);	
		
		
	}elseif ($text == "стартМаркет") {			
		_start_PZMarket_bota($this_admin);			
	}elseif ($text == "стартГарант") {				
		_start_PZMgarant_bota($this_admin);			
	}elseif ($text == "стоп") {			
		$tg->sendMessage($chat_id, "Хорошо, ты заходи, если шо)", null, true, null, $HideKeyboard);
	
	
	}elseif ($text == "покажи группу медиа") {		
		
		$media = new \TelegramBot\Api\Types\InputMedia\ArrayOfInputMedia();
	
		$media->addItem(new TelegramBot\Api\Types\InputMedia\InputMediaPhoto($_SERVER['HTTP_HOST'].
			"/zMedia/super.jpg"));		

		$media->addItem(new TelegramBot\Api\Types\InputMedia\InputMediaVideo($_SERVER['HTTP_HOST'].
			"/zMedia/anima.mp4"));

		$tg->sendMediaGroup($chat_id, $media);
		
	}elseif ($text == "покажи видео") {		
		
		$video = 'BAADAgADkQQAAoKpkUsk_PyWHzzFRhYE';
		
		$tg->sendVideo($chat_id, $video, null, "ttt");
		
	}elseif ($text == "покажи стикер") {		
		
		$video = 'CAADAgADqgkAAnlc4glW1RzY9rJMLxYE';
		
		$tg->sendSticker($chat_id, $video);
		
	}elseif ($text == "покажися") {		
		
		$bot = new \TelegramBot\Api\Client($token);
    
		$bot->command('ping', function ($message) use ($bot) {
        
			$bot->sendMessage($message->getChat()->getId(), 'pong!');
			
		});
    
		$bot->run();
		
	}elseif ($text!=="/start"&&$text!=="s"&&$text!=="S"&&$text!=="с"&&$text!=="С"&&$text!=="c"&$text!=="C") {
		if ($chat_type=='private') {		
			$sms=" - БРО -  тыжадмин,".
			" сделай ему рестарт - /start\n ..и почисть переписку))\n\n(чистить не обязательно)";		
			$tg->sendMessage($chat_id, $sms);	
		}
	}
	
}
	
	
	



?>