<?php

/**-------------+
 *   Class VK  |
 * -------------+
 *
 * init
 *
 * call
 *
 *
 * ---------------
 * Список методов:
 * ---------------
 *
 * 
 *
 * 
 *
 * 
 *
 */

class VK
{
    // $token - токен бота 
    public $token = null;

	// $version - версия vk api
    public $version = null;

    // адрес для запросов к API
    public $apiUrl = "https://api.vk.com/method/";
	

	/*
	** @param str $token
	*/
    public function __construct($token, $version = '5.68')
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
        return json_decode(file_get_contents($data)); 
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
			curl_setopt($ch, CURLOPT_HEADER, false);
        $result = curl_exec($ch);
        curl_close($ch);
		
        $response = json_decode($result);
		
        return $response;
    }
    

	/*
	**  функция вывода на печать массива
	**
	**  @param array $mass
	**  @param int $i
	**  @param str $flag
	**
	**  @return string
	*/


	
//--------------------------------------
//------------  МЕТОДЫ  ----------------
//--------------------------------------
    
	
    /*
	**  функция отправки сообщения 
	**
	**  @param str $peer_id
 	**  @param str $message

пока нет
	**  @param array $attachment
	**  
	**  @return array 
	*/
    public function mesSend(
		$peer_id, 
		$message
	) {				
	
		$response = $this->call("messages.send", [
			'peer_id' => $peer_id,
			'message' => $message
		]);	
	
		return $response;
	}
	


?>
