<?php

//$tg->sendMessage($master, 'я тут');

// $from_id - айди того, кто добавил бота в группу
// $chat_id - айди группы, в которую добавили бота

$query = "SELECT * FROM ".$table6." WHERE id_garant=" . $from_id;
if ($result = $mysqli->query($query)) {			
	if($result->num_rows>0){
		$arrayResult = $result->fetch_all(MYSQLI_ASSOC);
		foreach($arrayResult as $stroka){
			
			if ($stroka['id_admin_group']=='0'&&$stroka['id_chat']!=$chat_id){
				$query = "UPDATE ".$table6." SET id_admin_group=". $chat_id ." WHERE id_garant=" . $from_id;
				if ($result = $mysqli->query($query)) {
				
					$tg->sendMessage($from_id, 'Бот добавлен в группу администрирования. Бот должен быть администратором чата, сделайте его администратором! А после введите команду /setting, но уже в самой группе АДМИНИСТРИРОВАНИЯ сделок.');	
						
					$tg->sendMessage($chat_id, 'Бот добавлен в группу администрирования сделок, он должен быть администратором этой группы! Прошу учесть, что и гаранты находящиеся здесь, должны быть администраторами этой группы!');
					// Для настроек введите команду /setting, эта команда работает только в этой группе.
					
					$tg->sendMessage($admin_group, "БотГарант добавлен в чат-админку ".$chat_id);
					
				}else $tg->sendMessage($from_id, 'Не смог добавить группу администрирования в БД');
			}else{
				$query = "UPDATE ".$table6." SET id_chat=". $chat_id .
						", id_admin_group='0' WHERE id_garant=" . $from_id;
				if ($result = $mysqli->query($query)) {		
					$tg->sendMessage($from_id, "Бот добавлен в НОВЫЙ чат-обменник. Бот должен быть администратором чата, сделайте его администратором! А после добавьте бота в отдельную группу, для АДМИНИСТРИРОВАНИЯ сделок, где будут находиться только ГАРАНТЫ.");
					
					$tg->sendMessage($admin_group, "БотГарант добавлен в чат-обменник @".
							$chat_user_name."\nего id: ".$chat_id);
				}else $tg->sendMessage($from_id, 'Не смог добавить НОВЫЙ чат в БД');
			}
		
		}
	}else{
		$query = "INSERT INTO ".$table6." VALUES ('". $from_id ."', '@". $user_name ."', '" . $chat_id . "', '@".$chat_user_name."', '0')";
		if ($result = $mysqli->query($query)) {		
			$tg->sendMessage($from_id, 'Бот добавлен в чат-обменник. Бот должен быть администратором чата-обменника, сделайте его администратором! А после добавьте бота в отдельную группу, для АДМИНИСТРИРОВАНИЯ сделок, где будут находиться только ГАРАНТЫ.');

			$tg->sendMessage($admin_group, "БотГарант добавлен в\n чат-обменник @".
					$chat_user_name."\nего id: ".$chat_id);
		}else $tg->sendMessage($from_id, 'Не смог добавить чат в БД');
	}
}else $tg->sendMessage($from_id, 'ошибка');



		



?>