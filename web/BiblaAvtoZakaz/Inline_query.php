<?

if ($inline_query) {

	//$bot->sendMessage($master, "еее");
	
	$InputTextMessageContent = [
		'message_text' => 'текст',
		'parse_mode' => null,
		'disable_web_page_preview' => false
	];

	$InlineQueryResultArticle = [
		[
			'type' => 'article',
			'id' => $from_id,
			'title' => 'тител',
			'input_message_content' => $InputTextMessageContent,			
			'description' => 'ляляля',			
		]
	];
	
	$р = $bot->answerInlineQuery($inline_query_id, $InlineQueryResultArticle);

    $bot->sendMessage($from_id, $bot->PrintArray($p). "\n\nTrututu\n\n".$inline_query_id."\n\n".$from_id);

}

?>
