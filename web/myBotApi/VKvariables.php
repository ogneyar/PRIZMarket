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
		},{
			"height": 98,
			"url": "https://sun9-7.userapi.com/c855636/v855636344/21bf5f/0w7ogBY5RRQ.jpg",
			"type": "o",
			"width": 130
		},{
			"height": 150,
			"url": "https://sun9-37.userapi.com/c855636/v855636344/21bf60/OlF2bF0RkcA.jpg",
			"type": "p",
			"width": 200
		},{
			"height": 240,
			"url": "https://sun9-65.userapi.com/c855636/v855636344/21bf61/FkErFlNE_w0.jpg",
			"type": "q",
			"width": 320
		},{
			"height": 383,
			"url": "https://sun9-25.userapi.com/c855636/v855636344/21bf62/YfVwkG1dnbE.jpg",
			"type": "r",
			"width": 510
		},{
			"height": 56,
			"url": "https://sun9-26.userapi.com/c855636/v855636344/21bf5a/kRHzKKJRqJ8.jpg",
			"type": "s",
			"width": 75
		},{
			"height": 453,
			"url": "https://sun9-31.userapi.com/c855636/v855636344/21bf5c/gMUuCcRJWmQ.jpg",
			"type": "x",
			"width": 604
		},{
			"height": 605,
			"url": "https://sun9-65.userapi.com/c855636/v855636344/21bf5d/7ZX1TqKaesw.jpg",
			"type": "y",
			"width": 807
		},{
			"height": 960,
			"url": "https://sun9-72.userapi.com/c855636/v855636344/21bf5e/Qe6I57kYqcc.jpg",
			"type": "z",
			"width": 1280
		}],
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
		$conv_message_id = $message['conversation_message_id'];
		$fwd_messages = $message['fwd_messages'];
		$important = $message['important'];
		$random_id = $message['random_id'];
		$attachments = $message['attachments'];
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


?>