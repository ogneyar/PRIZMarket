<?php

/*
 * +-----------------+
 * |  Class Message  |
 * +-----------------+
*/

class Message
{
	// в этот класс передаётся объект $data->object->message;
  
    public $date = null;
    public $from_id = null;
	public $id = null;
    public $out = null;
	public $peer_id = null;
    public $text = null;
	public $conversation_message_id = null;
    public $fwd_messages = [];
	public $important = false;
    public $random_id = null;
	public $attachments = [];
	public $payload = [];
    public $is_hidden = false;


	/*
	** @param obj $message
	*/

    public function __construct($message) {
		$this->date = $message->date;
		$this->from_id = $message->from_id;
		$this->id = $message->id;
		$this->out = $message->out;
		$this->peer_id = $message->peer_id;
		$this->text = $message->text;
		$this->conversation_message_id = $message->conversation_message_id;
		
		$this->fwd_messages = json_decode($message->fwd_messages, true);
		
		$this->important = $message->important;
		$this->random_id = $message->random_id;
		
		$this->attachments = json_decode($message->attachments, true);
		$this->payload = json_decode($message->payload, true);
		
		$this->is_hidden = $message->is_hidden;
    }    
  
	
    /*
	**  функция возвращает date
	**
	**  @return integer 
	*/
    public function getDate() {
		return $this->date;
	}
	
	
	/*
	**  функция записывает date
	*/
    public function setDate($date) {
		$this->date = $date;
	}	
	
	
	/*
	**  функция возвращает from_id
	**
	**  @return integer 
	*/
    public function getFromId() {
		return $this->from_id;
	}
	
	
	/*
	**  функция записывает from_id
	*/
    public function setFromId($from_id) {
		$this->from_id = $from_id;
	}
	
	
	/*
	**  функция возвращает id
	**
	**  @return integer 
	*/
    public function getId() {
		return $this->id;
	}
	
	
	/*
	**  функция записывает id
	*/
    public function setId($id) {
		$this->id = $id;
	}
	
	
	/*
	**  функция возвращает out
	**
	**  @return integer 
	*/
    public function getOut() {
		return $this->out;
	}
	
	
	/*
	**  функция записывает out
	*/
    public function setOut($out) {
		$this->out = $out;
	}
	
	
	/*
	**  функция возвращает peer_id
	**
	**  @return integer 
	*/
    public function getPeerId() {
		return $this->peer_id;
	}
	
	
	/*
	**  функция записывает peer_id
	*/
    public function setPeerId($peer_id) {
		$this->peer_id = $peer_id;
	}
	
	
	/*
	**  функция возвращает text
	**
	**  @return string 
	*/
    public function getText() {
		return $this->text;
	}
	
	
	/*
	**  функция записывает text
	*/
    public function setText($text) {
		$this->text = $text;
	}
	
	
	/*
	**  функция возвращает conversation_message_id
	**
	**  @return integer 
	*/
    public function getConversationMessageId() {
		return $this->conversation_message_id;
	}
	
	
	/*
	**  функция записывает conversation_message_id
	*/
    public function setConversationMessageId($conversation_message_id) {
		$this->conversation_message_id = $conversation_message_id;
	}
	
	
	/*
	**  функция возвращает fwd_messages
	**
	**  @return array 
	*/
    public function getFwdMessages() {
		return $this->fwd_messages;
	}
	
	
	/*
	**  функция записывает fwd_messages
	*/
    public function setFwdMessages($fwd_messages) {
		$this->fwd_messages = $fwd_messages;
	}
	
	
	/*
	**  функция возвращает important
	**
	**  @return boolean 
	*/
    public function getImportant() {
		return $this->important;
	}
	
	
	/*
	**  функция записывает important
	*/
    public function setImportant($important) {
		$this->important = $important;
	}	
	
	
	/*
	**  функция возвращает random_id
	**
	**  @return integer 
	*/
    public function getRandomId() {
		return $this->random_id;
	}
	
	
	/*
	**  функция записывает random_id
	*/
    public function setRandomId($random_id) {
		$this->random_id = $random_id;
	}
	
	
	/*
	**  функция возвращает attachments
	**
	**  @return array 
	*/
    public function getAttachments() {
		return $this->attachments;
	}
	
	
	/*
	**  функция записывает attachments
	*/
    public function setAttachments($attachments) {
		$this->attachments = $attachments;
	}
	
	
	/*
	**  функция возвращает payload
	**
	**  @return array 
	*/
    public function getPayload() {
		return $this->payload;
	}
	
	
	/*
	**  функция записывает payload
	*/
    public function setPayload($payload) {
		$this->payload = $payload;
	}
	
	
	/*
	**  функция возвращает is_hidden
	**
	**  @return boolean
	*/
    public function getIsHidden() {
		return $this->is_hidden;
	}
	
	
	/*
	**  функция записывает is_hidden
	*/
    public function setIsHidden($is_hidden) {
		$this->is_hidden = $is_hidden;
	}
	
	
}
?>
