<?php

/*
**
**--------------------------------------------------
** обработка inline_query <- ответных сообщений!
**--------------------------------------------------
**
*/
if ($arr['inline_query']) {	
	
	//$reply = _kurs_PZM();
	$kurs_PZM = _kurs_PZM();
	//$курс_РКАЦ = _курс_РКАЦ();
	
	
	$kurs_PZM = str_replace("[CoinMarketCap](https://coinmarketcap.com/ru/currencies/prizm/)",
		"CoinMarketCap.com", $kurs_PZM);
		
	//$reply = $курс_РКАЦ . $kurs_PZM;
	$reply = $kurs_PZM;
	
	$title = "Курс PRIZM.";
	
	$chast_stroki = strstr($reply, 10, true);
	$kol = strlen($chast_stroki)+'1';
	$textClick = substr($reply, $kol);	
	
	// КНОПКА Репост
	$inLine10_but1=["text"=>"Репост","switch_inline_query"=>"курс"];

	// class InlineButton{
	// 	public $text = "Репост";
	// 	public $switch_inline_query = "курс";
	// }
	// $inlineButton = new InlineButton();

	// $tg->sendMessage($master, $inlineButton->text);

	$inLine10_str1=[$inLine10_but1];
	// $inLine10_str1=[$inlineButton];
	$inLine10_keyb=[$inLine10_str1];
	// $keyInLine10 = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLine10_keyb);
	$keyInLine10 = [$inLine10_keyb];
		
	$inputText = new \TelegramBot\Api\Types\Inline\InputMessageContent\Text($reply);	

	$queryArticle = new \TelegramBot\Api\Types\Inline\QueryResult\Article($inline_query_from_id,
	$title, $textClick, null,null,null, $inputText, $keyInLine10);		
	$res=[$queryArticle];
	
	// $res2=[["type"=>"article","id"=>$inline_query_from_id,"title"=>"kurs","description"=>"desc","input_message_content"=>["message_text"=>"text"]]];
	$res2=[["type"=>"article","id"=>$inline_query_from_id,"title"=>$title,"description"=>"desc","input_message_content"=>["message_text"=>$kurs_PZM],$keyInLine10]];

	$tg->sendMessage($master, "ghg");
	
	// include_once 'myBotApi/Bot.php';
	// $bot = new Bot($tokenMARKET);
	// $bot->answerInlineQuery($inline_query_id, $res2); 



	// $tg->answerInlineQuery($inline_query_id, $res, null, null, null, "в бот", "s");		
	// $tg->answerInlineQuery($inline_query_id, json_decode($res2), null, null, null, "в бот", "s");		
	
	exit('ok');
}

?>
