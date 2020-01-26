<?

if ($callback_data=='создать'){

	$bot->answerCallbackQuery($callback_query_id, "Начнём!");

	_insert_kuplu_prodam();

}elseif ($callback_data=='продаю') {

	$bot->answerCallbackQuery($callback_query_id, "Продано!");

	$bot->forwardMessage(
		$channel_info,
		$chat_id,
		$message_id
	);


}

?>