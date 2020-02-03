<?

if ($inline_query) {

	//$bot->sendMessage($master, "еее");
	
	$InlineQueryResultPhoto = [
		[

			'type' => 'photo',
			'id' => $inline_query_id,
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
	
	$bot->answerInlineQuery($inline_query_id, $InlineQueryResultPhoto);

}

?>