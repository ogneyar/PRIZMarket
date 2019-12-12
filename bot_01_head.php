<?php

/*
** 
** +-------------------------------------+
** | НАЧАЛО САМОЙ ПРОГРАММЫ, ЕЁ ГОЛОВА)))|
** +-------------------------------------+
**
*/


if ($OtladkaBota == 'да') {
	// Вывод на печать JSON файла пришедшего от бота, в группу тестирования
	$reply=PrintArr($arr);
	$tg->sendMessage($admin_group_test, $reply); 
}

// Обработчик исключений
set_exception_handler('exception_handler');


// Ели сообщение из приватного чата
if ($chat_type=='private'||$callbackChat_type=='private') {

	if ($arr['message']) { 						  // если это сообщение - message
		if ($arr['message']['reply_to_message']) {  // и если это ответ на сообщение
			include_once 'bot_06_reply.php';					  // то подключается один файл
		}else include_once 'bot_04_body.php';					  // иначе другой)
	}
	
	if ($arr['callback_query']) include_once 'bot_08_inline.php';// если это сообщение - callback_query
  
  
// подключение файла администрирования  
}elseif (($this_admin == true)||($arr['inline_query'])) include_once 'bot_10_admin.php';


if ($arr['message']['reply_markup']){
	if ($arr['message']['reply_markup']['inline_keyboard'][0][0]['text']=='Подробнее'){
		if (($this_admin == true)||($chat_id==$master)){
			include 'bot_07_pzmarkt.php';
		}else {
			$reply = $first_name ." не надо сюда лот кидать, если я правильно понял, то ".
				"Вам надо заявку подать, тогда ссыль на лот надо кидать в [ЗаказБот]".
				"(t.me/Zakaz_prizm_bot) \xF0\x9F\x91\x88 с пометкой 'В БОТ'";		
			$tg->sendMessage($chat_id, $reply, markdown);
		}		
	}
}



?>