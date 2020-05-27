<?
include_once 'myBotApi/VK.php';
include_once 'a_conect.php';

// Создаем объект VK бота
$bot_vk = new VK($vk_token);
//$data_vk = $bot_vk->init('php://input');
include_once 'myBotApi/VKvariables.php';

$айди_вк_группы = "190150616";

if ($секрет !== $vk_secret_key) {
	 exit("Ошибка!");
}

if ($тип_данных_вк == "confirmation") {
	exit($vk_api_response);
}

if ($тип_данных_вк == "message_new") {

   include_once "BiblaVK_PZM/Message.php"; 

} 

exit("ok");
?>
