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
			'reply_markup' => null,
			'url' => null,
			'hide_url' => false,
			'description' => 'ляляля',
			'thumb_url' => null,
			'thumb_width' => null,
			'thumb_height' => null
		]
	];
	
	$bot->answerInlineQuery($inline_query_id, $InlineQueryResultArticle);

}

?>