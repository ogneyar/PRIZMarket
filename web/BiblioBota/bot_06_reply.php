<?php

// текст сообщения до "."
$sms = strstr($replyText, '.', true);
$str = $sms;
// переменная последнего символа 
$simbol = substr($sms, -1);


if ($simbol=='b') {
	$str = substr($sms,0,-1);	
	
	$spisok_bankov = substr(strrchr($str, 10), 1);
	if((stripos($spisok_bankov, $text))===false) $str.= $text.", ";				
	
	$str.= "." . $tehPodderjka . "Превосходно, теперь выберите с какими банками ".
		"Вы сотрудничаете? \xF0\x9F\x91\x87 Выбрать можно несколько, ".
		"или ввести название банка которого нет в списке. По окончанию жмите *ДАЛЕЕ!*";
	$tg->sendMessage($chat_id, $str, markdown, true, null, $keyInLine6);
	$tg->deleteMessage($chat_id, $message_id);
	$tg->deleteMessage($chat_id, $reply_message_id);
	
	
	
}elseif ($simbol=='g') {
	$str = substr($sms,0,-1);	
	$str.= "\xF0\x9F\x91\xA8\xE2\x80\x8D\xE2\x9A\x96\xEF\xB8\x8F";
	$str.= " Гарант: " . $text . "\n." . $tehPodderjka . "Чудесно! Всё, заявка готова!".
		" Для отправки её администратору *Безопасных сделок* нажмите *Готово!* \xF0\x9F\x91\x87";
	$tg->sendMessage($chat_id, $str, markdown, true, null, $keyInLine8);
	$tg->deleteMessage($chat_id, $message_id);
	$tg->deleteMessage($chat_id, $reply_message_id);


}elseif ($simbol=='o') {
	
	$last = substr(strrchr($sms, 10), 1);	
	
	$id = strstr($last, ' ', true);

	$otdel = vibor_otdela($text);
	
	if ($otdel){
		$query = "UPDATE {$table5} SET otdel='{$otdel}' WHERE id=" . $id;
		if ($result = $mysqli->query($query)) {		
			$reply = "Лот добавлен в категорию {$otdel}\n\nБРО -если надо, жми /start";
			$tg->sendMessage($chat_id, $reply, null, true);						
		}else throw new Exception("Не получилось добавить лот в категорию");			
	}else{
		$tg->sendMessage($chat_id, "Не верный ввод, повтори (в ОТВЕТНОМ сообщении)\n{$id} o.", null, false, null, $forceRep); 
	}
	
}






?>