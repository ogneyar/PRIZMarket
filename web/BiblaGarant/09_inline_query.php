<?php

/*
**
**--------------------------------------------------
** обработка inline_query <- ответных сообщений!
**--------------------------------------------------
**
*/
if ($arr['inline_query']['query']) {	
	
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
	$tg->answerInlineQuery($inline_query_id, $res, null,null,null,'курс','4695');			
	
	exit('ok');
}else {
	$query = "SELECT * FROM ".$table3." WHERE id_zakaz=".$inline_query;
	if ($result = $mysqli->query($query)){	
	  if($result->num_rows>0){		
		$arrStrok = $result->fetch_all(MYSQLI_ASSOC);				
		
		if($arrStrok[0]['id_client']==$inline_query_from_id){
		
			$zayavka="\xF0\x9F\x97\xA3 #".$arrStrok[0]['vibor']."\n".
				"\xF0\x9F\x92\xB0 ".$arrStrok[0]['kol_monet']." ".$arrStrok[0]['monet']."\n".
				"\xF0\x9F\x92\xB8 ".$arrStrok[0]['cena']." ".$arrStrok[0]['valuta']." (".
				$arrStrok[0]['itog'].")\n"."\xF0\x9F\x8F\xA6 ".$arrStrok[0]['bank'].
				"\n\xF0\x9F\x91\xA8\xE2\x80\x8D\xE2\x9A\x96\xEF\xB8\x8F Гарант \xF0\x9F\xA4\x9D".
	//			"".
				"\n\n".$arrStrok[0]['id_client'].".".$arrStrok[0]['id_zakaz'];
				
			$title="Вставьте пост.";
			$jmi="\xF0\x9F\x97\xA3 #".$arrStrok[0]['vibor']."\n".
				"\xF0\x9F\x92\xB0 ".$arrStrok[0]['kol_monet']." ".$arrStrok[0]['monet'];
						
			
			
			//ПОСТРОЧНОЕ ЗАПОЛНЕНИЕ КНОПОК клавиатуры        			
			$inLine11_keyb=[[["text"=>$first_name_bot,"url"=>"http://t.me/".$username_bot]]];
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
