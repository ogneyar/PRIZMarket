<?php

/*------------------+
 *   Class VK  |
 * ------------------+
 *
 * init
 *
 * call
 *
 * upload
 *
 * uploadAndGetUrl
 *
 * ---------------
 * Список методов:
 * ---------------
 *
 * messagesSend
 *
 * photosGetUploadServer
 *
 * photosSave
 * 
 * wallPost
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
		
		return $response;
	}

	
	
	
//--------------------------------------
//------------  МЕТОДЫ  ----------------
//--------------------------------------
    
	
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
	**  @return array 
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
	**  функция получения URL сервера для загрузки фото
	**
	**  @param int $album_id
 	**  @param int $group_id
	**  @param str $version
	**  
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
	**  функция сохранения фото
	**
	**  @param int $album_id
 	**  @param int $group_id
	**  @param int $server
	**  @param JSON $photos_list
	**  @param str $hash
	**  @param int $latitude
	**  @param int $longitude
	**  @param str $caption
	**  @param str $version
	**  
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
		$message,
		$attachments,
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
	
	
	
} 


?>
