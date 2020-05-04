<?
/* Список всех функций:
**
** exception_handler	-	// функция отлова исключений
**
** ----------------------
** _старт_СайтБота
** ----------------------
**
** _проверка_заявок
*/

// при возникновении исключения вызывается эта функция
function exception_handler($exception) {
	global $bot, $master;	
	$bot->sendMessage($master, "Ошибка! ".$exception->getCode()." ".$exception->getMessage());	  
	exit('ok');  	
}

// функция старта бота ИНФОРМАЦИЯ О ПОЛЬЗОВАТЕЛЯХ
function _старт_СайтБота() {		
	global $bot, $table_users, $chat_id, $callback_from_first_name, $from_first_name, $HideKeyboard;	
	
	if (!$callback_from_first_name) $callback_from_first_name = $from_first_name;
	
	$bot->sendMessage($chat_id, "Добро пожаловать, *".$callback_from_first_name."*!", markdown, $HideKeyboard);	
	exit('ok');	
}
// функция проверки заявок клиентов на сайте
function _проверка_заявок() {	
	global $mysqli;	
	$ответ = false;
	$запрос = "SELECT * FROM `avtozakaz_pzmarket` WHERE id_client='7'";	
	$результат = $mysqli->query($запрос);	
	if ($результат) {		
		$количество = $результат->num_rows;		
		if ($количество > 0) {			
			$ответ = $результат->fetch_all(MYSQLI_ASSOC);
		}
	}	
	return $ответ;	
}
// отправка лота администрации на проверку и редактирование
function _отправка_лота_админам() {	
	global $table_market, $bot, $mysqli, $admin_group_AvtoZakaz, $логин;
	
	$запрос = "SELECT * FROM {$table_market} WHERE id_client='7' AND username='{$логин}' AND id_zakaz=0";
	
	$id = $логин;
	$кнопки = [ [ [ 'text' => 'Опубликовать',
		'callback_data' => 'опубликовать:'.$id ] ], ];
	
	$кнопки = array_merge($кнопки, [		
		[ [ 'text' => 'PRIZMarket доверяет',
			'callback_data' => 'доверяет:'.$id ] ],
		[ [ 'text' => 'PRIZMarket НЕ доверяет',
			'callback_data' => 'не_доверяет:'.$id ] ],
		[ [ 'text' => 'Редактировать название',
			'callback_data' => 'редактировать_название:'.$id ] ],
	]);				
	$результат = $mysqli->query($запрос);	
	if ($результат) {		
		if ($результат->num_rows == 1) {		
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);			
			foreach ($результМассив as $строка) {			
			
				$название = $строка['nazvanie'];
				if ($строка['url_nazv']) {					
					$ссыль_в_названии = $строка['url_nazv'];						
					$название_для_подробностей = "[{$название}]({$ссыль_в_названии})";
					$кнопки = array_merge($кнопки, [
						[ [ 'text' => 'Редактировать ссылку',
							'callback_data' => 'редактировать_ссылку:'.$id ] ],
					]);						
				}else $название_для_подробностей = str_replace('_', '\_', $название);	
				$кнопки = array_merge($кнопки, [
					[ [ 'text' => 'Редактировать хештеги',
						'callback_data' => 'редактировать_хештеги:'.$id ] ],
					[ [ 'text' => 'Редактировать подробности',
						'callback_data' => 'редактировать_подробности:'.$id ] ],
					[ [ 'text' => 'Редактировать фото',
						'callback_data' => 'редактировать_фото:'.$id ] ],	
				]);	
				
				$кнопки = array_merge($кнопки, [ [ [ 'text' => 'ОТКАЗАТЬ',
					'callback_data' => 'отказать:'.$id ] ],]);
				
				$inLine = [ 'inline_keyboard' => $кнопки ];				
				$куплю_или_продам = $строка['kuplu_prodam'];						
				$валюта = $строка['valuta'];				
				$хештеги_города = $строка['gorod'];		
				
				$юзера_имя = $строка['username']; // это логин
				
				$фото_с_амазон = $строка['url_tgraph'];
				$категория = $строка['otdel'];								
				$подробности = $строка['podrobno'];				
				$хештеги = "{$куплю_или_продам}\n\n{$категория}\n▪️";			
				$хештеги = str_replace('_', '\_', $хештеги);				
				$текст = "\n▪️{$валюта}\n▪️{$хештеги_города}\n▪️{$юзера_имя}\n\n{$подробности}";				
				$текст = str_replace('_', '\_', $текст);								
				if ($ссыль_в_названии) {					
					$ссыль_в_названии = str_replace('_', '\_', $ссыль_в_названии);		
					$текст = "{$хештеги}{$название_для_подробностей}\n({$ссыль_в_названии}){$текст}";		
				}else $текст = "{$хештеги}{$название_для_подробностей}{$текст}";
				
				$реплика = "[_________]({$фото_с_амазон})\n{$текст}";
				$КаналИнфо = $bot->sendMessage($admin_group_AvtoZakaz, $реплика, markdown, $inLine);			
				
				if (!$КаналИнфо) echo "<br><br>Не смог опубликовать лот в админке";				
			}					
		}else echo "<br><br>Или нет заказа или больше одного.. (_отправка_лота_админам)";	
	}else echo "<br><br>Нет такого заказа.. (_отправка_лота_админам)";	
}

?>
