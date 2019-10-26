<?php

$knopa01 = "Кнопа1";
$knopa02 = "Кнопа2";
$knopa03 = "Кнопа3";
$knopa04 = "Кнопа4"; 
$knopa05 = "Кнопа5"; 
$knopa06 = "Кнопа6";
$knopa07 = "Кнопа7";
$knopa08 = "Кнопа8"; 
$knopa09 = "Кнопа9";


//ПОСТРОЧНОЕ ЗАПОЛНЕНИЕ КНОПОК KeybordReply
$stroka1 = [$knopa01, $knopa02, $knopa03];
$stroka2 = [$knopa04, $knopa05, $knopa06];
$stroka3 = [$knopa07, $knopa08, $knopa09];
	
$stolb	= [$stroka1, $stroka2, $stroka3];

//ПОСТРОЧНОЕ ЗАПОЛНЕНИЕ КНОПОК KeybordInLine

$inLine_button1=["text"=>"Ссыль","url"=>"http://google.com"];

$inLine_stroka1=[$inLine_button1];

$inLine_keyboard=[$inLine_stroka1];
 
//СОЗДАНИЕ КЛАВИАТУРЫ KeybordReply
$keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup($stolb, true, true);  

//new InlineKeyboardButton();

//СОЗДАНИЕ КЛАВИАТУРЫ KeybordInLine
$keyInLine = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLine_keyboard);

//ПРИРАВНИВАНИЕ РУССКОЯЗЫЧНЫХ КОМАНД ИНОСТРАННЫМ
if ($text=="Старт") $text="/start";
elseif ($text=="Помощь") $text="/help";
elseif ($text=="Меню") $text="/menu";
elseif ($text=="Стоп") $text="/stop";

$text = str_replace ("@NaHerokuBot", "", $text);
  
//ОСНОВНАЯ РАБОТА БОТА, ВЫПОЛНЕНИЕ КОМАНД (РЕАКЦИЯ НА РЕПЛИКИ ПОЛЬЗОВАТЕЛЯ)
if ($text == "/start") {
		 
        $reply = $first_name . "- золотце, здравствуй! \n Добро пожаловать! \n\n";
		
		$tg->sendMessage($chat_id, $reply);
		
	    $reply  = "Здесь можно много всего хорошего написать о боте о его работе, ";
		$reply .= "извиняюсь за тавтологию, но куда теперь без неё? \n";
		$reply .= "Работает бот на работе работу рабскую но ему, роботу всё нипочём!  \n\n";
		$reply .= "Для помощи используй команду /help.\n";
		
		$tg->sendMessage($chat_id, $reply);
		
		$reply = "Меню";
		
		$tg->sendMessage($chat_id, $reply, null, false, null, $keyboard);
		
		//$keyboard->ReplyKeyboardRemove();
            			
}elseif ($text == "/help")  {
		
        $reply = "Информация с помощью.";
		
        $tg->sendMessage($chat_id, $reply);
		
		$reply  = "Команды: \n\n\n/старт или /start - для старта бота. \n\n";
		$reply .= "Помощь или /help - вывод информации с помощью. \n\n";
		$reply .= "Меню или /menu - возврат в меню. \n\n";
		$reply .= "Стоп или /stop - ничего не произойдёт.\n\n\n";
		$reply .= "Ещё есть *секретная* команда:  Жопа  \n";
		
        $tg->sendMessage($chat_id, $reply);
			
}elseif ($text == "/menu")  {
		
		$reply = "Меню";		
		
        $tg->sendMessage($chat_id, $reply, null, false, null, $keyboard);
			
}elseif ($text == "/stop")  {
		
		$reply = "Ничего не произошло!";
		
        $tg->sendMessage($chat_id, $reply);
			
}elseif ($text == "Жопа")  {
		
		$reply = "Тсс, это секрет...   у жопы... у жопы есть... РУЧКИ!!!";
		
        $tg->sendMessage($chat_id, $reply);
			
}elseif ($text == $knopa01) {
		
        $reply = "Здесь будет Меню.)";
		
        $tg->sendMessage($chat_id, $reply, null, false, null, $keyInLine);
			
}elseif ($text == $knopa02) {
		
        $reply = "Ещё не придумал зачем тут эта кнопа!";
                
		$tg->sendMessage($chat_id, $reply);
			
}elseif ($text == $knopa03) {
		
        $reply = "Ещё не придумал зачем тут эта кнопа!";
                
		$tg->sendMessage($chat_id, $reply);
			
}elseif ($text == $knopa04) {
		
        $reply = "Ещё не придумал зачем тут эта кнопа!";
                
		$tg->sendMessage($chat_id, $reply);
			
}elseif ($text == $knopa05) {
		
        $reply = "Ещё не придумал зачем тут эта кнопа!";
                
		$tg->sendMessage($chat_id, $reply);
			
}elseif ($text == $knopa06) {
		
        $reply = "Ещё не придумал зачем тут эта кнопа!";
                
		$tg->sendMessage($chat_id, $reply);
			
}elseif ($text == $knopa07) {
		
        $reply = "Ещё не придумал зачем тут эта кнопа!";
                
		$tg->sendMessage($chat_id, $reply);
			
}elseif ($text == $knopa08) {
		
        $reply = "Ещё не придумал зачем тут эта кнопа!";
                
		$tg->sendMessage($chat_id, $reply);
			
}elseif ($text == $knopa09) {
	        
		$reply = "По говори со мной.";
        		
		$tg->sendMessage($chat_id, $reply);	
			
}else $tg->sendMessage($chat_id, "Я не пойму эту команду.");			
		
 



if ($OtladkaBota=='ы') {

	//ОТПРАВКА ИФОРМАЦИИ О СООБЩЕНИИ В ГРУППУ "ТЕСТ ТЕЛЕГРАМ БОТ АПИ"
	$tg->sendMessage('-1001306245472', $first_name . " мне пишет: \n\n" . $text);
	
	
	//ПЕРЕВОД РУССКОЯЗЫЧНОЙ РАСКЛАДКИ
	$body = html_entity_decode(str_replace('\u','&#',$body), ENT_NOQUOTES,'UTF-8'); 


	//$body = var_dump($body);
 
 
	//ОТПРАВКА В ГРУППУ "ТЕСТ NaHerokuBota" JSON-файла
	//if ($chat_id<>'351009636') 
	$tg->sendMessage('-362469306', $body);   

	
	//$tg->sendMessage('-362469306', $arr);

}
