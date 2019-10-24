<?php

require('../vendor/autoload.php');


$body = file_get_contents('php://input'); //Получаем в $body json строку

$arr = json_decode($body, true); //Разбираем json запрос на массив в переменную $arr

  
//Сюда пишем токен, который нам выдал бот
$tg = new \TelegramBot\Api\BotApi('983003158:AAFT2RsLpFdKLjb7qeo12t8EPDus6-TB6YI');


//Получаем текст сообщения, которое нам пришло.
$text = $arr['message']['text']; 

  
//Сразу и id получим, которому нужно отправлять всё это назад
$chat_id = $arr['message']['chat']['id'];
  
  
//ИМЯ ОТ КОГО ПРИШЛО СООБЩЕНИЕ  
$first_name = $arr['message']['from']['first_name'];


//ПОСТРОЧНОЕ ЗАПОЛНЕНИЕ КНОПОК KeybordMarkup
$stroka1 = ["Кнопа1"];
$stroka2 = ["Кнопа2а", "Кнопа2б"];
$stroka3 = ["Кнопа3"];
	
$stolb	= [$stroka1, $stroka2, $stroka3];

 
//СОЗДАНИЕ КЛАВИАТУРЫ reply_markup
$keyboard = new \TelegramBot\Api\Types\ReplyKeyboardMarkup($stolb, true);  


//ПРИРАВНИВАНИЕ РУССКОЯЗЫЧНЫХ КОМАНД ИНОСТРАННЫМ
if ($text=="/старт") $text="/start";
elseif ($text=="/помощь") $text="/help";
elseif ($text=="/меню") $text="/menu";
elseif ($text=="/стоп") $text="/stop";
  

//ОСНОВНАЯ РАБОТА БОТА, ВЫПОЛНЕНИЕ КОМАНД (РЕАКЦИЯ НА РЕПЛИКИ ПОЛЬЗОВАТЕЛЯ)
if ($text<>'') {
	
        if ($text == "/start") {
		 
                $reply = $first_name . "- золотце, здравствуй! \n Добро пожаловать! \n\n";
		
		$tg->sendMessage($chat_id, $reply);
		
	        $reply  = "Здесь можно много всего хорошего написать о боте о его работе, \n";
		$reply .= "извиняюсь за тавтологию, но куда теперь без неё? \n";
		$reply .= "Работает бот на работе работу рабскую но ему, роботу всё нипочём!  \n";
		
		$tg->sendMessage($chat_id, $reply);
		
		$reply = "Меню";
		
		$tg->sendMessage($chat_id, $reply, null, false, null, $keyboard);
            			
        }elseif ($text == "/help")  {
		
                $reply = "Информация с помощью.";
		
                $tg->sendMessage($chat_id, $reply);
		
		$reply  = "Команды: \n /старт или /start - для старта бота. \n";
		$reply .= "/помощь или /help - вывод информации с помощь \n";
		$reply .= "/меню или /menu - возврат в меню \n";
		$reply .= "/стоп или /stop - ничего не произойдёт.  \n";
		
                $tg->sendMessage($chat_id, $reply);
			
        }elseif ($text == "/menu")  {
		
		$reply = "Меню";		
		
                $tg->sendMessage($chat_id, $reply, null, false, null, $keyboard);
			
        }elseif ($text == "/stop")  {
		
		$reply = "Ничего, совсем!";
		
                $tg->sendMessage($chat_id, $reply);
			
        }elseif ($text == "Кнопа1") {
		
           	$reply = "Ещё не придумал зачем тут эта кнопа)";
		
                $tg->sendMessage($chat_id, $reply);
			
        }elseif ($text == "Кнопа2а") {
		
                $reply = "Ещё не придумал зачем тут эта кнопа!";
                
		$tg->sendMessage($chat_id, $reply);
			
        }elseif ($text == "Кнопа2б") {
		
                $reply = "Ещё не придумал зачем тут эта кнопа!";
                
		$tg->sendMessage($chat_id, $reply);
			
        }elseif ($text == "Кнопа3") {
	        
		$reply = "Ещё не придумал зачем тут третья кнопа.";
                
		$tg->sendMessage($chat_id, $reply);
			
        }			
		
}  


//ОТПРАВКА ИФОРМАЦИИ О СООБЩЕНИИ В ГРУППУ "ТЕСТ ТЕЛЕГРАМ БОТ АПИ"
if ($chat_id<>''&&$chat_id<>'-1001306245472') $tg->sendMessage('-1001306245472', 'Он: ' . $chat_id . "\n" . 'пишет: ' . $text);
 

//ОТПРАВКА В ГРУППУ "ТЕСТ NaHerokuBota" JSON-файла
//if ($chat_id<>'351009636') 
	$tg->sendMessage('-362469306', $body);  // или надо поставить сюда $arr
  

exit('ok'); //Обязательно возвращаем "ok", чтобы телеграмм не подумал, что запрос не дошёл


?>
