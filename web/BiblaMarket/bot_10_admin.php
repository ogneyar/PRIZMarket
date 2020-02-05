<?php

$hz=strpos($text, "админ:");
$hzz=strpos($text, "бан:");
$lot=strpos($text, "удали лот:");
$kat=strpos($text, "категория:");
$new_id=strpos($text, "смени айди лота:");
$ogr=strpos($text, "ограничь:");
$sn_ogr=strpos($text, "снять ограничения:");
$kl=strpos($text, "удали клиента:");
$pokaj=strpos($text, "покажи лот:");
$smeni=strpos($text, "смени время на 0 у лота:");
if (($smeni!==false)||($pokaj!==false)||($kl!==false)||($hz!==false)||($hzz!==false)||($lot!==false)||($kat!==false)||($new_id!==false)||($ogr!==false)||($sn_ogr!==false)){
	$komanda = strstr($text, ':', true);	
	$id = substr(strrchr($text, ":"), 1);
	$text=$komanda;
}



/*
**
**--------------------------------------------------
** обработка inline_query <- ответных сообщений!
**--------------------------------------------------
**
*/
if ($arr['inline_query']) {	
	
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
	exit('ok');
}



/*
**
**      +------------------------------------+
**      | ЗДЕСЬ РАБОТА С - message - ТЕКСТОМ |
**      +------------------------------------+
**
*/
if ($text){

	if ($text == "База клиентов"||$text == "база") {		
	
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
/*	
		$query = "DROP TABLE ".$table2;
		if ($result = $mysqli->query($query)) {		
			$sms="Таблица удалена!";		
			$tg->sendMessage($chat_id, $sms);				
		}else $tg->sendMessage($chat_id, "Не могу удалить таблицу");		
*/		
				
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
				
		
	}elseif ($text == "Админы"||$text == "админы") {		
		
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
		
		
	}elseif ($text == "Таблица заявок"||$text == "зая") {		
	
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
	
		$tg->sendMessage($chat_id, "Так держать, мастер!");		

		
	}elseif ($text == "эх") {		
	
		$tg->sendMessage($chat_id, "Всё у тебя получится, мастер!");		

		
	}elseif ($text == "очистить таблицу от заявок") {		
	
		$tg->sendMessage($chat_id, "неее");		

		
	}elseif ($text == "Обработка заявок"||$text == "обз") {		
	
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

		
		
	}elseif ($text == "ану") {		
	
		include 'bot_05_MTProto.php';

		
	}elseif ($text == "гет") {		
	
		$urlF=$tg->getFileUrl();  // ссылка типа "https://api.telegram.org/file/bot".$token	
		$file=$tg->getFile('AgADAgADPasxGy7QCEtmFvJhI4jeKSPqug8ABAEAAwIAA3kAAz72BQABFgQ');		
	
		$file_path=$file->getFilePath();	
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
	
	
	}elseif ($text == "Полная таблица лотов"||$text == "пзм") {		
	
		$query = "SELECT * FROM ".$table5;
		if ($result = $mysqli->query($query)) {		
			$sms="Таблица лотов:\n";
			if($result->num_rows>0){
				$arrStrok = $result->fetch_all();				
				foreach($arrStrok as $arrS){						
					foreach($arrS as $stroka) {
						if ($stroka==null) $stroka=" ";
						$sms.= "| ".$stroka." ";				
					}	
					$sms.="|\n\n";												
				}									
				
				_pechat($sms);				
				
			}else $tg->sendMessage($chat_id, "пуста таблица \xF0\x9F\xA4\xB7\xE2\x80\x8D\xE2\x99\x82\xEF\xB8\x8F");		
			
		}else throw new Exception("Не смог проверить таблицу ".$table5);
	
		
		
	}elseif ($text == "пзм2") {		
	
		$query = "SELECT * FROM ".$table5;
		if ($result = $mysqli->query($query)) {		
			$sms="Таблица лотов:\n";
			if($result->num_rows>0){
				$arrStrok = $result->fetch_all();				
				foreach($arrStrok as $arrS){						
					foreach($arrS as $stroka) {
						if ($stroka==null) $stroka=" ";
						$sms.= "| ".$stroka." ";				
					}	
					$sms.="|\n\n";												
				}									
				
				_pechat($sms, 4004);				
				
			}else $tg->sendMessage($chat_id, "пуста таблица \xF0\x9F\xA4\xB7\xE2\x80\x8D\xE2\x99\x82\xEF\xB8\x8F");		
			
		}else throw new Exception("Не смог проверить таблицу ".$table5);
	
		
		
	}elseif ($text == "покажи лот") {		
	
		$query = "SELECT * FROM ".$table5." WHERE id=".$id;
		if ($result = $mysqli->query($query)) {		
			
			if($result->num_rows>0){
				$arrStrok = $result->fetch_all();				
				foreach($arrStrok as $arrS){						
					foreach($arrS as $stroka) {
						if ($stroka==null) $stroka=" ";
						$sms.= "| ".$stroka." ";				
					}	
					$sms.="|\n\n";												
				}									
				
				_pechat($sms, '2000');				
				
			}else $tg->sendMessage($chat_id, "пуста таблица \xF0\x9F\xA4\xB7\xE2\x80\x8D\xE2\x99\x82\xEF\xB8\x8F");		
			
		}else throw new Exception("Не смог проверить таблицу ".$table5);
	
	
		
	}elseif ($text == "База лотов"||$text == "лоты") {		
	
		$query = "SELECT id, otdel, caption2 FROM ".$table5;
		if ($result = $mysqli->query($query)) {		
			$sms="Таблица лотов:\n";
			if($result->num_rows>0){
				$arrStrok = $result->fetch_all();				
				foreach($arrStrok as $arrS){						
					foreach($arrS as $stroka) $sms.= "| ".$stroka." ";				
					$sms.="|\n";												
				}
				
				_pechat($sms, '6500');
				
			}else $tg->sendMessage($chat_id, "пуста таблица \xF0\x9F\xA4\xB7\xE2\x80\x8D\xE2\x99\x82\xEF\xB8\x8F");		
			
		}else throw new Exception("Не смог проверить таблицу ".$table5);
	
		
		
	}elseif ($text == "лоты2") {		
	
		$query = "SELECT id, otdel, caption2 FROM ".$table5;
		if ($result = $mysqli->query($query)) {		
			$sms="Таблица лотов:\n";
			if($result->num_rows>0){
				$arrStrok = $result->fetch_all();				
				foreach($arrStrok as $arrS){						
					foreach($arrS as $stroka) $sms.= "| ".$stroka." ";				
					$sms.="|\n";												
				}
				
				_pechat($sms, '6504');
				
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
		
		$query = "SELECT format FROM ".$table5." WHERE id=". $id;
		$result = $mysqli->query($query);
		$format = $result->fetch_array();
		
		if ($format['0']=='video'){
			$key = $id . ".mp4";
		}elseif ($format['0']=='photo'){
			$key = $id . ".jpg";
		}		
		
		$query = "DELETE FROM ".$table5." WHERE id=". $id;				
		if ($result = $mysqli->query($query)) {					
			$tg->sendMessage($chat_id, "Удаление из БД совершенно!");								
		}else $tg->sendMessage($chat_id, "Не получается удалить строку из БД");	
		
		$result = $s3->deleteObjects([
			'Bucket' => $aws_bucket,			
			'Delete' => [
				'Objects' => [
					[
						'Key' => $key,						
					],            
				],				
			],
		]);
		
		if ($result['@metadata']['statusCode']=='200'){
			$tg->sendMessage($chat_id, "Удалил лот из Amazon");	
		}else $tg->sendMessage($chat_id, 'Чего то не получается удалить лот из Amazon');	
		
		
	}elseif ($text == "удали клиента") {		
	
		$query = "DELETE FROM ".$table." WHERE id=". $id;				
		if ($result = $mysqli->query($query)) {					
			$tg->sendMessage($chat_id, "Удаление совершенно!");								
		}else $tg->sendMessage($chat_id, "Не получается удалить строки!");	
		
		
		
	}elseif ($text == "Категории"||$text == "категории") {		
		
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
	
		
		
	}elseif ($text == "Список команд"||$text == "список команд") {		
		
		$tg->sendMessage($chat_id, $spisok_komand);
		
		
		
	}elseif ($text == "ДЛЯ АДМИНИСТРАЦИИ"||$text == "админка") {  
		
		$tg->sendMessage($chat_id, "Бдя Будь Бдительней", markdown, true, null, $keyboard_Admin);
		
		
			
	}elseif ($text == "прото") {		
		
		$MP->messages->sendMessage(['peer' => '@Ogneyar_ya', 'message' => 'Ваще круто']);	
		
		
		
	}elseif ($text == "стартМаркет") {			
		_start_PZMarket_bota($this_admin);			
		
	}elseif ($text == "стартГарант") {					
		_start_PZMgarant_bota($this_admin);			
		
	}elseif ($text == "Стоп"||$text == "стоп") {			
		$tg->sendMessage($chat_id, "Хорошо, ты заходи, если шо)", null, true, null, $HideKeyboard);
	
	
	
	}elseif ($text == "Покажи группу медиа") {		
		
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
		
	}elseif ($text == "кик") {		
		
		$tg->kickChatMember('-1001368618561', '1038937592');
		
		
	}elseif ($text == "ограничь") {		
		
		
		//$tg->restrictChatMember($admin_group, $testerbotoff, null, false, false, false, false);
		
		$tg->call('restrictChatMember', [
			'chat_id' => $admin_group,
            'user_id' => $id,
            'until_date' => null,
            'can_send_messages' => false,
            'can_send_media_messages' => false,
            'can_send_other_messages' => false,
            'can_add_web_page_previews' => false
		]);
		
		
		
	}elseif ($text == "снять ограничения") {		
		
		
		//$tg->restrictChatMember($admin_group, $testerbotoff, null, true, true, true, true);
		
		$tg->call('restrictChatMember', [
			'chat_id' => $admin_group,
            'user_id' => $id,
            'until_date' => null,
            'can_send_messages' => true,
            'can_send_media_messages' => true,
            'can_send_other_messages' => true,
            'can_add_web_page_previews' => true
		]);
		
		
		
	}elseif ($text == "гетЧат") {				
		
		$eee=$tg->getChat($admin_group);
		
		$reply=Print_r($eee, true);
		
		_pechat($reply, '4000'); 		
		
		
		
	}elseif ($text == "гетЧатАдмин") {				
		
		$eee=$tg->getChatAdministrators($admin_group);
		
		$reply=Print_r($eee, true);
		
		_pechat($reply, '4000'); 				
		
		
		
	}elseif ($text == "замени все категории") {				
			
		$query = "UPDATE ".$table5." SET otdel='{$DopKnopa[0]}' WHERE otdel='Недвижимость'";
		$result = $mysqli->query($query);			
		if (!$result) throw new Exception("Не смог заменить категорию..");
		
		$query = "UPDATE ".$table5." SET otdel='{$DopKnopa[1]}' WHERE otdel='Работа'";
		$result = $mysqli->query($query);			
		if (!$result) throw new Exception("Не смог заменить категорию..");
		
		$query = "UPDATE ".$table5." SET otdel='{$DopKnopa[2]}' WHERE otdel='Транспорт'";
		$result = $mysqli->query($query);			
		if (!$result) throw new Exception("Не смог заменить категорию..");
		
		$query = "UPDATE ".$table5." SET otdel='{$DopKnopa[3]}' WHERE otdel='Услуги'";
		$result = $mysqli->query($query);			
		if (!$result) throw new Exception("Не смог заменить категорию..");
		
		$query = "UPDATE ".$table5." SET otdel='{$DopKnopa[4]}' WHERE otdel='Личные вещи'";
		$result = $mysqli->query($query);			
		if (!$result) throw new Exception("Не смог заменить категорию..");
		
		$query = "UPDATE ".$table5." SET otdel='{$DopKnopa[5]}' WHERE otdel='Для дома и дачи'";
		$result = $mysqli->query($query);			
		if (!$result) throw new Exception("Не смог заменить категорию..");
		
		$query = "UPDATE ".$table5." SET otdel='{$DopKnopa[6]}' WHERE otdel='Бытовая электроника'";
		$result = $mysqli->query($query);			
		if (!$result) throw new Exception("Не смог заменить категорию..");
		
		$query = "UPDATE ".$table5." SET otdel='{$DopKnopa[7]}' WHERE otdel='Животные'";
		$result = $mysqli->query($query);			
		if (!$result) throw new Exception("Не смог заменить категорию..");
		
		$query = "UPDATE ".$table5." SET otdel='{$DopKnopa[8]}' WHERE otdel='Хобби и отдых'";
		$result = $mysqli->query($query);			
		if (!$result) throw new Exception("Не смог заменить категорию..");
		
		$query = "UPDATE ".$table5." SET otdel='{$DopKnopa[9]}' WHERE otdel='Для бизнеса'";
		$result = $mysqli->query($query);			
		if (!$result) throw new Exception("Не смог заменить категорию..");
		
		$query = "UPDATE ".$table5." SET otdel='{$DopKnopa[10]}' WHERE otdel='Продукты питания'";
		$result = $mysqli->query($query);			
		if (!$result) throw new Exception("Не смог заменить категорию..");
		
		$query = "UPDATE ".$table5." SET otdel='{$DopKnopa[11]}' WHERE otdel='Красота и здоровье'";
		$result = $mysqli->query($query);			
		if (!$result) throw new Exception("Не смог заменить категорию..");		
	
		$tg->sendMessage($chat_id, "Все новые категории установленны");
		exit('ok');
		
		
	}elseif ($text == "удали лишние лоты") {		
	
		$query = "DELETE FROM ".$table5." WHERE id<'200'";				
		if ($result = $mysqli->query($query)) {					
			$tg->sendMessage($chat_id, "Удаление совершенно!");								
		}else $tg->sendMessage($chat_id, "Не получается удалить строки!");	
		
		
	}elseif ($text == "замени у лота дополнение") {				
	
		
		$query = "UPDATE ".$table5." SET doverie='✅PRIZMarket доверяет❗️' WHERE doverie='1'";
		if ($result = $mysqli->query($query)) {		
			$tg->sendMessage($chat_id, "Новый номер присвоен");	
		}else $tg->sendMessage($chat_id, 'Чего то не получается присвоить новый номер');	
	
		
		
	}elseif ($text == "изменись срочно") {				
		
		$query = "ALTER TABLE `pzmarkt` CHANGE `flag` `time` INT( 20 ) NULL DEFAULT NULL";
		if ($result = $mysqli->query($query)) {		
			$tg->sendMessage($chat_id, "Всё прекрасно");	
		}else $tg->sendMessage($chat_id, 'Чего то не получается');	
		
				
		
	}elseif ($text == "смени время для всех лотов") {		
				
		$time = time();
		$query = "UPDATE ".$table5." SET time='{$time}' WHERE time='0'";
		if ($result = $mysqli->query($query)) {		
			$tg->sendMessage($chat_id, "Время присвоено");	
		}else $tg->sendMessage($chat_id, 'Чего то не получается присвоить новое время');	
	
		
		
	}elseif ($text == "смени время на 0 у лота") {		
						
		$query = "UPDATE ".$table5." SET time='0' WHERE id={$id}";
		if ($result = $mysqli->query($query)) {		
			$tg->sendMessage($chat_id, "Время обнулено");	
		}else $tg->sendMessage($chat_id, 'Чего то не получается обнулить время');	
	
		
		
	}elseif ($text == "делетись ласт срочно") {				
		
		$query = "DELETE FROM ".$table5." WHERE id='805'";	
		if ($result = $mysqli->query($query)) {		
			$tg->sendMessage($chat_id, "Удалил лот из БД");	
		}else $tg->sendMessage($chat_id, 'Чего то не получается удалить лот из БД');	
		
		$result = $s3->deleteObjects([
			'Bucket' => $aws_bucket,			
			'Delete' => [
				'Objects' => [
					[
						'Key' => '805.jpg',						
					],            
				],				
			],
		]);
		
		if ($result['@metadata']['statusCode']=='200'){
			$tg->sendMessage($chat_id, "Удалил лот из Amazon");	
		}else $tg->sendMessage($chat_id, 'Чего то не получается удалить лот из Amazon');	
			
		
		
	}elseif ($text == "отправь оптом файлы на Амазон") {				
		
		
		$query = "SELECT id, format, file_id FROM ".$table5;
		if ($result = $mysqli->query($query)) {		
			$kol = $result->num_rows;
			if($kol>0){
		
				$arrayResult = $result->fetch_all(MYSQLI_ASSOC);
				$schetchik = 0;
				foreach($arrayResult as $stroka){
				
					if ($stroka['format']=='video'){
						$key = $stroka['id'] . ".mp4";
					}elseif ($stroka['format']=='photo'){
						$key = $stroka['id'] . ".jpg";
					}					
					
					$file_id = $stroka['file_id'];
					
					// отправка файла на Амазон		
					$fileObject = $tg->getFile($file_id);		
					$file_url = $tg->getFileUrl();	
					$url = $file_url . "/" . $fileObject->getFilePath();
					
					$file = file_get_contents($url);
				  
					$upload = $s3->putObject([
						'Bucket' => $aws_bucket,
						'Key'    => $key, 
						'Body'   => $file,	
						'ACL'    => 'public-read'
					]);			
					// ---------------------------				
					
					if(!$upload) throw new Exception("Не смог отправить файл {$key} на Амазон");				
					
					$schetchik++;
				}	
				$tg->sendMessage($chat_id, "Отправил на Амазон {$schetchik} файлов!");	
				exit('ok');
			}
		}else throw new Exception("Не смог проверить таблицу ".$table5);
		//--------------------------------------------------------------	
	
	
		
		
	}elseif ($text == "Таблица гарантЧатов"||$text == "чаты"||$text == "Чаты"||$text == "xfns"||$text == "Xfns") {		
	
		$query = "SELECT * FROM ".$table6;
		if ($result = $mysqli->query($query)) {		
			$sms="Таблица гарантЧатов:\n";
			if($result->num_rows>0){
				$arrStrok = $result->fetch_all();				
				foreach($arrStrok as $arrS){						
					foreach($arrS as $stroka) $sms.= "| ".$stroka." ";
					$sms.="|\n";							
				}				
					
				_pechat($sms);
				
			}else $tg->sendMessage($chat_id, "пуста таблица \xF0\x9F\xA4\xB7\xE2\x80\x8D\xE2\x99\x82\xEF\xB8\x8F");		
			
		}else $tg->sendMessage($chat_id, "нема");		

		
		
	}elseif ($text == "иента") {		
	
		$query = "ALTER TABLE `pzmarkt` CHANGE `file_id` `file_id` VARCHAR( 200 ) NULL DEFAULT NULL";				
		if ($result = $mysqli->query($query)) {					
			$tg->sendMessage($chat_id, "Cовершенно!");								
		}else $tg->sendMessage($chat_id, "Не получается изменить!");	
		
	
	}elseif ($text == "и2 клиента") {		
	
		$query = "ALTER TABLE `garant_users` CHANGE `username` `username` VARCHAR( 100 ) NULL DEFAULT NULL";				
		if ($result = $mysqli->query($query)) {					
			$tg->sendMessage($chat_id, "Cовершенно!");								
		}else $tg->sendMessage($chat_id, "Не получается изменить!");	
		
		
		
	}elseif ($text == "и3 клиента") {		
	
		$query = "ALTER TABLE `garant_users` CHANGE `status` `status` VARCHAR( 20 ) NULL DEFAULT NULL";				
		if ($result = $mysqli->query($query)) {					
			$tg->sendMessage($chat_id, "Cовершенно!");								
		}else $tg->sendMessage($chat_id, "Не получается изменить!");	
		
		
		
	}elseif ($text == "пол") {		
	
		$data = ["aaa","bbb","ccc"];
		$dataJSON = json_encode($data);
	
		$result = $tg->call('sendPoll', [
			'chat_id' => $admin_group,
			'question' => 'gghhnnnn',
			'options' => $dataJSON
		]);
		//$tg->sendMessage($master, $data);
		
	}elseif ($text!=="/start"&&$text!=="s"&&$text!=="S"&&$text!=="с"&&$text!=="С"&&$text!=="c"&&$text!=="C"&&$text !== "Старт"&&$text !== "старт") {
		if ($arr['message']['reply_to_message']) {  // и если это ответ на сообщение

			include_once 'bot_06_reply.php';					  // то подключается один файл

		}
		/*
		elseif ($chat_type=='private') {		
			$sms=" - БРО -  тыжадмин,".
			" сделай ему рестарт - /start\n ..и почисть переписку))\n\n(чистить не обязательно)";		
			$tg->sendMessage($chat_id, $sms);	
		}
		*/
		
	}
	
}
	
	
	



?>