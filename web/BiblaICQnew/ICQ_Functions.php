<?
// реакция бота на команду старт
function _старт() {	
	global $bot_icq, $chatId, $firstName;
	$реплика = "Здравствуй ".$firstName."\n\nЯ помогу тебе узнать сколько стоит PRIZM на CoinMarketCap.com, для этого нажми на команду /kurs или же пришли мне слово "Курс". \n\nСписок понимаемых мною доп. команд: \n\n/privet \n\n/KakDela \n\n/eee \n\n/uf";
	$bot_icq->sendText($chatId, $реплика);
}



?>
