<?php
require('../vendor/autoload.php');

$body = file_get_contents('php://input'); //Получаем в $body json строку
$arr = json_decode($body, true); //Разбираем json запрос на массив в переменную $arr
  
//Сюда пишем токен, который нам выдал бот
$tg = new \TelegramBot\Api\BotApi('INSERT_TOKEN');

//Получаем текст сообщения, которое нам пришло.
$text = $arr['message']['text']; 
  
//Сразу и id получим, которому нужно отправлять всё это назад
$chat_id = $arr['message']['chat']['id'];
  
  
//ИМЯ ОТ КОГО ПРИШЛО СООБЩЕНИЕ  
$first_name = $arr['message']['from']['first_name'];


// ФЛАГ ДЛЯ ВКЛЮЧЕНИЯ РЕЖИМА ОТЛАДКИ БОТА
$OtladkaBota = 'нет';
//$OtladkaBota = 'да';


if ($text<>'') {
	if ($OtladkaBota == 'да') {
		if ($chat_id=='351009636') {
		
			// Подключение "тела" бота, в котором происходит опрос команд клиента
			include_once "bot_body.php";

		}else {
		
			$reply = $first_name . "- доброе сердце! \n\n\nИдёт режим отладки МЕНЯ! \n\nПока МАСТЕР не закончит МЕНЯ монтировать, хоть что пиши, я не буду реагировать. Извини.\n\n\nНу... ты заходи - ЕСЛИ ШО!";
		
			$tg->sendMessage($chat_id, $reply);
			
			//ОТПРАВКА ИФОРМАЦИИ О СООБЩЕНИИ МНЕ В ЛИЧКУ
	        $tg->sendMessage('351009636', $first_name . " мне пишет: \n\n" . $text);
			
		}				
	}else include_once "bot_body.php";	
}else $tg->sendMessage($chat_id, "Что это?");

  
exit('ok'); //Обязательно возвращаем "ok", чтобы телеграмм не подумал, что запрос не дошёл
?>
