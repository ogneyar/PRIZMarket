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

// при вызове команды настроек ГарантБота подключается файл..
if ($text=='/setting'){
	if ($id_bota =='1037491432'||$id_bota =='1066944801') include_once 'bot_11_setting.php';
	exit('ok');
}

//if($new_chat_part_id) $tg->sendMessage($master, $new_chat_part_id);

// при добавлении ГарантБота в группу подключается файл..
if ($new_chat_part_id=='1037491432'||$new_chat_part_id=='1066944801') {
	include_once 'bot_12_addInGroup.php';	
}

// Обработчик исключений
set_exception_handler('exception_handler');

if ($arr['message']) { 						  // если это сообщение - message
	if ($arr['message']['reply_to_message']) {  // и если это ответ на сообщение
		include_once 'bot_06_reply.php';					  // то подключается один файл
	}else include_once 'bot_04_body.php';					  // иначе другой)
}
	
if ($arr['callback_query']) include_once 'bot_08_callback_query.php';// если это сообщение - callback_query

if ($arr['inline_query']) include_once 'bot_09_inline_query.php';// если это сообщение - inline_query
  
// подключение файла администрирования  

if ($this_admin == true||$arr['inline_query']) include_once 'bot_10_admin.php';

if ($arr['callback_query']&&$callbackChat_type!='private') include_once 'bot_13_garant.php';



if ($arr['channel_post']) {
$arrayChannelOrMessage = $arr['channel_post'];
}elseif ($arr['message']) $arrayChannelOrMessage = $arr['message'];

if ($arrayChannelOrMessage['reply_markup']['inline_keyboard'][0][0]['text']=='Подробнее'){
	if (($this_admin == true)||($from_id==$master)||($arrayChannelOrMessage['chat']['id']==$channel)){
		if ($chat_type=='private'||$callbackChat_type=='private'||($arrayChannelOrMessage['chat']['id']==$channel)) include 'bot_07_pzmarkt.php';		
	}else {
		$reply = $first_name ." не надо сюда лот кидать, если я правильно понял, то ".
			"Вам надо заявку подать, тогда ссыль на лот надо кидать в [ЗаказБот]".
			"(t.me/Zakaz_prizm_bot) \xF0\x9F\x91\x88 с пометкой 'В БОТ'";		
		if ($chat_type=='private'||$callbackChat_type=='private'){
			$tg->sendMessage($chat_id, $reply, markdown);
		}
	}		
}elseif ($arrayChannelOrMessage['reply_markup']['inline_keyboard']) {
	if (($this_admin == true)||($from_id==$master)||($arrayChannelOrMessage['chat']['id']==$channel)){
		if ($chat_type=='private'||$callbackChat_type=='private'){
			$tg->sendMessage($chat_id, "Лот не по формату.");
		}elseif ($arrayChannelOrMessage['chat']['id']==$channel) $tg->sendMessage($admin_group, "Лот не по формату.");		
	 }
}







?>