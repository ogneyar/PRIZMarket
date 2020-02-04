<?

if ($inline_query) {

	$InlineQueryResult = [
		[
			'type' => 'article',
			'id' => $from_id,
			'title' => 'Отличная кнопка',
			'input_message_content' => [ 'message_text' => 'любой тут текст' ],
			'reply_markup' => null,
			'url' => null,
			'hide_url' => false,
			'description' => 'нажми её',
			'thumb_url' => null,
			'thumb_width' => null,
			'thumb_height' => null
		],
		[
			'type' => 'article',
			'id' => $from_id."-2",
			'title' => 'титл',
			'input_message_content' => [ 'message_text' => 'мессадж_текст' ],			
			'description' => 'нажми на кнопку'		
		]
	];
	
	$bot->answerInlineQuery($inline_query_id, $InlineQueryResult, 300, false, '', "in_bot", "s");

}

?>
