<?

if ($callback_data=='создать'){

	$bot->answerCallbackQuery($callback_query_id, "Начнём!");

	_insert_kuplu_prodam();

}

?>