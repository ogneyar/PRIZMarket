<?php

/**-------------+
 *   Class VK  |
 * -------------+
 *
 * init
 *
 * call
 *
 * PrintArray
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
    // $token - созданный токен для нашего бота 
    public $token = null;
	// $version - версия vk api
    public $version = null;
    // адрес для запросов к API
    public $apiUrl = "https://api.vk.com/method/";
	
	/*
	** @param str $token
	*/
    public function __construct($token, $version = '5.67')
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
        // создаем массив из пришедших данных от API
        return json_decode(file_get_contents($data_php), TRUE); 
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
        curl_setopt ($ch, CURLOPT_POST, count($data));
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);	           
		curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        curl_close($ch);
		
        $response = json_decode($result, true);
		
        return $response['response'];
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
	public function PrintArray($mass, $i = 0) {		
		global $flag;			
		
		$flag .= "\t\t\t\t";			
		
		foreach($mass as $key[$i] => $value[$i]) {				
			if (is_array($value[$i])) {			
					$response .= $flag . $key[$i] . " : \n";					
					$response .= $this->PrintArray($value[$i], ++$i);					
			}else $response .= $flag . $key[$i] . " : " . $value[$i] . "\n";			
		}		
		
		$str = $flag;		
		$flag = substr($str, 0, -4);		
		
		return $response;		
	}
	
	
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
    public function messagesSend(
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
