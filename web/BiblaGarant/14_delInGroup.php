<?php

// $from_id - айди того, кто удалил бота из группу
// $chat_id - айди группы, из которой удалили бота

$query = "SELECT * FROM ".$table6." WHERE id_chat=" . $chat_id;
if ($result = $mysqli->query($query)) {			
	if($result->num_rows>0){
		$query = "DELETE FROM ".$table6." WHERE id_chat=".$chat_id;				
		if ($result = $mysqli->query($query)) {			
			$tg->sendMessage($admin_group, "Бот удалён из чата ". $chat_title);
			exit('ok');
		}
	}
}

$query = "SELECT * FROM ".$table6." WHERE id_admin_group=" . $chat_id;
if ($result = $mysqli->query($query)) {			
	if($result->num_rows>0){
		$query = "UPDATE ".$table6." SET id_admin_group='0' WHERE id_admin_group=".$chat_id;
		if ($result = $mysqli->query($query)) {			
			$tg->sendMessage($admin_group, "Бот удалён из чата ". $chat_title);
			exit('ok');
		}
	}
}

?>