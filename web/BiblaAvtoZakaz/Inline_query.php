<?

if ($inline_query) {

	$InlineQueryResult = [
		[
			'type' => 'article',
			'id' => $from_id,
			'title' => 'Отличная кнопка',
			'input_message_content' => [ 'message_text' => 'любой тут текст' ],
			//'reply_markup' => null,
			//'url' => null,
			//'hide_url' => false,
			'description' => 'нажми её',
			//'thumb_url' => null,
			//'thumb_width' => null,
			//'thumb_height' => null
		],
		[
			'type' => 'article',
			'id' => $from_id."-2",
			'title' => 'Превосходная кнопка',
			'input_message_content' => [ 'message_text' => 'хоть какой текст' ],			
			'description' => 'нажми лучше её'			
		]
	];
	
	$bot->answerInlineQuery($inline_query_id, $InlineQueryResult, 300, false, '', "in_bot", "s");
	//

}

?>
