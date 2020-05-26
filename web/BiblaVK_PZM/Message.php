<?
include_once "../myBotApi/VK.php";

$bot_vk = new VK($vk_token);

$bot_vk->mesSend($data_vk->object->user_id, "не пойму(");


?>