<?
// Обрабатываем пришедшие данные
$data = $bot->init('php://input');

// Вывод на печать JSON файла пришедшего от бота, в группу тестирования
if ($OtladkaBota == 'да') $bot->sendMessage($test_group, $bot->PrintArray($data)); 

$update_id = $data['update_id'];


if ($data['callback_query']){	

	$callback_query = $data['callback_query'];
	
	$callback_query_id = $data['callback_query']['id'];
	
	$callback_from = $data['callback_query']['from'];
	
	$callback_from_id = $callback_from['id'];
	$callback_from_first_name = $callback_from['first_name'];
	$callback_from_last_name = $callback_from['last_name'];
	$callback_from_username = $callback_from['username'];
	$callback_from_language = $callback_from['language_code'];
	
	$data['message'] = $data['callback_query']['message'];
	
	$callback_data = $data['callback_query']['data'];
	
}


if ($data['edited_message']){
	
	$edited_message = $data['edited_message'];
	
	$edit_date = $edited_message['edit_date'];
	
	$data['message'] = $edited_message;
	
}


if ($data['message']){

	$message_id = $data['message']['message_id'];

	if ($data['message']['from']){
		
		$message_from = $data['message']['from'];
		
		$from_id = $message_from['id'];
		$from_is_bot = $message_from['is_bot'];
		$from_first_name = $message_from['first_name'];
		$from_last_name = $message_from['last_name'];
		$from_username = $message_from['username'];
        $from_language = $message_from['language_code'];
	}
	
	if ($data['message']['chat']){
		
		$message_chat = $data['message']['chat'];
		
		$chat_id = $message_chat['id'];
		$chat_first_name = $message_chat['first_name'];
		$chat_last_name = $message_chat['last_name'];
		$chat_username = $message_chat['username'];
		$chat_title = $message_chat['title'];
		$chat_type = $message_chat['type'];
		
	}
		
	$date = $data['message']['date'];
		
	if ($data['message']['forward_from']) {
	
		$message_forward = $data['message']['forward_from'];

		$forward_id = $message_forward['id'];
		$forward_first_name = $message_forward['first_name'];
		$forward_last_name = $message_forward['last_name'];
		//if ($forward_last_name=="") $forward_last_name = 'отсутствует';
		$forward_username = $message_forward['username'];
		//if ($forward_username=="") $forward_username = 'отсутствует';

	}
	
	$forward_sender_name = $data['message']['forward_sender_name'];

	$forward_date = $data['message']['forward_date'];
	
	
	if ($data['message']['reply_to_message']){
		
		$reply_to_message = $data['message']['reply_to_message'];
		
        $reply_message_id = $reply_to_message['message_id'];
                
        $reply_from = $reply_to_message['from'];
                
		$reply_from_id = $reply_from['id'];
		$reply_from_first_name = $reply_from['first_name'];
		$reply_from_last_name = $reply_from['last_name'];
		//if ($reply_from_last_name=="") $reply_from_last_name = 'отсутствует';
		$reply_from_username = $reply_from['username'];
		//if ($reply_from_username=="") $reply_from_username = 'отсутствует';
		$reply_from_language = $reply_from['language_code'];	

        $reply_chat = $reply_to_message['chat'];
		
		$reply_chat_id = $reply_chat['id'];
		$reply_chat_first_name = $reply_chat['first_name'];
		$reply_chat_last_name = $reply_chat['last_name'];
		//if ($reply_chat_last_name=="") $reply_chat_last_name = 'отсутствует';
		$reply_chat_username = $reply_chat['username'];
		//if ($reply_chat_username=="") $reply_chat_username = 'отсутствует';
		$reply_chat_title = $reply_chat['title'];
		$reply_chat_type = $reply_chat['type'];

        $reply_date = $reply_to_message['date'];
		
        $reply_forward = $reply_to_message['forward_from'];

		$reply_forward_id = $reply_forward['id'];
		$reply_forward_first_name = $reply_forward['first_name'];
		$reply_forward_last_name = $reply_forward['last_name'];
		//if ($reply_forward_last_name=="") $reply_forward_last_name = 'отсутствует';
		$reply_forward_username = $reply_forward['username'];
		//if ($reply_forward_username=="") $reply_forward_username = 'отсутствует';

        $reply_forward_date = $reply_to_message['forward_date'];

        $reply_sender_name = $reply_to_message['forward_sender_name'];

		$reply_text = $reply_to_message['text'];
		
	}
	
	if ($data['message']['photo']) {
	
		$photo = $data['message']['photo'];
		
		if ($photo[2]){
		
			$file_id = $photo[2]['file_id'];
			
		}elseif ($photo[1]){
		
			$file_id = $photo[1]['file_id'];	
			
		}else {
		
			$file_id = $photo[0]['file_id'];	
			
		}
		
	}
	
	if ($data['message']['video']) {
	
		$video = $data['message']['video'];
		
		$file_id = $video['file_id'];			
		
	}
	
	
	$text = $data['message']['text'];
	
	if ($data['message']['reply_markup']) {
	
		$reply_markup = $data['message']['reply_markup'];
	
	}

}elseif ($data['channel_post']) {
	
	$message_id = $data['channel_post']['message_id'];
	
	$author_signature = $data['channel_post']['author_signature'];
	
	$chat_id = $data['channel_post']['chat']['id'];
	
	$chat_title = $data['channel_post']['chat']['title'];
	
	$chat_type = $data['channel_post']['chat']['type'];
	
	$date = $data['channel_post']['date'];
	
	$text = $data['channel_post']['text'];
	
	$entities = $data['channel_post']['entities'];
	
	
}elseif ($data['edited_channel_post']) {

}elseif ($data['inline_query']) {

}elseif ($data['chosen_inline_result']) {

//}elseif ($data['callback_query']) {

}elseif ($data['shipping_query']) {

}elseif ($data['pre_checkout_query']) {

}elseif ($data['poll']) {

}



$RKeyMarkup = [
	'keyboard' => [
		[			
			[
				'text' => "Старт"
			],
			[
				'text' => "Стоп"
			]
		]
	],
	'resize_keyboard' => true,
        'selective' => true,
];


$ReplyKeyboardMarkup = [
	'keyboard' => [
		[
			[
				'text' => "Новая кнопка!",
				'request_contact' => false,
				'request_location' => false,
			],
			[
				'text' => "Вторая новая кнопка!",
				'request_contact' => false,
				'request_location' => false,
			],
		],
	],
	'resize_keyboard' => false,
	'one_time_keyboard' => false,
	'selective' => false,
];


$HideKeyboard = [
	'hide_keyboard' => true,
    'selective' => false,
];


$InlineKeyboardMarkup = [
	'inline_keyboard' => [
		[
			[
				'text' => 'Информация',
				'callback_data' => 'information'
			]
		]
	]
];








$day = 86400;


?>
