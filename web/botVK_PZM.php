<?
include_once 'myBotApi/VK.php';
include_once 'a_conect.php';

// Создаем объект VK бота
$bot_vk = new VK($vk_token);
$data_vk = $bot_vk->init('php://input');

$айди_вк_группы = "190150616";

//$data_vk = json_decode(file_get_contents('php://input'));

if ($data_vk->secret !== $vk_secret_key) {
	echo "Ошибка!";
	exit;
}

if ($data_vk->type == "confirmation") {
	echo $vk_api_response;
	exit;
}

elseif ($data_vk->object->body == "Прива") {

   $массив = [
      "access_token" => $vk_token, 
      "peer_id" => $data_vk->object->user_id, 
      "message" => "Ну да, здравствуй)", 
      "v" => $vk_api_version
   ];

  file_get_contents("https://api.vk.com/method/". "messages.send?". http_build_query($массив));


}elseif ($data_vk->type == "message_new") {

   include_once "BiblaVK_PZM/Message.php"; 

} 

echo "ok";
?>
