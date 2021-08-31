<?php

/*
**
**--------------------------------------------------
** обработка inline_query <- ответных сообщений!
**--------------------------------------------------
**
*/
if ($arr['inline_query']) {	
	
	$kurs_PZM = _kurs_PZM();
	//$курс_РКАЦ = _курс_РКАЦ();
	$kurs_PZM = str_replace("[CoinMarketCap](https://coinmarketcap.com/ru/currencies/prizm/)",
		"CoinMarketCap.com", $kurs_PZM);
	//$messageText = $курс_РКАЦ . $kurs_PZM;
	$messageText = $kurs_PZM;
	$inLineKeyboard=[
		[
			[
				"text"=>"Репост",
				"switch_inline_query"=>"курс"
			]
		]
	];
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

	// использую свою библиотеку
	$bot->answerInlineQuery($inline_query_id, $result); 
	
	exit('ok');
}

?>
