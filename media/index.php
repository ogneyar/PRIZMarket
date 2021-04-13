<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Медиа PRIZMarket</title>
    <style>
        body {
            text-align: center;
        }
        h1 {
            padding: 100px 50px;
        }
        h4 {
            padding: 50px;
        }
    </style>
</head>
<body>
    <h1>Это домен сайта <a href="https://prizmarket.ru">prizmarket.ru</a>.</h1>
    <h4>Создан для хранения медиа файлов проекта!</h4>
</body>
</html>


<?php

// if (!file_exists('madeline.php')) {
//     copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
// }
// include 'madeline.php';

// $MadelineProto = new \danog\MadelineProto\API('session.madeline');
// $MadelineProto->async(true);
// $MadelineProto->loop(function () use ($MadelineProto) {
//     yield $MadelineProto->start();
	
// 	//yield $MadelineProto->echo('<br><br>OK, start!<br><br>');

//     $me = yield $MadelineProto->getSelf();

//     $MadelineProto->logger($me);

//     if (!$me['bot']) {
				
// 		$фото = null;
// 		$номер_заказа = null;
		
// 		if (isset($_POST['file'])) {
// 			$фото =  $_POST['file'];			
// 		}elseif (isset($_GET['file'])) {
// 			$фото =  $_GET['file'];			
// 		}
		
// 		if (isset($_POST['id_zakaz'])) {
// 			$номер_заказа = $_POST['id_zakaz'];			
// 		}elseif (isset($_GET['id_zakaz'])) {
// 			$номер_заказа = $_GET['id_zakaz'];			
// 		}//else $номер_заказа = "неизвестен";
		
// 		if ($фото&&$номер_заказа) {
		
// 			if (isset($_POST['tester']) || isset($_GET['tester']) || $номер_заказа == "неизвестен") {
// 				$канал_таймерботов = "https://t.me/tester_pzmarket";
// 			}else $канал_таймерботов = "https://t.me/joinchat/AAAAAEXiPca9AK_HDjSg5Q";
			
// 			$sentMessage = yield $MadelineProto->messages->sendMedia([
// 				'peer' => $канал_таймерботов,
// 				'media' => [
// 					'_' => 'inputMediaUploadedPhoto',
// 					'file' => $фото
// 				],
// 				'message' => "Лот:{$номер_заказа}",
// 				//'parse_mode' => 'Markdown'
// 			]);
		
// 		}else echo "<br><br><br><br><br><center>Этот сайт Вам впринципе без надобности, а мне (разработчику) просто необходим!</center>";
	

//     }//if(!$me['bot'])
	

// });//loop


// ?>