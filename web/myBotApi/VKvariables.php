<?
// Обрабатываем пришедшие данные
$data_vk = $bot_vk->init('php://input');

$тип_данных_вк = $data_vk['type'];

$секрет =  $data_vk['secret'];

$объект = $data_vk['object'];

$user_id_vk = $объект['user_id'];

$тело = $объект['body'];

?>