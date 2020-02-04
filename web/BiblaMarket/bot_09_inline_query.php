<?php

/*
**
**--------------------------------------------------
** обработка inline_query <- ответных сообщений!
**--------------------------------------------------
**
*/
if ($arr['inline_query']['query']=='курс'||$arr['inline_query']['query']=='Курс') {	
	
	$reply = _kurs_PZM();
	
	$reply = str_replace("[CoinMarketCap:](https://coinmarketcap.com/ru/currencies/prizm/)",
		"CoinMarketCap:", $reply);
	
	$title = "Курс PRIZM.";
	
	$chast_stroki = strstr($reply, 10, true);
	$kol = strlen($chast_stroki)+'1';
	$textClick = substr($reply, $kol);	
	
	// КНОПКА Репост
	$inLine10_but1=["text"=>"Репост","switch_inline_query"=>"курс"];
	$inLine10_str1=[$inLine10_but1];
	$inLine10_keyb=[$inLine10_str1];
	$keyInLine10 = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLine10_keyb);
		
	$inputText = new \TelegramBot\Api\Types\Inline\InputMessageContent\Text($reply);		
		
	$queryArticle = new \TelegramBot\Api\Types\Inline\QueryResult\Article($inline_query_from_id,
		$title, $textClick, null,null,null, $inputText, $keyInLine10);		
	$res=[$queryArticle];				
	$tg->answerInlineQuery($inline_query_id, $res, null, null, null, "в бот", "s");			
	
	exit('ok');
}

?>
