<?

if ($callback_data=='создать'){

	$bot->answerCallbackQuery($callback_query_id, "Начнём!");

	_создать();

}elseif ($callback_data=='продаю') {

	$bot->answerCallbackQuery($callback_query_id, "Ожидаю ввод названия!");	

	_prodayu();

}

?>