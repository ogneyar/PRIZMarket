<?
// Обрабатываем пришедшие данные
$data = $vk->init('php://input');
/*{
"type": "message_new",
"object": {
	"message": {
		"date": 1590682878,
		"from_id": 119909267,
		"id": 0,
		"out": 0,
		"peer_id": 2000000001,
		"text": "Прива",
		"conversation_message_id": 15,
		"fwd_messages": [],
		"important": false,
		"random_id": 0,
		"attachments": [],
		"is_hidden": false
	},
	"client_info": {
		"button_actions": [
			"text",
			"vkpay",
			"open_app",
			"location",
			"open_link"
		],
		"keyboard": true,
		"inline_keyboard": true,
		"lang_id": 0
	}
},
"group_id": 190150616,
"event_id": "4b29dd9172ff623839541ee7ca450b5a44b89339",
"secret": "aaQdvgg43sdGgvFs2"
}*/

$type = $data['type'];

$object = $data['object'];

	$message = $object['message'];
		
		$from_id = $message['from_id'];

		$text = $message['text'];
	

	
$group_id = $data['group_id'];

$event_id = $data['event_id'];

$secret =  $data['secret'];



?>