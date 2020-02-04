<?

if ($inline_query) {

	$InlineQueryResult = [
		[
			'type' => 'article',
			'id' => $from_id,
			'title' => 'title',
			'input_message_content' => [ 'message_text' => 'message_text' ],			
			'description' => 'дескрипшн'		
		]
	];
	
	$bot->answerInlineQuery($inline_query_id, $InlineQueryResult);

}

?>
