<?
header("Content-Type: text/html; charset=utf-8");

include_once 'myBotApi/VK.php';
include_once 'myBotApi/Bot.php';
include_once 'a_conect.php';

// Создаем объект VK бота
$vk = new VK($vk_token);
include_once 'myBotApi/VKvariables.php';

$vk2 = new VK($vk_token2);

$bot = new Bot($tokenSite);

if ($secret !== $vk_secret_key) {
	echo "Ошибка!";
	exit;
}

if ($type == "confirmation") {
	//echo $vk_api_response;
	exit;
}

if ($type == "message_new") {

   include_once "BiblaVK_PZM/Message.php"; 

} 

echo "ok";
exit;
?>