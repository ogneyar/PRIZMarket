<?php

/* +------------+
 * |  Class VK  |
 * +------------+
 *
 * init
 *
 * call
 *
 * upload
 *
 * uploadAndGetUrl
 *
 *
 * +-------------------+
 * |  Список методов:  |
 * +-------------------+
 *
 *------------
 *  messages  
 *------------
 *
 * messagesSend
 *
 * messagesEdit
 *
 * messagesPin
 *
 * messagesUnpin
 *
 * messagesDelete
 *
 * messagesCreateChat
 *
 *
 *
 *----------
 *  photos  
 *---------- 
 *
 * photosGetUploadServer
 *
 * photosSave
 *
 * photosEdit
 *
 * photosDelete
 *
 * photosCreateAlbum
 *
 * photosEditAlbum
 *
 * photosDeleteAlbum
 *
 * photosGet
 *
 * photosGetAll
 * 
 * photosGetAlbums
 *
 * photosGetAlbumsCount
 *
 * photosGetAllComments
 *
 * photosGetById
 *
 * photosGetComments
 *
 * photosCreateComment
 *
 * photosEditComment
 *
 * photosDeleteComment
 *
 * photosGetChatUploadServer
 *
 * photosGetMessagesUploadServer
 *
 * photosSaveMessagesPhoto
 *
 *
 *
 *
 *-------- 
 *  wall  
 *--------
 *
 * wallCheckCopyrightLink
 *
 * wallPost
 *
 * wallDelete
 *
 * wallEdit
 *
 * wallCloseComments
 *
 * wallOpenComments
 *
 * wallCreateComment
 *
 * wallEditComment
 *
 * wallDeleteComment
 *
 * wallGet
 *
 * wallGetById
 *
 * wallSearch
 *
 * wallGetComment
 *
 * wallGetComments
 *
 * wallGetReposts
 *
 * wallPin
 *
 * wallUnpin
 *
 * wallRepost
 *
 */

class VK
{
    // $token - токен бота 
    public $token = null;

    // адрес для запросов к API
    public $apiUrl = "https://api.vk.com/method/";
	

	/*
	** @param str $token
	*/

    public function __construct($token, $version = '5.107')
    {
		$this->token = $token;
		$this->version = $version;
    }    
    
    

	/*
	** @param JSON $data
	** @return array
	*/

    public function init($data)
    {        
        return json_decode(file_get_contents($data), true); 
    }
	


    /* 
	** Отправляем запрос 
	**
    ** @param str $method
    ** @param array $data    
	**
    ** @return mixed
    */

    public function call($method, $data = [])
    {
        $response = null;		
		
	   	$data['access_token'] = $this->token;
		$data['v'] = $this->version;
		
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . $method);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		//curl_setopt($ch, CURLOPT_HEADER, false);
        $result = curl_exec($ch);
        curl_close($ch);
		
		//file_get_contents($this->apiUrl . $method . "?". http_build_query($data));

        $response = json_decode($result, true);
		
		if ($response['error']) return $response['error'];
		else return $response['response'];
    }
	
	
	/* 
	** Загрузка файла на сервер ВК
	**
    ** @param str $url
    ** @param file $file    
	**
    ** @return mixed
    */

    public function upload($url, $file)
    {
        $response = null;		
		
		$mimetype = mime_content_type($file);
		$file_name = basename($file);
		$curl_file = new CURLFile($file, $mimetype, $file_name);
		
		$data = ['file1' => $curl_file];
		
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
        $result = curl_exec($ch);
        curl_close($ch);
		
        $response = json_decode($result, true);
		
        return $response;
    }

	
	
	/* 
	** Функция загружает файл на сервер ВК, сохраняет его и 
	** возвращает ссылку на файл в ВК
	**
    ** @param str $album_id
	** @param str $group_id
    ** @param str $file    
	**
    ** @return mixed
    */

	public function uploadAndGetUrl(
		$album_id, 
		$group_id, 
		$file
	) {					
		$response = [];
		
		$result = $this->photosGetUploadServer($album_id, $group_id);	
		//if ($result['error_msg']) exit;
		$result = $this->upload($result['upload_url'], $file);
		$server = $result['server'];
		$photos_list = $result['photos_list'];
		$hash = $result['hash'];	
		//if ($photos_list == []) exit;		
		$result = $this->photosSave($album_id, $group_id, $server, $photos_list, $hash);
		//if ($result['error_msg']) exit;
		// 
		$url_vk = "https://vk.com/photo".$result[0]['owner_id']."_".$result[0]['id'];
		$vk_file = "photo".$result[0]['owner_id']."_".$result[0]['id'];
		foreach($result[0]['sizes'] as $size) {		
			$url = $size['url'];			
		}				
		$response['url_vk'] = $url_vk;
		$response['vk_file'] = $vk_file;
		$response['url'] = $url;	
		$response['id'] = $result[0]['id'];
		
		return $response;
	}

	
	
	
