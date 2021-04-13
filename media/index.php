<?php

if (!file_exists('madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
include 'madeline.php';

$MadelineProto = new \danog\MadelineProto\API('session.madeline');
$MadelineProto->async(true);
$MadelineProto->loop(function () use ($MadelineProto) {
    yield $MadelineProto->start();
	
	//yield $MadelineProto->echo('<br><br>OK, start!<br><br>');

    $me = yield $MadelineProto->getSelf();

    $MadelineProto->logger($me);

    if (!$me['bot']) {
				
		$фото = null;
		$номер_заказа = null;
		
		if (isset($_POST['file'])) {
			$фото =  $_POST['file'];			
		}elseif (isset($_GET['file'])) {
			$фото =  $_GET['file'];			
		}
		
		if (isset($_POST['id_zakaz'])) {
			$номер_заказа = $_POST['id_zakaz'];			
		}elseif (isset($_GET['id_zakaz'])) {
			$номер_заказа = $_GET['id_zakaz'];			
		}else $номер_заказа = "неизвестен";
		
		if ($фото&&$номер_заказа) {
		
			if (isset($_POST['tester']) || isset($_GET['tester']) || $номер_заказа == "неизвестен") {
				$канал_таймерботов = "https://t.me/tester_pzmarket";
			}else $канал_таймерботов = "https://t.me/joinchat/AAAAAEXiPca9AK_HDjSg5Q";
			
			$sentMessage = yield $MadelineProto->messages->sendMedia([
				'peer' => $канал_таймерботов,
				'media' => [
					'_' => 'inputMediaUploadedPhoto',
					'file' => $фото
				],
				'message' => "Лот:{$номер_заказа}",
				//'parse_mode' => 'Markdown'
			]);
		
		}else {
			echo "<br><br><br><br><br><center>Этот сайт Вам впринципе без надобности, а мне (разработчику) просто необходим!</center>";
			echo __DIR__;
		}
	

    }//if(!$me['bot'])
	

});//loop


?>