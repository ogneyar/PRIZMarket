<?

if ($inline_query) {

	$результат = _возврат_лотов_для_инлайн($from_id);
	
	$bot->answerInlineQuery($inline_query_id, $результат, null, false, null, "в бот", "s");

}

?>