//--------------------------------------
//------------  МЕТОДЫ  ----------------
//--------------------------------------
    
	
/*-------------------------------*/
/*			  messages			 */
/*-------------------------------*/		
	
    /*
	**  функция отправки сообщения 
	**
	**  @param int $user_id
 	**  @param int $random_id
	**  @param int $peer_id
	**  @param str $domain
	**  @param int $chat_id
	**  @param [int] $user_ids
	**  @param str $message
	**  @param real $lat
	**  @param real $long
	**  @param array $attachment
	**  @param int $reply_to
	**  @param [int] $forward_messages
	**  @param int $sticker_id
	**  @param int $group_id
	**  @param obj $keyboard
	**  @param int $payload
	**  @param bool $dont_parse_links
	**  @param bool $disable_mentions
	**  @param str $intent
	**  
	**  @return integer (message_id) 
	*/

    public function messagesSend(
		$peer_id, 
		$message,
		$attachment = null,
		$reply_to = null,
		$forward_messages = null,
		$keyboard = null,
		$user_id = null,
		$random_id = null,	
		$domain = null,
		$chat_id = null,
		$user_ids = null,	
		$lat = null,
		$long = null,	
		$sticker_id = null,
		$group_id = null,		
		$payload = null,
		$dont_parse_links = false,
		$disable_mentions = false,
		$intent = null
	) {				
		
		$random_id = time();
		
		$response = $this->call("messages.send", [				
			'user_id' => $user_id,
			'random_id' => $random_id,
			'peer_id' => $peer_id,
			'domain' => $domain,
			'chat_id' => $chat_id,
			'user_ids' => $user_ids,
			'message' => $message,
			'lat' => $lat,
			'long' => $long,
			'attachment' => $attachment,
			'reply_to' => $reply_to,
			'forward_messages' => $forward_messages,
			'sticker_id' => $sticker_id,
			'group_id' => $group_id,
			'keyboard' => $keyboard,
			'payload' => $payload,
			'dont_parse_links' => $dont_parse_links,
			'disable_mentions' => $disable_mentions,
			'intent' => $intent
		]);	
	
		return $response;
	}
	
	
	/*
	**  функция редактирования сообщения
	**
	**  @param int $peer_id
	**  @param int $message_id
 	**  @param str $message
 	**  @param str $attachment
	**  @param boolean $keep_forward_messages
 	**  @param boolean $keep_snippets
	**  @param int $group_id
 	**  @param boolean $dont_parse_links
 	**  @param real $lat
	**  @param real $long
	**  
	**  
	**  @return array 
	*/
    public function messagesEdit(
		$peer_id,
		$message_id,
		$message = null,
		$attachment = null,
		$keep_forward_messages = false, 
		$keep_snippets = false,
		$group_id = null, 
		$dont_parse_links = false,
		$lat = null,
		$long = null
	) {				
	
		$response = $this->call("messages.edit", [
			'peer_id' => $peer_id,
			'message' => $message,
			'message_id' => $message_id,
			'lat' => $lat,
			'long' => $long,
			'attachment' => $attachment,
			'keep_forward_messages' => $keep_forward_messages,
			'keep_snippets' => $keep_snippets,
			'group_id' => $group_id,
			'dont_parse_links' => $dont_parse_links
		]);	
	
		return $response;
	}
	
	
	/*
	**  функция закрепления сообщения
	**
	**  @param int $peer_id
 	**  @param int $message_id
	**  
	**  
	**  @return bool 
	*/
    public function messagesPin(
		$peer_id, 
		$message_id
	) {				
	
		$response = $this->call("messages.pin", [
			'peer_id' => $peer_id,
			'message_id' => $message_id
		]);	
	
		return $response;
	}
	
	
	/*
	**  функция открепления сообщения
	**
	**  @param int $peer_id
 	**  @param int $group_id
	**  
	**  
	**  @return bool 
	*/
    public function messagesUnpin(
		$peer_id, 
		$group_id
	) {				
	
		$response = $this->call("messages.unpin", [
			'peer_id' => $peer_id,
			'group_id' => $group_id
		]);	
	
		return $response;
	}
	
	
	/*
	**  функция удаления сообщения
	**
	**  @param int,int,int... $message_ids
	**  @param int $group_id
	**  @param bool $delete_for_all
 	**  @param bool $spam  
	**  
	**  @return bool 
	*/
    public function messagesDelete(
		$message_ids, 
		$group_id,
		$delete_for_all = false, 
		$spam = false
	) {				
	
		$response = $this->call("messages.delete", [
			'message_ids' => $message_ids,
			'spam' => $spam,
			'group_id' => $group_id,
			'delete_for_all' => $delete_for_all
		]);	
	
		return $response;
	}
	
	
	/*
	**  Создаёт беседу с несколькими участниками 
	**
	**  @param int,int,int... $user_ids
 	**  @param str $title
	**  @param int $group_id
	**  
	**  @return bool 
	*/
    public function messagesCreateChat(
		$user_ids,
		$title, 
		$group_id
	) {				
	
		$response = $this->call("messages.createChat", [
			'user_ids' => $user_ids,
			'title' => $title,
			'group_id' => $group_id
		]);	
	
		return $response;
	}
	
	
