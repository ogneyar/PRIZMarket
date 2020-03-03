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
				
			}else $tg->sendMessage($chat_id, "пуста таблица ".
				" \xF0\x9F\xA4\xB7\xE2\x80\x8D\xE2\x99\x82\xEF\xB8\x8F");		
		}		
		
		
	}elseif ($text == "кузя") {		
	
		$tg->sendMessage($chat_id, "Х.З!");		
				
		
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
			}else $tg->sendMessage($chat_id, 'Их нет!');	
			
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
				
			}else $tg->sendMessage($chat_id, 'Их нет!');					
		}else $tg->sendMessage($chat_id, 'Чего то не получается');	
		
		
	}elseif (($text == "админ")&&($id)) {		
		
		$query = "UPDATE ".$table." SET status='admin' WHERE id_client=".$id;
		if ($result = $mysqli->query($query)) {		
			$tg->sendMessage($chat_id, "Добавлен новый администратор");	
		}else $tg->sendMessage($chat_id, 'Чего то не получается добавить администратора');	
		
		
	}elseif (($text == "-админ")&&($id)) {		
		
		$query = "UPDATE ".$table." SET status='client' WHERE id_client=".$id;
		if ($result = $mysqli->query($query)) {		
			$tg->sendMessage($chat_id, "На одного администратора стало меньше");	
		}else $tg->sendMessage($chat_id, 'Чего то не получается убрать администратора');	
		
		
	}elseif (($text == "бан")&&($id)) {		
		
		$query = "UPDATE ".$table." SET flag='1' WHERE id_client=".$id;
		if ($result = $mysqli->query($query)) {		
			$tg->sendMessage($chat_id, "Клиент добавлен в бан");	
		}else $tg->sendMessage($chat_id, 'Чего то не получается добавить клиента в бан');	
		
		
	}elseif (($text == "унбан")&&($id)) {		
		
		$query = "UPDATE ".$table." SET flag='0' WHERE id_client=".$id;
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
		
		
	}elseif ($text == "удали строки в таблице чаты") {		
	
		$query = "DELETE FROM ".$table6;				
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

		
		
	}elseif ($text == "удали клиента") {		
	
		$query = "DELETE FROM ".$table." WHERE id_client=". $id;				
		if ($result = $mysqli->query($query)) {					
			$tg->sendMessage($chat_id, "Удаление совершенно!");								
		}else $tg->sendMessage($chat_id, "Не получается удалить строки!");	
		
		
	
	}elseif ($text == "Стоп"||$text == "стоп") {			
		$tg->sendMessage($chat_id, "Хорошо, ты заходи, если шо)", null, true, null, $HideKeyboard);
	
	
	
	}elseif ($text == "Жеееесть") {			
		
		$query = "ALTER TABLE `obrabotka_zayavok` CHANGE `id_zakaz` `id_zakaz` VARCHAR( 20 ) NULL DEFAULT NULL";

		if ($result = $mysqli->query($query)) {					
			$tg->sendMessage($chat_id, "Изменил!");								
		}else $tg->sendMessage($chat_id, "Не смог!");	



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

		
		
	}elseif ($text!=="/start"&&$text!=="s"&&$text!=="S"&&$text!=="с"&&$text!=="С"&&$text!=="c"&&$text!=="C"&&$text !== "Старт"&&$text !== "старт") {
		if ($arr['message']['reply_to_message']) {  // и если это ответ на сообщение

			include_once '06_reply_to_message.php';					  // то подключается один файл

		}
		
		
	}
	
}
	
	
	



?>