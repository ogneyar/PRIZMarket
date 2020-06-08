<?
// Обрабатываем пришедшие данные
$data = $vk->init('php://input');
/*
"attachments": [{
	"type": "photo",
	"photo": {
		"album_id": -7,
		"date": 1585572784,
		"id": 457239365,
		"owner_id": 119909267,
		"has_tags": false,
		"access_key": "880e4cf1ea128a79a2",
		"sizes": [{
			"height": 97,
			"url": "https://sun9-46.userapi.com/c855636/v855636344/21bf5b/9c2UMQP1x48.jpg",
			"type": "m",
			"width": 130
		} их тут было 9 штук
		],
		"text": ""
	}
},
{
	"type": "audio",
	"audio": {
		"artist": "ПБ",
		"id": 456239024,
		"owner_id": 119909267,
		"title": "11.Война",
		"duration": 96,
		"track_code": "eaf14c7fa8jGJFN-amcPN5Yl-sDxiqMJqA",
		"url": "https://psv4.vkuseraudio.net/c4234/u5489898/audios/bdedd3aa38dd.mp3?extra=bkcMZUg95oEwXSO4MRILbqH9lNa92OYUeNxYaHU99f1O1f1ZJE8j1DFHDBEimY55uxdE6HgXyze2xGUi4Wt9-ldfE5dtzf5Wd1z-nlzkPjDhQXDfEop0fnUSBg6JVNuHKiPKVKs",
		"date": 1538561779,
		"genre_id": 18
	}
}];



"fwd_messages": [{
	"date": 1591032009,
	"from_id": 119909267,
	"text": "Курс",
	"attachments": [],
	"conversation_message_id": 31,
	"peer_id": 2000000016,
	"id": 7913
}];

{
	"type": "wall_post_new",
    "object": {
        "id": 35,
        "from_id": -190150616,
        "owner_id": -190150616,
        "date": 1591516534,
        "marked_as_ads": 0,
        "post_type": "post",
        "text": "патптапртапрапрт",
        "can_edit": 1,
        "created_by": 119909267,
        "can_delete": 1,
        "comments": {
            "count": 0
        },
        "is_favorite": false
    },
    "group_id": 190150616,
    "event_id": "c8f954253277a3615d21290e7e8626d8128057fa",
    "secret": "aaQdvgg43sdGgvFs2"
}

{
    "type": "photo_new",
    "object": {
        "album_id": 270858085,
        "date": 1591516678,
        "id": 457239050,
        "owner_id": -190150616,
        "has_tags": false,
        "sizes": [
            {
                "height": 70,
                "url": "https://sun9-40.userapi.com/c854416/v854416282/23c36d/_JcNqzk_LJA.jpg",
                "type": "s",
                "width": 75
            } их тут было 7 штук
        ],
        "text": "",
        "user_id": 100
    },
    "group_id": 190150616,
    "event_id": "fa6df0fc0fa933d11b12c82b1cefe03115287f5d",
    "secret": "aaQdvgg43sdGgvFs2"
}


{
    "type": "group_change_settings",
    "object": {
        "user_id": 119909267,
        "changes": {
            "website": {
                "old_value": "",
                "new_value": "https://prizmarket.online/"
            }
        }
    },
    "group_id": 190150616,
    "event_id": "faf456d236d4e454ae2a5d0db33d7bf07489c419",
    "secret": "aaQdvgg43sdGgvFs2"
}

*/

$type = $data['type'];

//if ($type == 'message_new') {
$object = $data['object'];
	$message = $object['message'];	
		$date = $message['date'];
		$from_id = $message['from_id'];
		$id = $message['id'];
		$out = $message['out'];
		$peer_id = $message['peer_id'];
		$text = $message['text'];
		$conversation_message_id = $message['conversation_message_id'];
		$fwd_messages = $message['fwd_messages']; // массив
		$important = $message['important'];
		$random_id = $message['random_id'];
		$attachments = $message['attachments']; // массив
		$payload = $message['payload']; // массив
		$is_hidden = $message['is_hidden'];		
	$client_info = $object['client_info'];		
		$button_actions = $client_info['button_actions'];		
		$keyboard = $client_info['keyboard'];
		$inline_keyboard = $client_info['inline_keyboard'];
		$lang_id = $client_info['lang_id'];		
$group_id = $data['group_id'];
$event_id = $data['event_id'];
$secret =  $data['secret'];
//}



$action1 = [
	'type' => 'text',
	'label' => 'primary',
	'payload' => [ 'button' => '1' ]
];

$action2 = [
	'type' => 'text',
	'label' => 'secondary',
	'payload' => [ 'button' => '2' ]
];

$action3 = [
	'type' => 'text',
	'label' => 'negative',
	'payload' => [ 'button' => '3' ]
];

$action4 = [
	'type' => 'text',
	'label' => 'positive',
	'payload' => [ 'button' => '4' ]
];

$кнопки = [
	[
		[
			'action' => $action1,
			'color' => 'primary'
		],
		[
			'action' => $action2,
			'color' => 'secondary'
		]
	],
	[
		[
			'action' => $action3,
			'color' => 'negative'
		],
		[
			'action' => $action4,
			'color' => 'positive'
		]
	]
];

$клавиатура_в_сообщении = [
	'one_time' => false,
	'buttons' => $кнопки,
	'inline' => true
];

?>