/*-------------------------------*/
/*			  photos			 */
/*-------------------------------*/	
	
	/*
	**  функция получения URL сервера для загрузки фото (только в Standalone-приложении)
	**
	**  @param int $album_id
 	**  @param int $group_id
	**  
	**  @return array 
	*/

    public function photosGetUploadServer(
		$album_id, 
		$group_id
	) {				
	
		$response = $this->call("photos.getUploadServer", [
			'album_id' => $album_id,
			'group_id' => $group_id
		]);	
	
		return $response;
	}

	
	/*
	**  функция сохранения фото (только в Standalone-приложении)
	**
	**  @param int $album_id
 	**  @param int $group_id
	**  @param int $server
	**  @param JSON $photos_list
	**  @param str $hash
	**  @param real $latitude
	**  @param real $longitude
	**  @param str $caption
	**  
	**  @return array 
	*/
    public function photosSave(
		$album_id, 
		$group_id,		
		$server,
		$photos_list,
		$hash,
		$caption = null,
		$latitude = 0,
		$longitude = 0
	) {				
	
		$response = $this->call("photos.save", [
			'album_id' => $album_id,
			'group_id' => $group_id, 
			'server' => $server,
			'photos_list' => $photos_list,
			'hash' => $hash,
			'latitude' => $latitude,
			'longitude' => $longitude,
			'caption' => $caption
		]);	
	
		return $response;
	}
	
	
	/*
	**  Редактирует описание или геометку у фотографии (только в Standalone-приложении)
	**
	**  @param int $owner_id
 	**  @param int $photo_id
	**  @param str $caption
	**  @param real $latitude
	**  @param real $longitude
	**  @param str $place_str
	**  @param str $foursquare_id
	**  @param bool $delete_place
	**  
	**  @return bool 
	*/
    public function photosEdit(
		$owner_id, 
		$photo_id,
		$caption = null,
		$latitude = 0,
		$longitude = 0,
		$place_str = null,
		$foursquare_id = null,
		$delete_place = false
	) {				
	
		$response = $this->call("photos.edit", [
			'owner_id' => $owner_id,
			'photo_id' => $photo_id, 
			'caption' => $caption,
			'latitude' => $latitude,
			'longitude' => $longitude,
			'place_str' => $place_str,
			'foursquare_id' => $foursquare_id,
			'delete_place' => $delete_place
		]);	
	
		return $response;
	}
	
	
	/*
	**  Удаление фотографии на сайте (только в Standalone-приложении)
	**
	**  @param int $owner_id
 	**  @param int $photo_id
	**  
	**  @return bool 
	*/
    public function photosDelete(
		$owner_id, 
		$photo_id
	) {				
	
		$response = $this->call("photos.delete", [
			'owner_id' => $owner_id,
			'photo_id' => $photo_id
		]);	
	
		return $response;
	}
	
	
	/*
	**  Создает пустой альбом для фотографий (только в Standalone-приложении)
	**
	**  @param str $title
 	**  @param int $group_id
	**  @param str $description
 	**  @param arr(str,str) $privacy_view
 	**  @param arr(str,str) $privacy_comment
 	**  @param bool $upload_by_admins_only
 	**  @param bool $comments_disabled
	**  
	**  @return array 
	*/
    public function photosCreateAlbum(
		$title, 
		$group_id = null,
		$description = null, 
		$privacy_view = null,
		$privacy_comment = null, 
		$upload_by_admins_only = false,
		$comments_disabled = false
	) {				
	
		$response = $this->call("photos.createAlbum", [
			'title' => $title,
			'group_id' => $group_id,
			'description' => $description,
			'privacy_view' => $privacy_view,
			'privacy_comment' => $privacy_comment,
			'upload_by_admins_only' => $upload_by_admins_only,
			'comments_disabled' => $comments_disabled
		]);	
	
		return $response;
	}

	
	/*
	**  Редактирует данные альбома для фотографий (только в Standalone-приложении)
	**
 	**  @param int $album_id
 	**  @param int $owner_id
	**  @param str $title
	**  @param str $description
 	**  @param arr(str,str) $privacy_view
 	**  @param arr(str,str) $privacy_comment
 	**  @param bool $upload_by_admins_only
 	**  @param bool $comments_disabled
	**  
	**  @return bool 
	*/
    public function photosEditAlbum( 
		$album_id,  
		$owner_id,
		$title = null,
		$description = null,
		$privacy_view = null,
		$privacy_comment = null, 
		$upload_by_admins_only = false,
		$comments_disabled = false
	) {				
	
		$response = $this->call("photos.editAlbum", [
			'album_id' => $album_id,
			'title' => $title,
			'description' => $description,
			'owner_id' => $owner_id,
			'privacy_view' => $privacy_view,
			'privacy_comment' => $privacy_comment,
			'upload_by_admins_only' => $upload_by_admins_only,
			'comments_disabled' => $comments_disabled
		]);	
	
		return $response;
	}
		
	
	/*
	**  Удаляет указанный альбом для фотографий у текущего пользователя 
	**  (только в Standalone-приложении)
	**
	**  @param int $album_id
 	**  @param int $group_id
	**  
	**  @return bool 
	*/
    public function photosDeleteAlbum(
		$album_id, 
		$group_id = null
	) {				
	
		$response = $this->call("photos.deleteAlbum", [
			'album_id' => $album_id,
			'group_id' => $group_id
		]);	
	
		return $response;
	}
	
	
	/*
	**  Возвращает список фотографий в альбоме (только в Standalone-приложении)
	**
 	**  @param int $owner_id
 	**  @param str $album_id
	**  @param str,str $photo_ids
	**  @param bool $rev
 	**  @param bool $extended
 	**  @param str $feed_type
 	**  @param int $feed
 	**  @param bool $photo_sizes
	**  @param int $offset
 	**  @param int $count // max 1000
	**  
	**  @return bool 
	*/
    public function photosGet(  
		$owner_id,
		$album_id, 
		$photo_ids = null,
		$rev = false,
		$extended = false,
		$feed_type = null, 
		$feed = null,
		$photo_sizes = false, 
		$offset = null,
		$count = 50
	) {				
	
		$response = $this->call("photos.get", [
			'owner_id' => $owner_id,
			'album_id' => $album_id,
			'photo_ids' => $photo_ids,
			'rev' => $rev,
			'extended' => $extended,
			'feed_type' => $feed_type,
			'feed' => $feed,
			'photo_sizes' => $photo_sizes,
			'offset' => $offset,
			'count' => $count
		]);	
	
		return $response;
	}
	
	
	/*
	**  Возвращает все фотографии пользователя или сообщества в антихронологическом порядке 
	**  (только в Standalone-приложении)
	**
 	**  @param int $owner_id
 	**  @param bool $extended
	**  @param int $offset
 	**  @param int $count // max 200
 	**  @param bool $photo_sizes
 	**  @param bool $no_service_albums
	**  @param bool $need_hidden
	**  @param bool $skip_hidden
	**  
	**  @return bool 
	*/
    public function photosGetAll(  
		$owner_id,
		$extended = false,
		$offset = null,
		$count = 20,
		$photo_sizes = false, 
		$no_service_albums = false, 
		$need_hidden = false,
		$skip_hidden = false
	) {				
	
		$response = $this->call("photos.getAll", [
			'owner_id' => $owner_id,
			'extended' => $extended,
			'offset' => $offset,
			'count' => $count,
			'photo_sizes' => $photo_sizes,
			'no_service_albums' => $no_service_albums,
			'need_hidden' => $need_hidden,
			'skip_hidden' => $skip_hidden
		]);	
	
		return $response;
	}
	
	
	/*
	**  Возвращает список фотоальбомов пользователя или сообщества 
	**  (только в Standalone-приложении)
	**
 	**  @param int $owner_id
 	**  @param int,int $album_ids
	**  @param int $offset
 	**  @param int $count
	**  @param bool $need_system
	**  @param bool $need_covers
 	**  @param bool $photo_sizes
	**  
	**  @return array 
	*/
    public function photosGetAlbums(  
		$owner_id,
		$album_ids = null,
		$offset = null,
		$count = null, 
		$need_system = false,
		$need_covers = false,
		$photo_sizes = false
	) {				
	
		$response = $this->call("photos.getAlbums", [
			'owner_id' => $owner_id,
			'album_ids' => $album_ids,
			'offset' => $offset,
			'count' => $count,
			'need_system' => $need_system,
			'need_covers' => $need_covers,
			'photo_sizes' => $photo_sizes
		]);	
	
		return $response;
	}
	
	
	/*
	**  Возвращает количество доступных альбомов пользователя или сообщества
	**  (только в Standalone-приложении)
	**
 	**  @param int $user_id
 	**  @param int $group_id
	**  
	**  @return bool 
	*/
    public function photosGetAlbumsCount(  
		$user_id,
		$group_id
	) {				
	
		$response = $this->call("photos.getAlbumsCount", [
			'user_id' => $user_id,
			'group_id' => $group_id
		]);	
	
		return $response;
	}
	
	
	/*
	**  Возвращает отсортированный в антихронологическом порядке список всех
	**  комментариев к конкретному альбому или ко всем альбомам пользователя
	**  (только в Standalone-приложении)
	**
 	**  @param int $owner_id
 	**  @param int $album_id
	**  @param bool $need_likes
	**  @param int $offset
 	**  @param int $count
	**  
	**  @return array 
	*/
    public function photosGetAllComments(  
		$owner_id,
		$album_id = null,		
		$need_likes = false,
		$offset = null,
		$count = null
	) {				
	
		$response = $this->call("photos.getAllComments", [
			'owner_id' => $owner_id,
			'album_id' => $album_id,
			'need_likes' => $need_likes,
			'offset' => $offset,
			'count' => $count
		]);	
	
		return $response;
	}
	
	
	/*
	**  Возвращает информацию о фотографиях по их идентификаторам 
	**  (только в Standalone-приложении)
	**
 	**  @param str,str $photos
 	**  @param bool $extended
 	**  @param bool $photo_sizes
	**  
	**  @return array 
	*/
    public function photosGetById(  
		$photos,
		$extended = false,
		$photo_sizes = false
	) {				
	
		$response = $this->call("photos.getById", [
			'photos' => $photos,
			'extended' => $extended,
			'photo_sizes' => $photo_sizes
		]);	
	
		return $response;
	}
	
	
	/*
	**  Возвращает список комментариев к фотографии (только в Standalone-приложении)
	**
	**  @param int $owner_id
	**  @param int $photo_id
	**  @param bool $need_likes
	**  @param int $start_comment_id
 	**  @param int $offset
	**  @param int $count
	**  @param str $sort
	**  @param str $access_key
	**  @param bool $extended
	**  @param str,str $fields
	**  
	**  @return array 
	*/
    public function photosGetComments(
		$owner_id,
		$photo_id,
		$need_likes = false,
		$start_comment_id = null,
		$offset = null,
		$count = null,
		$sort = null,
		$access_key = null,
		$extended = false,
		$fields = null
	) {				
	
		$response = $this->call("photos.getComments", [
			'owner_id' => $owner_id,
			'photo_id' => $photo_id,
			'need_likes' => $need_likes,
			'start_comment_id' => $start_comment_id,
			'offset' => $offset,
			'count' => $count,
			'sort' => $sort,
			'access_key' => $access_key,
			'extended' => $extended,
			'fields' => $fields
		]);	
	
		return $response;
	}
	
	
	/*
	**  Создает новый комментарий к фотографии (только в Standalone-приложении)
	**
	**  @param int $owner_id
	**  @param int $photo_id
	**  @param str $message
	**  @param str,str $attachments
 	**  @param int $from_group
	**  @param int $reply_to_comment
	**  @param int $sticker_id
	**  @param str $access_key
	**  @param str $guid
	**  
	**  @return array 
	*/
    public function photosCreateComment(
		$owner_id,
		$photo_id,
		$message = null,
		$attachments = null,
		$from_group = false,
		$reply_to_comment = null,
		$sticker_id = null,
		$access_key = null,
		$guid = null
	) {				
	
		$response = $this->call("photos.createComment", [
			'owner_id' => $owner_id,
			'photo_id' => $photo_id,
			'from_group' => $from_group,
			'message' => $message,
			'reply_to_comment' => $reply_to_comment,
			'attachments' => $attachments,
			'sticker_id' => $sticker_id,
			'access_key' => $access_key,
			'guid' => $guid
		]);	
	
		return $response;
	}
	
	
	/*
	**  Изменяет текст комментария к фотографии (только в Standalone-приложении)
	**
	**  @param int $owner_id
	**  @param int $comment_id
	**  @param str $message
	**  @param str,str $attachments
	**  
	**  @return bool 
	*/
    public function photosEditComment(
		$owner_id,
		$comment_id,
		$message = null,
		$attachments = null
	) {				
	
		$response = $this->call("photos.editComment", [
			'owner_id' => $owner_id,
			'comment_id' => $comment_id,
			'message' => $message,
			'attachments' => $attachments
		]);	
	
		return $response;
	}
	
	
	/*
	**  Изменяет текст комментария к фотографии (только в Standalone-приложении)
	**
	**  @param int $owner_id
	**  @param int $comment_id
	**  
	**  @return bool 
	*/
    public function photosDeleteComment(
		$owner_id,
		$comment_id
	) {				
	
		$response = $this->call("photos.deleteComment", [
			'owner_id' => $owner_id,
			'comment_id' => $comment_id
		]);	
	
		return $response;
	}
	
	
	/*
	**  Позволяет получить адрес для загрузки обложки чата 
	**  (только в Standalone-приложении)
	**
	**  @param int $chat_id
	**  @param int $crop_x
	**  @param int $crop_y
	**  @param int $crop_width
	**  
	**  @return array (upload_url) 
	*/
    public function photosGetChatUploadServer(
		$chat_id,
		$crop_x,
		$crop_y,
		$crop_width
	) {				
	
		$response = $this->call("photos.getChatUploadServer", [
			'chat_id' => $chat_id,
			'crop_x' => $crop_x,
			'crop_y' => $crop_y,
			'crop_width' => $crop_width
		]);	
	
		return $response;
	}
	
	
	/*
	**  Возвращает адрес сервера для загрузки фотографии в личное сообщение
	**
	**  @param int $peer_id
	**  
	**  @return array (upload_url, album_id, group_id) 
	*/
    public function photosGetMessagesUploadServer(
		$peer_id
	) {				
	
		$response = $this->call("photos.getMessagesUploadServer", [
			'peer_id' => $peer_id
		]);	
	
		return $response;
	}
	
	
	/*
	**  Сохраняет фотографию после успешной загрузки на URI,
	** 	полученный методом photos.getMessagesUploadServer
	**
	**  @param int $photo
	**  @param int $server
	**  @param int $hash
	**  
	**  @return array
	*/
    public function photosSaveMessagesPhoto(
		$photo,
		$server,
		$hash
	) {				
	
		$response = $this->call("photos.saveMessagesPhoto", [
			'photo' => $photo,
			'server' => $server,
			'hash' => $hash
		]);	
	
		return $response;
	}
	
	

