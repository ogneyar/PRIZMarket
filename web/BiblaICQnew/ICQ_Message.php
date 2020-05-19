<?
//include_once "../BiblaMarket/bot_03_func.php";

//$таблица_ожидание = 'market_ojidanie';

//$id_bota = strstr($tokenMarket, ':', true);

if ($chatType == 'private') {
//------------------------------------------

if ($text=='/start') {
	_старт();
}elseif ($text=='/help') {
		
}elseif ($text=='/kurs' || $text=='курс' || $text=='Курс') {

$bot_icq->sendText($chatId, "кз");


        $курс = _kurs_PZM();
        $курс = str_replace("[CoinMarketCap](https://coinmarketcap.com/ru/currencies/prizm/)",
		"CoinMarketCap.com", $курс);
	$bot_icq->sendText($chatId, $курс);

$bot_icq->sendText($chatId, "хз");

}elseif ($text=='/privet' || $text=='привет' || $text=='Привет') {
	$реплика = "Сам ты привет. И брат твой привет. И сестра твоя привет.";
	$bot_icq->sendText($chatId, $реплика);
}elseif ($text=='/KakDela' || $text=='Как дела?' || $text=='как дела?' || $text=='Как дела' || $text=='как дела') {
	$реплика = "Дааа норм чо, #сам_чо_как?";
	$bot_icq->sendText($chatId, $реплика);
}elseif ($text=='/eee' || $text=='Еее' || $text=='еее' || $text=='Eee' || $text=='eee') {
	$реплика = "Так держать хозяин!";
	$bot_icq->sendText($chatId, $реплика);
}elseif ($text=='/uf' || $text=='Уфь' || $text=='уфь') {
	$реплика = "Эт ты на каком языке? Уууфь, нет такой буквы в алфавите!";
	$bot_icq->sendText($chatId, $реплика);
}elseif ($text) $bot_icq->sendText($chatId, "я не понимаю(");

//------------------------------------------
}
?>
