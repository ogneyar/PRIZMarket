<?

if ($inline_query) {

	$InlineQueryResult = [
		[
			'type' => 'article',
			'id' => $from_id,
			'title' => 'титл',
			'input_message_content' => [ 'message_text' => 'мессадж_текст' ],			
			'description' => 'нажми на кнопку'		
		]
	];
	
	$bot->answerInlineQuery($inline_query_id, $InlineQueryResultArticle);

}

?>
