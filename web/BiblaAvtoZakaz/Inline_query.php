<?

if ($inline_query) {

	//$bot->sendMessage($master, "еее");
	
	$InlineQueryResult = [
		[
			'type' => 'photo',
			'id' => $from_id,
			'photo_url' => 'https://i.ibb.co/SRCv6Z7/file-23.jpg',
			'thumb_url' => 'https://i.ibb.co/SRCv6Z7/file-21.jpg',
			'photo_width' => null,
			'photo_height' => null,
			'title' => null,
			'description' => null,
			'caption' => null,
			'parse_mode' => null,
			'reply_markup' => null,
			'input_message_content' => null		
		]	
	];
	
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
			'description' => null,
			'thumb_url' => null,
			'thumb_width' => null,
			'thumb_height' => null
		]
	];
	
	$bot->answerInlineQuery($inline_query_id, $InlineQueryResult);

}

?>