<?php

require('../vendor/autoload.php');


$body = file_get_contents('php://input'); //Получаем в $body json строку

$arr = json_decode($body, true); //Разбираем json запрос на массив в переменную $arr

  
//Сюда пишем токен, который нам выдал бот
$tg = new \TelegramBot\Api\BotApi('983003157:AAFT2RsLpFdKLjb7qeo12t8EPDus6-TB6YI');


//Получаем текст сообщения, которое нам пришло.
$text = $arr['message']['text']; 

  
//Сразу и id получим, которому нужно отправлять всё это назад
$chat_id = $arr['message']['chat']['id'];
  
  
//ИМЯ ОТ КОГО ПРИШЛО СООБЩЕНИЕ  
$first_name = $arr['message']['from']['first_name'];

 
//СОЗДАНИЕ КЛАВИАТУРЫ reply_markup
$keyboard = [
     ["Кнопа1"],
	   ["Кнопа2"],
	   ["Кнопа3"]
];  


//$tg->sendMessage($chat_id, "Отправьте текстовое сообщение.");
  
  
  
if ($text<>'') {
        if ($text == "/start") {
		 
            $reply = $first_name . " бедолага, здравствуй! \n Добро пожаловать!";
			
            //$reply_markup = $tg->ReplyKeyboardMarkup( 'keyboard' => $keyboard, 'resizeKeyboard' => true, 'oneTimeKeyboard' => false );
            //$tg->sendMessage( 'chat_id' => $chat_id, 'text' => $reply, 'replyMarkup' => $reply_markup );
			
			      $tg->sendMessage($chat_id, $reply);
			
        }elseif ($text == "/help")  {
		
            $reply = "Информация с помощью.";
            $tg->sendMessage($chat_id, $reply);
			
        }elseif ($text == "Кнопа1") {
		
            //$url = "https://68.media.tumblr.com/6d830b4f2c455f9cb6cd4ebe5011d2b8/tumblr_oj49kevkUz1v4bb1no1_500.jpg";
            //$telegram->sendPhoto([ 'chat_id' => $chat_id, 'photo' => $url, 'caption' => "Описание." ]);
			
		      	$reply = "Ещё не придумал зачем тут эта кнопа)";
            $tg->sendMessage($chat_id, $reply);
			
        }elseif ($text == "Кнопа2") {
		
            //$url = "https://68.media.tumblr.com/bd08f2aa85a6eb8b7a9f4b07c0807d71/tumblr_ofrc94sG1e1sjmm5ao1_400.gif";
            //$telegram->sendDocument([ 'chat_id' => $chat_id, 'document' => $url, 'caption' => "Описание." ]);
			
	  	    	$reply = "Ещё не придумал зачем тут эта кнопа!";
            $tg->sendMessage($chat_id, $reply);
			
        }elseif ($text == "Кнопа3") {
		
            //$html=simplexml_load_file('http://netology.ru/blog/rss.xml');
            //foreach ($html->channel->item as $item) { 
	        //$reply .= "\xE2\x9E\xA1 ".$item->title." (<a href='".$item->link."'>читать</a>)\n";	}
            //$telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode' => 'HTML', 'disable_web_page_preview' => true, 'text' => $reply ]);
			
		      	$reply = "Ещё не придумал зачем тут третья кнопа.";
            $tg->sendMessage($chat_id, $reply);
			
        }
/*		
		else{
		
        	//$reply = "По запросу \"<b>".$text."</b>\" ничего не найдено.";
        	//$telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode'=> 'HTML', 'text' => $reply ]);
			
			$reply = "Мне не ясен Ваш "Французский".";
            $tg->sendMessage($chat_id, $reply);
			
        }  */
		
}
  

  
//Используем sendMessage для отправки сообщения в ответ
//$tg->sendMessage($tg_id, $sms_rev);

/*
//РЕАКЦИЯ БОТА НА КОМАНДУ /СТАРТ
if ($text=='/start') {    
	$tg->sendMessage($chat_id, 'Главная страница' . "\n");
	$tg->sendMessage($chat_id, '\XE2\x9C\X8A');	
	}
else $tg->sendMessage($chat_id, 'ФигВам' . "\n"); 
*/

//ОТПРАВКА ИФОРМАЦИИ О СООБЩЕНИИ МНЕ В ЛИЧКУ
if ($chat_id<>''&&$chat_id<>'-1001306245472'&&$chat_id<>'351009636') $tg->sendMessage('351009636', 'Он: ' . $chat_id . "\n" . 'пишет: ' . $text);
 

  
exit('ok'); //Обязательно возвращаем "ok", чтобы телеграмм не подумал, что запрос не дошёл


?>
