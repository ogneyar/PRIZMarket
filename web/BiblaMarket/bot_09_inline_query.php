<?php

/*
**
**--------------------------------------------------
** обработка inline_query <- ответных сообщений!
**--------------------------------------------------
**
*/
if ($arr['inline_query']) {	
	
	//$messageText = _kurs_PZM();
	$kurs_PZM = _kurs_PZM();
	//$курс_РКАЦ = _курс_РКАЦ();
	
	
	$kurs_PZM = str_replace("[CoinMarketCap](https://coinmarketcap.com/ru/currencies/prizm/)",
		"CoinMarketCap.com", $kurs_PZM);
		
	//$messageText = $курс_РКАЦ . $kurs_PZM;
	$messageText = $kurs_PZM;
	
	// $title = "Курс PRIZM.";
	
	// $chast_stroki = strstr($messageText, 10, true);
	// $kol = strlen($chast_stroki) + 1;
	// $textClick = substr($messageText, $kol);	
	
	// КНОПКА Репост
	// $inLine10_but1=["text"=>"Репост","switch_inline_query"=>"курс"];
	// $inLine10_str1=[$inLine10_but1];
	$inLineKeyboard=[
		[
			[
				"text"=>"Репост",
				"switch_inline_query"=>"курс"
			]
		]
	];
	// $keyInLine10 = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLine10_keyb);
	// $keyInLine10 = ["inline_keyboard"=>$inLine10_keyb];
		
	// $inputText = new \TelegramBot\Api\Types\Inline\InputMessageContent\Text($messageText);	

	// $queryArticle = new \TelegramBot\Api\Types\Inline\QueryResult\Article($inline_query_from_id,
	// $title, $textClick, null,null,null, $inputText, $keyInLine10);		
	// $res=[$queryArticle];
	
	// $res2=[["type"=>"article","id"=>$inline_query_from_id,"title"=>"kurs","description"=>"desc","input_message_content"=>["message_text"=>"text"]]];
	$result=[
		[
			"type"=>"article",
			"id"=>$inline_query_from_id,
			"title"=>"Курс PRIZM.",
			"description"=>"курс PZM на CoinMarketCap.com",
			"input_message_content"=>["message_text"=>$messageText],
			"reply_markup"=>["inline_keyboard"=>$inLineKeyboard]
		]
	];

	
	include_once 'myBotApi/Bot.php';
	$bot = new Bot($tokenMARKET);
	$bot->answerInlineQuery($inline_query_id, $result); 
	


	// $tg->answerInlineQuery($inline_query_id, $res, null, null, null, "в бот", "s");
	
	exit('ok');
}

?>
