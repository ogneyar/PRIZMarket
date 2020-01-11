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
	$tg->answerInlineQuery($inline_query_id, $res);			
	
	exit('ok');
}else {
	$query = "SELECT * FROM ".$table3." WHERE id_zakaz=".$inline_query;
	if ($result = $mysqli->query($query)){	
	  if($result->num_rows>0){		
		$arrStrok = $result->fetch_all();				
		
		if($arrStrok[0][0]==$inline_query_from_id){
		
			$zayavka="\xF0\x9F\x97\xA3 #".$arrStrok[0][2]."\n".
				"\xF0\x9F\x92\xB0 ".$arrStrok[0][4]." ".$arrStrok[0][3]."\n".
				"\xF0\x9F\x92\xB8 ".$arrStrok[0][6]." ".$arrStrok[0][5]." (".$arrStrok[0][7].")\n".
				"\xF0\x9F\x8F\xA6 ".$arrStrok[0][8]."\n\n".$arrStrok[0][0].".".$arrStrok[0][1];		
				
			$title="Вставьте пост.";
			$jmi="\xF0\x9F\x97\xA3 #".$arrStrok[0][2]."\n".
				"\xF0\x9F\x92\xB0 ".$arrStrok[0][4]." ".$arrStrok[0][3];
						
			//ПОСТРОЧНОЕ ЗАПОЛНЕНИЕ КНОПОК клавиатуры        			
			$inLine11_keyb=[[["text"=>"На рассмотрении..","callback_data"=>"rassmotrenie"]]];
			$keyInLine11 = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLine11_keyb);
			
			$inputText = new \TelegramBot\Api\Types\Inline\InputMessageContent\Text($zayavka);		
					
			
			$queryArticle = new \TelegramBot\Api\Types\Inline\QueryResult\Article($inline_query_from_id, $title, $jmi, null,null,null, $inputText, $keyInLine11);		
			$res=[$queryArticle];				
			$tg->answerInlineQuery($inline_query_id, $res);			
		}
	  }	
	}	
	//exit('ok');
}

?>