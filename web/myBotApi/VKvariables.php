<?
// Обрабатываем пришедшие данные
$data_vk = $bot_vk->init('php://input');

$тип_данных_вк = $data_vk['type'];

// до 5.80
/*
{
    "type": "message_new",
    "object": {
        "id": 75,
        "date": 1590662648,
        "out": 0,
        "user_id": 119909267,
        "read_state": 0,
        "title": "",
        "body": "Прива",
        "owner_ids": []
    },
    "group_id": 190150616,
    "event_id": "1b4c766d05b9836bc83e468c0c567aa21c94f18c",
    "secret": "aaQdvgg43sdGgvFs2"
}
*/

// после 5.79
/*
{
    "type": "message_new",
    "object": {
        "date": 1590682047,
        "from_id": 119909267,
        "id": 0,
        "out": 0,
        "peer_id": 2000000001,
        "text": "опролпропролпролпрол",
        "conversation_message_id": 14,
        "fwd_messages": [],
        "important": false,
        "random_id": 0,
        "attachments": [],
        "is_hidden": false
    },
    "group_id": 190150616,
    "event_id": "f9c98b37f02f4ffb362b524b2875c791d218b2f6",
    "secret": "aaQdvgg43sdGgvFs2"
}
*/

$секрет =  $data_vk['secret'];

$объект = $data_vk['object'];

if ($vk_api_version > '5.79') {
	
	$user_id_vk = $объект['from_id'];
	$тело = $объект['text'];
	
}else {
	
	$user_id_vk = $объект['user_id'];
	$тело = $объект['body'];
	
}



?>