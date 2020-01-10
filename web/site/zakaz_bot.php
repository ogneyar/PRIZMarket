<?php 	
	include_once '../../vendor/autoload.php';
	include_once '../a_conect.php';
	
	include_once 'site_01_head.php';
	
	include_once 'site_03_url.html';	
	
	include_once 'site_07_prinyat.html';	

	include_once 'site_09_footer.html';	

	$otrad = '298466355';
	// Группа администрирования бота (Админка)
	$admin_group = '-1001311775764';
	// Группа для тестирования бота (Тестрование Ботов)
	$admin_group_test = '-362469306'; 
	// Мастер это Я
	$master='351009636';

	$tg = new \TelegramBot\Api\BotApi($tokenMARKET);
	
	$url = $_SERVER['HTTP_HOST'].$_FILES["photo"]["tmp_name"];
	
	//."/".$_FILES['photo']['name'];
	
	
	$reply = "Из формы на сайте, пришёл заказ: \n" . $_POST["opisanie"] . "\n" .
		$_POST["stoimost"] . "\n" . $_POST["user_name"] . "\n" . $_POST["gorod"]."\n".$url;
		
	$tg->sendMessage($admin_group, $reply);  	
		
	//$file = new \CURLFile($url);	
	
	$file = file_get_contents($url);
		
	$tg->sendPhoto($admin_group, $file);  
	
/*	
	$media = new \TelegramBot\Api\Types\InputMedia\ArrayOfInputMedia();
	
	$media->addItem(new TelegramBot\Api\Types\InputMedia\InputMediaPhoto($_SERVER['HTTP_HOST'].
		$_FILES["photo"]["tmp_name"]));			

	$tg->sendMediaGroup($admin_group, $media);
*/	
	

	
	
?>		
</body>
</html>