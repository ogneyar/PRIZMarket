<?
if ($chatType == 'private') {
//------------------------------------------

if ($text=='/start') {
	_старт();
}elseif ($text=='/help') {
		
}elseif ($text=='/Privet') {
	$реплика = "Сам ты привет. И брат твой привет. И сестра твоя привет.";
	$bot_icq->sendText($chatId, $реплика);
}elseif ($text=='/KakDela') {
	$реплика = "Дааа норм чо, а #сам_чо_как?";
	$bot_icq->sendText($chatId, $реплика);
}elseif ($text=='/eee') {
	$реплика = "Так держать хозяин!";
	$bot_icq->sendText($chatId, $реплика);
}elseif ($text=='/uf') {
	$реплика = "Эт ты на каком языке? Уууфь, нет такой буквы в алфавите!";
	$bot_icq->sendText($chatId, $реплика);
}elseif ($text) $bot_icq->sendText($chatId, "я не понимаю(");

//------------------------------------------
}
?>
