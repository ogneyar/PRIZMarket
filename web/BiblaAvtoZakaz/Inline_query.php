<?

if ($inline_query) {

	//$bot->sendMessage($master, "еее");
	
	$InlineQueryResult = [
		[
			'type' => 'article',
			'id' => $from_id,
			'title' => 'title',
			'input_message_content' => [ 'message_text' => 'message_text' ],			
			'description' => 'description'		
		]
	];
	
	$р = $bot->answerInlineQuery($inline_query_id, $InlineQueryResult);

    $bot->sendMessage($from_id, $bot->PrintArray($p));

}

?>
