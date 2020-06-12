<?
// Обрабатываем пришедшие данные
$data = $vk->init('php://input');

$type = $data['type'];
$object = $data['object'];
$group_id = $data['group_id'];
$event_id = $data['event_id'];
$secret =  $data['secret'];

/*
message_new
*/
if ($type == 'message_new') {
	$message = $object['message'];	
		$date = $message['date'];
		$from_id = $message['from_id'];
		$id = $message['id'];
		$out = $message['out'];
		$peer_id = $message['peer_id'];
		$text = $message['text'];
		$conversation_message_id = $message['conversation_message_id'];
		$fwd_messages = $message['fwd_messages']; // массив
			$fwd_date = $fwd_messages['date'];
			$fwd_from_id = $fwd_messages['from_id'];
			$fwd_text = $fwd_messages['text'];
			$fwd_attachments = $fwd_messages['attachments']; // массив
			$fwd_conversation_message_id = $fwd_messages['conversation_message_id'];
			$fwd_peer_id = $fwd_messages['peer_id'];
			$fwd_id = $fwd_messages['id'];
		$important = $message['important'];
		$random_id = $message['random_id'];
		$attachments = $message['attachments']; // массив
		if ($attachments) {
			foreach($attachments as $attach) {
				$attach_type = $attach['type'];
				if ($attach_type == 'photo') {
					$photo = $attach['photo'];
						$photo_album_id = $photo['album_id'];
						$photo_date = $photo['date'];
						$photo_id = $photo['id'];
						$photo_owner_id = $photo['owner_id'];
						$photo_has_tags = $photo['has_tags'];
						$photo_access_key = $photo['access_key'];
						$photo_sizes = $photo['sizes']; // тоже через цикл надо прогнать
						$photo_text = $photo['text'];
				}elseif ($attach_type == 'audio') {
					$audio = $attach['audio'];
						$audio_artist = $audio['artist'];
						$audio_id = $audio['id'];
						$audio_owner_id = $audio['owner_id'];
						$audio_title = $audio['title'];
						$audio_duration = $audio['duration'];
						$audio_track_code = $audio['track_code'];
						$audio_url = $audio['url'];
						$audio_date = $audio['date'];
						$audio_genre_id = $audio['genre_id'];
				}
			}
		}
		$payload = $message['payload']; // массив
		$is_hidden = $message['is_hidden'];		
	$client_info = $object['client_info'];		
		$button_actions = $client_info['button_actions'];		
		$keyboard = $client_info['keyboard'];
		$inline_keyboard = $client_info['inline_keyboard'];
		$lang_id = $client_info['lang_id'];
}


/*
wall_post_new
*/
if ($type == 'wall_post_new') {
	$id = $object['id'];
	$from_id = $object['from_id'];
	$owner_id = $object['owner_id'];
	$date = $object['date'];
	$marked_as_ads = $object['marked_as_ads'];
	$post_type = $object['post_type'];
	$text = $object['text'];
	$can_edit = $object['can_edit'];
	$created_by = $object['created_by'];
	$can_delete = $object['can_delete'];
	$attachments = $object['attachments']; // массив
	if ($attachments) {
		foreach($attachments as $attach) {
			$attach_type = $attach['type'];
			if ($attach_type == 'photo') {
				$photo = $attach['photo'];
					$photo_album_id = $photo['album_id'];
					$photo_date = $photo['date'];
					$photo_id = $photo['id'];
					$photo_owner_id = $photo['owner_id'];
					$photo_has_tags = $photo['has_tags'];
					$photo_access_key = $photo['access_key'];
					$photo_sizes = $photo['sizes']; // тоже через цикл надо прогнать
					$photo_text = $photo['text'];
					$photo_user_id = $photo['user_id'];
			}elseif ($attach_type == 'audio') {
				$audio = $attach['audio'];
					$audio_artist = $audio['artist'];
					$audio_id = $audio['id'];
					$audio_owner_id = $audio['owner_id'];
					$audio_title = $audio['title'];
					$audio_duration = $audio['duration'];
					$audio_track_code = $audio['track_code'];
					$audio_url = $audio['url'];
					$audio_date = $audio['date'];
					$audio_genre_id = $audio['genre_id'];
			}
		}
	}
	$comments = $object['comments']; // массив
	$is_favorite = $object['is_favorite'];
}

/*
photo_new
*/
if ($type == 'photo_new') {
	$album_id = $object['album_id'];
	$date = $object['date'];
	$id = $object['id'];
	$owner_id = $object['owner_id'];
	$has_tags = $object['has_tags'];
	$access_key = $object['access_key'];
	$sizes = $object['sizes']; // тоже через цикл надо прогнать
	if ($sizes) {
		$номер = -1;
		foreach($sizes as $size) {
			$номер++;
			$height[$номер] = $size['height'];
			$url[$номер] = $size['url'];
			$type[$номер] = $size['type'];
			$width[$номер] = $size['width'];
		}
	}
	$text = $object['text'];
	$user_id = $object['user_id'];
}


/*
group_change_settings
*/
if ($type == 'group_change_settings') {
	$user_id = $object['user_id'];
	$changes = $object['changes']; // массив
	if ($changes['website']) {
		$website = $changes['website'];
			$old_value = $website['old_value'];
			$new_value = $website['new_value'];
	}
}


/*
wall_reply_edit
*/
if ($type == 'wall_reply_edit') {
	$id = $object['id'];
	$from_id = $object['from_id'];
	$post_id = $object['post_id'];
	$owner_id = $object['owner_id'];
	$parents_stack = $object['parents_stack']; // массив
	$date = $object['date'];
	$text = $object['text'];
	$thread = $object['thread'];
		$count = $thread['count'];
	$post_owner_id = $object['post_owner_id'];
}


/*
wall_reply_delete
*/
if ($type == 'wall_reply_delete') {
	$owner_id = $object['owner_id'];
	$id = $object['id'];
	$deleter_id = $object['deleter_id'];
	$post_id = $object['post_id'];
}


/*
like_add
*/
if ($type == 'like_add') {
	$liker_id = $object['liker_id'];
	$object_type = $object['object_type'];
	$object_owner_id = $object['object_owner_id'];
	$object_id = $object['object_id'];
	$thread_reply_id = $object['thread_reply_id'];
	$post_id = $object['post_id'];
}


/*
photo_comment_new
*/
if ($type == 'photo_comment_new') {
	$id = $object['id'];
	$from_id = $object['from_id'];
	$parents_stack = $object['parents_stack']; // массив
	$date = $object['date'];
	$text = $object['text'];
	$thread = $object['thread'];
		$count = $thread['count'];
	$post_owner_id = $object['post_owner_id'];
	$photo_id = $object['photo_id'];
}


/*
photo_comment_delete
*/
if ($type == 'photo_comment_delete') {
	$owner_id = $object['owner_id'];
	$id = $object['id'];
	$deleter_id = $object['deleter_id'];
	$photo_id = $object['photo_id'];
	$user_id = $object['user_id'];
}






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