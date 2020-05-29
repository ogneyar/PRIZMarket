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
        curl_setopt ($ch, CURLOPT_URL, $this->apiUrl . $method);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
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
		
		//$curl_file = curl_file_create($file, 'mimetype' , 'image.png');
		
		$data = ['file1' => $curl_file];
		
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        curl_close($ch);
		
        $response = json_decode($result, true);
		
        return $response['response'];
    }

	
//--------------------------------------
//------------  МЕТОДЫ  ----------------
//--------------------------------------
    
	
    /*
	**  функция отправки сообщения 
	**
	**  @param str $peer_id
 	**  @param str $message
	**  @param str $version

пока нет
	**  @param array $attachment
	
	**  
	**  @return array 
	*/

    public function messagesSend(
		$peer_id, 
		$message
	) {				
		
		$random_id = time();
		
		$response = $this->call("messages.send", [	
			'random_id' => $random_id,
			'peer_id' => $peer_id,
			'message' => $message
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
	
	
	
} 


?>
