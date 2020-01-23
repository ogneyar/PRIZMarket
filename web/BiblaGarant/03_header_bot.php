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
	$tg->sendMessage($test_group, $reply); 
}

// при вызове команды настроек ГарантБота подключается файл..
if ($text=='/setting'){
	if ($id_bota =='1037491432'||$id_bota =='1066944801') include_once '11_setting.php';
	exit('ok');
}


if ($tokenGARANT){
	// при добавлении ГарантБота в группу подключается файл..
	if ($new_chat_part_id==$tokenGARANT) {
		include_once '12_addInGroup.php';	
	}
	// при удалении ГарантБота из группы подключается файл..
	if ($left_chat_part_id==$tokenGARANT) {
		include_once '14_delInGroup.php';	
	}
}

// Обработчик исключений
set_exception_handler('exception_handler');

if ($arr['message']) { 						  // если это сообщение - message
	if ($arr['message']['reply_to_message']) {  // и если это ответ на сообщение
		include_once '06_reply_to_message.php';					  // то подключается один файл
	}elseif($arr['message']['reply_markup']){
		if ($chat_type!='private') include_once '05_message_reply_markup.php';
	}else include_once '04_message_text.php';					  // иначе другой)
}
	
if ($arr['callback_query']) include_once '08_callback_query.php';// если это сообщение - callback_query

if ($arr['inline_query']) include_once '09_inline_query.php';// если это сообщение - inline_query
  
// подключение файла администрирования  

if ($this_admin == true||$master == $chat_id) include_once '10_admin.php';

if ($arr['callback_query']&&$callbackChat_type!='private') include_once '13_garant.php';






?>