/*-------------------------------*/
/*			   wall				 */
/*-------------------------------*/		
	
	/*
	**  Проверяет ссылку для указания источника
	**
	**  @param str $link
	**  
	**  @return bool 
	*/
    public function wallCheckCopyrightLink($link) {				
	
		$response = $this->call("wall.checkCopyrightLink", [			
			'link' => $link
		]);	
	
		return $response;
		
	}
	
	
	/*
	**  функция сооздания записи на стене
	**
	**  @param int $owner_id
	**  @param str $message
	**  @param str $attachments   список слов, разделенных через запятую
	**  @param bool $from_group
 	**  @param bool $friends_only
	**  @param str $services
	**  @param bool $signed
	**  @param int $publish_date
	**  @param real $lat
	**  @param real $long
	**  @param int $place_id
	**  @param int $post_id
	**  @param str $guid
	**  @param bool $mark_as_ads
	**  @param bool $close_comments
	**  @param bool $mute_notifications
	**  @param str $copyright
	**  
	**  
	**  @return array 
	*/
    public function wallPost(
		$owner_id,
		$message = null,
		$attachments = null,
		$from_group = true,
		$friends_only = false,
		$services = null,
		$signed = false,
		$publish_date = null,
		$lat = null,
		$long = null,
		$place_id = null,
		$post_id = null,
		$guid = null,
		$mark_as_ads = false,
		$close_comments = false,
		$mute_notifications = false,
		$copyright = null
	) {				
	
		$response = $this->call("wall.post", [
			'owner_id' => $owner_id,
			'friends_only' => $friends_only,
			'from_group' => $from_group,
			'message' => $message,
			'attachments' => $attachments,
			'services' => $services,
			'signed' => $signed,
			'publish_date' => $publish_date,
			'lat' => $lat,
			'long' => $long,
			'place_id' => $place_id,
			'post_id' => $post_id,
			'guid' => $guid,
			'mark_as_ads' => $mark_as_ads,
			'close_comments' => $close_comments,
			'mute_notifications' => $mute_notifications,
			'copyright' => $copyright
		]);	
	
		return $response;
		
	}
	
	
	/*
	**  Удаляет запись со стены
	**
	**  @param int $owner_id
	**  @param str $post_id
	**  
	**  @return bool 
	*/
    public function wallDelete(
		$owner_id,
		$post_id
	) {				
	
		$response = $this->call("wall.delete", [
			'owner_id' => $owner_id,
			'post_id' => $post_id
		]);	
	
		return $response;
		
	}
	
	
	/*
	**  Редактирует запись на стене
	**
	**  @param int $owner_id
	**  @param int $post_id
	**  @param str $message
	**  @param str $attachments   список слов, разделенных через запятую
 	**  @param bool $friends_only
	**  @param str $services
	**  @param bool $signed
	**  @param int $publish_date
	**  @param real $lat
	**  @param real $long
	**  @param int $place_id
	**  @param bool $mark_as_ads
	**  @param bool $close_comments
	**  @param int $poster_bkg_id
	**  @param int $poster_bkg_owner_id
	**  @param str $poster_bkg_access_hash
	**  @param str $copyright
	**  
	**  
	**  @return array 
	*/

    public function wallEdit(
		$owner_id,
		$post_id,
		$message = null,
		$attachments = null,
		$friends_only = false,
		$services = null,
		$signed = false,
		$publish_date = null,
		$lat = null,
		$long = null,
		$place_id = null,
		$mark_as_ads = false,
		$close_comments = false,
		$poster_bkg_id = null,
		$poster_bkg_owner_id = null,
		$poster_bkg_access_hash = null,
		$copyright = null
	) {				
	
		$response = $this->call("wall.edit", [
			'owner_id' => $owner_id,
			'post_id' => $post_id,
			'friends_only' => $friends_only,
			'message' => $message,
			'attachments' => $attachments,
			'services' => $services,
			'signed' => $signed,
			'publish_date' => $publish_date,
			'lat' => $lat,
			'long' => $long,
			'place_id' => $place_id,
			'mark_as_ads' => $mark_as_ads,
			'close_comments' => $close_comments,
			'poster_bkg_id' => $poster_bkg_id,
			'poster_bkg_owner_id' => $poster_bkg_owner_id,
			'poster_bkg_access_hash' => $poster_bkg_access_hash,
			'copyright' => $copyright
		]);	
	
		return $response;
	}
	
	
	/*
	**  Выключает комментирование записи
	**
	**  @param int $owner_id
	**  @param int $post_id
	**  
	**  @return bool 
	*/
    public function wallCloseComments(
		$owner_id,
		$post_id
	) {				
	
		$response = $this->call("wall.closeComments", [
			'owner_id' => $owner_id,
			'post_id' => $post_id
		]);	
	
		return $response;
	}
	
	
	/*
	**  Включает комментирование записи
	**
	**  @param int $owner_id
	**  @param int $post_id
	**  
	**  @return bool 
	*/
    public function wallOpenComments(
		$owner_id,
		$post_id
	) {				
	
		$response = $this->call("wall.openComments", [
			'owner_id' => $owner_id,
			'post_id' => $post_id
		]);	
	
		return $response;
	}
	
	
	/*
	**  Добавляет комментарий к записи на стене
	**
	**  @param int $owner_id
	**  @param int $post_id
	**  @param str $message
	**  @param str,str $attachments
 	**  @param int $from_group
	**  @param int $reply_to_comment
	**  @param int $sticker_id
	**  @param str $guid
	**  
	**  @return array 
	*/
    public function wallCreateComment(
		$owner_id,
		$post_id,
		$message = null,
		$attachments = null,
		$from_group = null,
		$reply_to_comment = null,
		$sticker_id = null,
		$guid = null
	) {				
	
		$response = $this->call("wall.createComment", [
			'owner_id' => $owner_id,
			'post_id' => $post_id,
			'from_group' => $from_group,
			'message' => $message,
			'reply_to_comment' => $reply_to_comment,
			'attachments' => $attachments,
			'sticker_id' => $sticker_id,
			'guid' => $guid
		]);	
	
		return $response;
	}
	
	
	/*
	**  Редактирует комментарий на стене (только в Standalone-приложении)
	**
	**  @param int $owner_id
	**  @param int $comment_id
	**  @param str $message
	**  @param str $attachments
	**  
	**  @return array 
	*/

    public function wallEditComment(
		$owner_id,
		$comment_id,
		$message = null,
		$attachments = null
	) {				
	
		$response = $this->call("wall.editComment", [
			'owner_id' => $owner_id,
			'comment_id' => $comment_id,
			'message' => $message,
			'attachments' => $attachments
		]);	
	
		return $response;
	}
	
	
	/*
	**  Удаляет комментарий к записи на стене (только в Standalone-приложении)
	**
	**  @param int $owner_id
	**  @param int $comment_id
	**  
	**  @return array 
	*/

    public function wallDeleteComment(
		$owner_id,
		$comment_id
	) {				
	
		$response = $this->call("wall.deleteComment", [
			'owner_id' => $owner_id,
			'comment_id' => $comment_id
		]);	
	
		return $response;
	}
	
	
	/*
	**  Возвращает список записей со стены пользователя или сообщества 
	**  (только в Standalone-приложении)
	**
	**  @param int $owner_id
	**  @param str $domain
	**  @param int $offset
	**  @param int $count
 	**  @param str $filter
	**  @param bool $extended
	**  @param str,str $fields
	**  
	**  @return array 
	*/
    public function wallGet(
		$owner_id,
		$domain = null,
		$offset = null,
		$count = null,
		$filter = null,
		$extended = false,
		$fields = null
	) {				
	
		$response = $this->call("wall.get", [
			'owner_id' => $owner_id,
			'domain' => $domain,
			'offset' => $offset,
			'count' => $count,
			'filter' => $filter,
			'extended' => $extended,
			'fields' => $fields
		]);	
	
		return $response;
	}
	
	
	/*
	**  Возвращает список записей со стен пользователей или сообществ по их идентификаторам 
	**  (только в Standalone-приложении)
	**
	**  @param str,str $posts
	**  @param bool $extended
	**  @param int $copy_history_depth
	**  @param str,str $fields
	**  
	**  @return array 
	*/
    public function wallGetById(
		$posts,
		$extended = false,
		$copy_history_depth = 2,
		$fields = null
	) {				
	
		$response = $this->call("wall.getById", [
			'posts' => $posts,
			'extended' => $extended,
			'copy_history_depth' => $copy_history_depth,
			'fields' => $fields
		]);	
	
		return $response;
	}
	
	
	/*
	**  Позволяет искать записи на стене в соответствии с заданными критериями (только в Standalone-приложении)
	**
	**  @param int $owner_id
	**  @param str $domain
	**  @param str $query
	**  @param bool $owners_only
 	**  @param int $count // не более 100
	**  @param int $offset
	**  @param bool $extended
	**  @param str,str $fields
	**  
	**  @return array 
	*/
    public function wallSearch(
		$owner_id,
		$domain = null,
		$query = null,
		$owners_only = null,
		$count = 20,
		$offset = null,
		$extended = false,
		$fields = null
	) {				
	
		$response = $this->call("wall.search", [
			'owner_id' => $owner_id,
			'domain' => $domain,
			'query' => $query,
			'owners_only' => $owners_only,
			'count' => $count,
			'offset' => $offset,
			'extended' => $extended,
			'fields' => $fields
		]);	
	
		return $response;
	}
	
	
	/*
	**  Получает информацию о комментарии на стене (только в Standalone-приложении)
	**
	**  @param int $owner_id
	**  @param int $comment_id
	**  @param bool $extended
	**  @param str,str $fields
	**  
	**  @return array 
	*/
    public function wallGetComment(
		$owner_id,
		$comment_id = null,
		$extended = false,
		$fields = null
	) {				
	
		$response = $this->call("wall.getComment", [
			'owner_id' => $owner_id,
			'comment_id' => $comment_id,
			'extended' => $extended,
			'fields' => $fields
		]);	
	
		return $response;
	}
	
	
	/*
	**  Возвращает список комментариев к записи на стене (только в Standalone-приложении)
	**
	**  @param int $owner_id
	**  @param int $post_id
	**  @param bool $need_likes
	**  @param int $start_comment_id
 	**  @param int $offset 
	**  @param int $count // не более 100
	**  @param str $sort
	**  @param int $preview_length
	**  @param bool $extended
	**  @param str,str $fields
	**  @param int $comment_id
	**  @param int $thread_items_count // не более 10
	**  
	**  @return array 
	*/
    public function wallGetComments(
		$owner_id,
		$post_id,
		$need_likes = false,
		$start_comment_id = null,
		$offset = null,
		$count = 10,
		$sort = null,
		$preview_length = null,
		$extended = false,
		$fields = null,
		$comment_id = null,
		$thread_items_count = 0
	) {				
	
		$response = $this->call("wall.getComments", [
			'owner_id' => $owner_id,
			'post_id' => $post_id,
			'need_likes' => $need_likes,
			'start_comment_id' => $start_comment_id,
			'offset' => $offset,
			'count' => $count,
			'sort' => $sort,
			'preview_length' => $preview_length,
			'extended' => $extended,
			'fields' => $fields,
			'comment_id' => $comment_id,
			'thread_items_count' => $thread_items_count
		]);	
	
		return $response;
	}
	
	
	/*
	**  Позволяет получать список репостов заданной записи (только в Standalone-приложении)
	**
	**  @param int $owner_id
	**  @param int $post_id
 	**  @param int $offset 
	**  @param int $count // не более 1000
	**  
	**  @return array 
	*/
    public function wallGetReposts(
		$owner_id,
		$post_id,
		$offset = null,
		$count = 20
	) {				
	
		$response = $this->call("wall.getReposts", [
			'owner_id' => $owner_id,
			'post_id' => $post_id,
			'offset' => $offset,
			'count' => $count
		]);	
	
		return $response;
	}
	
	
	/*
	**  Закрепляет запись на стене (только в Standalone-приложении)
	**
	**  @param int $owner_id
	**  @param int $post_id
	**  
	**  @return bool 
	*/
    public function wallPin(
		$owner_id,
		$post_id
	) {				
	
		$response = $this->call("wall.pin", [
			'owner_id' => $owner_id,
			'post_id' => $post_id
		]);	
	
		return $response;
	}
	
	
	/*
	**  Отменяет закрепление записи на стене (только в Standalone-приложении)
	**
	**  @param int $owner_id
	**  @param int $post_id
	**  
	**  @return bool 
	*/
    public function wallUnpin(
		$owner_id,
		$post_id
	) {				
	
		$response = $this->call("wall.unpin", [
			'owner_id' => $owner_id,
			'post_id' => $post_id
		]);	
	
		return $response;
	}
	
	
	/*
	**  Копирует объект на стену пользователя или сообщества (только в Standalone-приложении)
	**
	**  @param str $object
	**  @param str $message
	**  @param int $group_id
	**  @param bool $mark_as_ads
	**  @param bool $mute_notifications
	**  
	**  @return array 
	*/
    public function wallRepost(
		$object,
		$message = null,
		$group_id = null,
		$mark_as_ads = false,
		$mute_notifications = false
	) {				
	
		$response = $this->call("wall.repost", [
			'object' => $object,
			'message' => $message,
			'group_id' => $group_id,
			'mark_as_ads' => $mark_as_ads,
			'mute_notifications' => $mute_notifications
		]);	
	
		return $response;
	}
	
}
?>
