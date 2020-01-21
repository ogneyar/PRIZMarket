<?php

/**----------+
 * Class Bot |
 * ----------+
 *
 * ---------------
 * Список методов:
 * ---------------
 *
 * sendMessage
 *
 * forwardMessage
 *
 * editMessageText
 *
 * sendPhoto
 *
 * sendVideo
 *
 * answerCallbackQuery
 *
 * getChat
 *
 *
 *
 * -----------------------------
 * функции работы с базой данных
 * -----------------------------
 *
 * add_to_database
 *
 * this_admin
 *
 * output_table
 *
 * output
 *
 *
 */

class Bot
{
    // $token - созданный токен для нашего бота от @BotFather
    private $token = null;
    // адрес для запросов к API Telegram
    private $apiUrl = "https://api.telegram.org/bot";
    
	/*
	** @param str $token
	*/
    public function __construct($token)
    {
        $this->token = $token;
    }    
    
	/*
	** @param JSON $data_php
	** @return array
	*/
    public function init($data_php)
    {
        // создаем массив из пришедших данных от API Telegram
        $data = $this->getData($data_php); 
        
        return $data;        
    }
	
	/*
    ** @param JSON $data
    ** @return array
    */
    private function getData($data)
    {
        return json_decode(file_get_contents($data), TRUE);
    }
    
    
    /* 
	** Отправляем запрос в Телеграмм
	**
    ** @param str $method
    ** @param array $data    
	**
    ** @return mixed
    */
    public function call($method, $data)
    {
        $result = null;
        if (is_array($data)) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl . $this->token . '/' . $method);
            curl_setopt($ch, CURLOPT_POST, count($data));
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            $result = curl_exec($ch);
            curl_close($ch);
        }
        return $result;
    }
    
    
    /*
	**  функция отправки сообщения 
	**
	**  @param int $chat_id
 	**  @param str $text
	**  @param str $parse_mode
	**  @param array $reply_markup
	**  @param int $reply_to_message_id	
	**  @param bool $disable_web_page_preview
	**  @param bool $disable_notification
	**  
	**  @return array
	*/
    public function sendMessage(
		$chat_id, 
		$text,
		$parse_mode = null,
		$reply_markup = null,
		$reply_to_message_id = null,
		$disable_web_page_preview = false,
		$disable_notification = false
	) {
		
		if ($reply_markup) $reply_markup = json_encode($reply_markup);
		
		$response = $this->call("sendMessage", [
			'chat_id' => $chat_id,
			'text' => $text,
			'parse_mode' => $parse_mode,			
			'disable_web_page_preview' => $disable_web_page_preview,
			'disable_notification' => $disable_notification,
			'reply_to_message_id' => $reply_to_message_id,
			'reply_markup' => $reply_markup
		]);	
				
		$response = json_decode($response, true);
		
		if ($response['ok']) {
			$response = $response['result'];
		}else $response = false;
		
		return $response;
	}
	
	
	/*
	**  функция пересылки сообщения	
	**
	**  @param int $chat_id
 	**  @param int $from_chat_id
	**  @param int $message_id  
	**  @param bool $disable_notification
	**
	**  @return array
	*/
	public function forwardMessage(
		$chat_id,
		$from_chat_id,
		$message_id,
		$disable_notification = false
	) {
		$response = $this->call("forwardMessage", [
			'chat_id' => $chat_id,
			'from_chat_id' => $from_chat_id,
			'disable_notification' => $disable_notification,
			'message_id' => $message_id
		]);
		
		$response = json_decode($response, true);
		
		if ($response['ok']) {
			$response = $response['result'];
		}else $response = false;
	
		return $response;
	}
	
	
	/*
	**  функция редактирования сообщения	
	**
	**  @param int $chat_id
	**  @param int $message_id  
	**  @param str $text  
	**  @param int $inline_message_id  
	**  @param str $parse_mode
	**  @param bool $disable_web_page_preview
	**  @param array $reply_markup
	**
	**  @return array
	*/
	public function editMessageText(		
		$chat_id = null,		
		$message_id = null,
		$text,
		$inline_message_id = null,
		$parse_mode = null,
		$disable_web_page_preview = false,
		$reply_markup = null
	) {
	
		if ($reply_markup) $reply_markup = json_encode($reply_markup);
		
		$response = $this->call("editMessageText", [
			'chat_id' => $chat_id,						
			'message_id' => $message_id,
			'text' => $text,
			'inline_message_id' => $inline_message_id,
			'parse_mode' => $parse_mode,
			'disable_web_page_preview' => $disable_web_page_preview,
			'reply_markup' => $reply_markup			
		]);
		
		$response = json_decode($response, true);
		
		if ($response['ok']) {
			$response = $response['result'];
		}else $response = false;
	
		return $response;
	}
    
	
	
	/*
	**  функция отправки фото
	**
	**  @param int $chat_id
 	**  @param str $photo
	**  @param str $caption
	**  @param str $parse_mode
	**  @param array $reply_markup
	**  @param int $reply_to_message_id	
	**  @param bool $disable_notification
	**  
	**  @return array
	*/
    public function sendPhoto(
		$chat_id, 
		$photo,
		$caption = null,
		$parse_mode = null,
		$reply_markup = null,
		$reply_to_message_id = null,		
		$disable_notification = false
	) {
		
		if ($reply_markup) $reply_markup = json_encode($reply_markup);
		
		$response = $this->call("sendPhoto", [
			'chat_id' => $chat_id,
			'photo' => $photo,
			'caption' => $caption,
			'parse_mode' => $parse_mode,			
			'disable_notification' => $disable_notification,
			'reply_to_message_id' => $reply_to_message_id,
			'reply_markup' => $reply_markup
		]);	
				
		$response = json_decode($response, true);
		
		if ($response['ok']) {
			$response = $response['result'];
		}else $response = false;
		
		return $response;
	}
	
	
	
	
	/*
	**  функция отправки видео
	**
	**  @param int $chat_id
 	**  @param str $video
	**  @param str $caption
	**  @param str $parse_mode
	**  @param array $reply_markup
	**  @param int $reply_to_message_id	
	**  @param int $duration
	**  @param int $width
	**  @param int $height
	**  @param str $thumb
	**  @param bool $disable_notification
	**  @param bool $supports_streaming
	**  
	**  @return array
	*/
    public function sendVideo(
		$chat_id, 
		$video,		
		$caption = null,
		$parse_mode = null,
		$reply_markup = null,
		$reply_to_message_id = null,		
		$duration = null,
		$width = null,
		$height = null,
		$thumb = null,
		$disable_notification = false,
		$supports_streaming = false
	) {
		
		if ($reply_markup) $reply_markup = json_encode($reply_markup);
		
		$response = $this->call("sendVideo", [
			'chat_id' => $chat_id,
			'video' => $video,
			'duration' => $duration,
			'width' => $width,
			'height' => $height,
			'thumb' => $thumb,
			'caption' => $caption,
			'parse_mode' => $parse_mode,		
			'supports_streaming' => $supports_streaming,
			'disable_notification' => $disable_notification,
			'reply_to_message_id' => $reply_to_message_id,
			'reply_markup' => $reply_markup
		]);	
				
		$response = json_decode($response, true);
		
		if ($response['ok']) {
			$response = $response['result'];
		}else $response = false;
		
		return $response;
	}
	
	
	
	
	
	/*
	** Ответное сообщение на нажатие кнопки callback_query
	**
	** @param int $callback_query_id
	** @param str $text
	** @param bool $show_alert
	** @param str $url
	** @param date $cache_time
	** 
	** @return array
	*/
	public function answerCallbackQuery(
		$callback_query_id,
		$text = null,
		$show_alert = false,
		$url = null,
		$cache_time = null
	){
		$response = $this->call("answerCallbackQuery", [
			'callback_query_id' => $callback_query_id,
			'text' => $text,
			'show_alert' => $show_alert,
			'url' => $url,
			'cache_time' => $cache_time
		]);
		
		$response = json_decode($response, true);
		
		if ($response['ok']) {
			$response = $response['result'];
		}else $response = false;
		
		return $response;
	}
	
	/*
	** Вывод информации о чате (о юзере, группе, супергруппе или о канале)
	**
	** @param int $chat_id
	**
	** @return array
	*/
	public function getChat($chat_id){
		
		$response = $this->call("getChat", ['chat_id' => $chat_id]);
		
		$response = json_decode($response, true);
		
		if ($response['ok']) {
			$response = $response['result'];
		}else $response = false;
		
		return $response;
	}

    
    
	
	
	
		
