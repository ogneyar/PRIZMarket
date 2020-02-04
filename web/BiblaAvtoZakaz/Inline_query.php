<?

if ($inline_query) {

	$InlineQueryResult = [
		[
			'type' => 'article',
			'id' => $from_id,
			'title' => 'титл',
			'input_message_content' => [ 'message_text' => 'message_text' ],			
			'description' => 'нажми на кнопку'		
		]
	];
	
	$bot->answerInlineQuery($inline_query_id, $InlineQueryResult);

}

?>
