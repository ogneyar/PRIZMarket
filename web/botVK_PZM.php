<?
include_once 'myBotApi/VK.php';
include_once 'a_conect.php';

// Создаем объект VK бота
$vk = new VK($vk_token);
include_once 'myBotApi/VKvariables.php';

$vk_group_id = "190150616";
$vk_album_id = "270858085";

if ($secret !== $vk_secret_key) {
	echo "Ошибка!";
	exit;
}

if ($type == "confirmation") {
	echo $vk_api_response;
	exit;
}

if ($type == "message_new") {

   include_once "BiblaVK_PZM/Message.php"; 

} 

echo "ok";
exit;
?>