//------------------------------------------
// функции работы с базой данных


		
	/*
	** Добавление пользователя в базу
	**
	** @param str $table
	**
	** @return boolean
	*/		
	public function add_to_database($table) { // функция проверки есть ли юзер в базе 

		global $from_id, $from_first_name, $from_last_name, $from_username, $mysqli, $admin_group;
		
		$est_li_v_base = false;
		
		$query = "SELECT * FROM ". $table . " WHERE id_client=".$from_id; 
		
		if ($result = $mysqli->query($query)) {			
		
			if($result->num_rows>0){
			
				$est_li_v_base = true;							

			}			
		}				
			
		if ($est_li_v_base == false) {				
		
			$query = "INSERT INTO ".$table." (`id_client`, `first_name`, `last_name`, `user_name`, `status`) VALUES ('".
				$from_id ."', '" . $from_first_name . "', '" . $from_last_name . "', '" . $from_username .
				"', 'client')";
			
			if ($result = $mysqli->query($query)) {		
			
				$this->sendMessage($admin_group, 'Добавлен новый клиент');
				
				$est_li_v_base=true;	
				
			}else $this->sendMessage($admin_group, 'Не смог добавить нового клиента');
		}				

		return $est_li_v_base;
	}

	
	
	
	
	/*
	** Узнаю кто пишет, админ или клиент
	**
	** @param str $table
	**
	** @return boolean
	*/
	public function this_admin($table) { 

		global $admin_group, $mysqli, $from_id, $callback_from_id;
		
		$this_admin = false;		
		
		$query = "SELECT id_client FROM ".$table." WHERE status='admin'";
		
		if ($result = $mysqli->query($query)) {		
		
			$kolS=$result->num_rows;
			
			if($kolS>0){
			
				$arrStrok = $result->fetch_all(MYSQLI_ASSOC);	
				
				for ($i=0; $i<$kolS; $i++) {		
									
					if ($from_id==$arrStrok[$i]['id_client']||$callback_from_id==$arrStrok[$i]['id_client']) $this_admin = true;
				}						
				
			}	
			
		}else $this->sendMessage($admin_group, 'Чего то не получается узнать администраторов бота');			
		
		return $this_admin;
		
	}
	
	
	
	/*
	** Вывод заданной таблицы на экран
	**
	** @param str $table
	**
	** @return boolean
	*/
	public function output_table($table) { 

		global $chat_id, $mysqli, $master;
	
		$query = "SELECT * FROM ".$table;
		
		if ($result = $mysqli->query($query)) {		
		
			$reply="Таблица {$table}:\n";
			
			if($result->num_rows>0){
			
				$arrayResult = $result->fetch_all();		
				
				foreach($arrayResult as $row){					
				
					foreach($row as $stroka) $reply.= "| ".$stroka." ";
					
					$reply.="|\n";							
				}					
		
				$this->output($reply, '4000');
					
			}else $this->sendMessage($chat_id, "пуста таблица ".
					" \xF0\x9F\xA4\xB7\xE2\x80\x8D\xE2\x99\x82\xEF\xB8\x8F");		
					
		}else throw new Exception("Не смог получить записи в таблице {$table}");

		return true;
	
	}
	
	
	
	
	/*
	** функция печати (разбивание сообщения на части)
	**
	** @param str $text
	** @param int $max_kol_s
	**
	** @return boolean
	*/
	public function output($text, $max_kol_s = '6500') { 

		global $chat_id, $master;
		
		$str=null;	
			
		$kol = strlen ($text) ;

		if ($kol>'0'){
		
			if ($kol<=$max_kol_s){
				
				$text = str_replace ("_", "\_", $text);
				
				$this->sendMessage($chat_id, $text, markdown, null, null, true);				

			}else{					
			
				$len_str=strlen($text);				
				
				$kolich=$len_str-$max_kol_s;
				
				$str = substr($text, 0, -$kolich);
				
				$kol=strlen($str);	
				
				$this->sendMessage($chat_id, $str, null, null, null, true);		
							
				$str = substr($text, $kol);		
	
				$this->output($str, $max_kol_s);
			}		
			
		}	

		return true;
		
	}
	
	
	
	
	
	
}

?>
