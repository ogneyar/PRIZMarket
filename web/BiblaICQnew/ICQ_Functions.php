<?
// реакция бота на команду старт
function _старт() {	
	global $bot_icq, $chatId, $firstName;
	$реплика = "Здравствуй ".$firstName."\n\nЯ помогу тебе узнать сколько стоит PRIZM на \nCoinMarketCap.com, \nдля этого нажми на команду \n/kurs \nили же пришли мне слово *Курс*. \n\nСписок понимаемых мною доп. команд: \n\n/privet \n\n/KakDela \n\n/eee \n\n/uf";
	$bot_icq->sendText($chatId, $реплика);
}



?>
