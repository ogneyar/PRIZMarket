<?php

$est=strpos($text, "t.me/prizm_market");



//ОСНОВНАЯ РАБОТА БОТА, ВЫПОЛНЕНИЕ КОМАНД (РЕАКЦИЯ НА РЕПЛИКИ ПОЛЬЗОВАТЕЛЯ)

if ($est!==false){

	$reply = $first_name ." не надо сюда ссылки кидать, если я правильно понял, то ".
		"Вам надо заявку подать, тогда ссыль кидать надо в [ЗаказБот]".
		"(t.me/Zakaz_prizm_bot) \xF0\x9F\x91\x88 с пометкой 'В БОТ'";		
	$tg->sendMessage($chat_id, $reply, markdown);
	
	
}elseif ($text == $knopa01) {  
		
        $reply = "✅ *PRIZMarket*❗️ {$PZMarket} \n\n{$zakaz}{$tehPodderjka}";
		
        $tg->sendMessage($chat_id, $reply, markdown, false);	
		
			
}elseif ($text == $knopa02) {		       
			
			
}elseif ($text == $knopa03) {  //ВЭС
		
		$reply = "\xF0\x9F\x94\x97 [Ваша Экономическая Свобода!]".
			"(http://t.me/PRIZM_world_bot?start=) \xF0\x9F\x91\x88 ".
			"Это бот о PRIZM и его задача объяснить и помочь Вам разобраться в деталях ".
			"и особенностях этой денежной единицы и понять насколько интересны и выгодны ".
			"инвестиции в нее, а также разобраться в пользовании этой валютой, как платежным средством.".			
			"{$tehPodderjka}";        
        
		//$file_id='CgADAgAD2gMAArKrUEtmCqiq0qoR0hYE';		
		//$tg->sendVideo($chat_id, $file_id, 1, $reply);
        
		$tg->sendMessage($chat_id, $reply, markdown, true);
		
			
}elseif ($text == $knopa04) {      
			
			
}elseif ($text == $knopa05) {  // ВЫБОР КАТЕГОРИИ ТОВАРОВ
		
        $reply = "\xE2\x9C\x85 Выберите категорию!";         
		$tg->sendMessage($chat_id, $reply, null, true, null, $keyboard_Kategorii);		
		
			
}elseif ($text == $knopa06) {		       
			
			
}elseif ($text == $knopa07) {

		$reply = "По шаговая инструкция!";   // \xF0\x9F\x91\xA3       
		$tg->sendMessage($chat_id, $reply);
		
        $reply = "\x31\xE2\x83\xA3 Для начала нужно создать пост на канале ".
			"\n{$PZMarket}".
			"\n\n{$zakaz} \n\nЕсли сделали, жмите \xF0\x9F\x91\x89  Следующий шаг.\n{$tehPodderjka}";
                
		$tg->sendMessage($chat_id, $reply, markdown, true, null, $keyboardStep1);
		
			
}elseif ($text == $knopa08) {		        
		
		
}elseif ($text == $knopa09) {	        		
		
		
}elseif ($text == $GlavnoeMenu) {  //ГЛАВНОЕ МЕНЮ

	_start_PZMarket_bota($this_admin);   //PZMarketBot		

	/*		
		$reply  = "✅ *PRIZMarket* ❗️ \n\n▪️*PRIZMarket* - место где можно увидеть ".
		"товары и услуги за PRIZM. {$zakaz}\n\n▪️*Категории* - поиск нужного вам товара ".
		"или услуги!\n\n▪️*ВЭС* - для тех кто понятия не имеет о PRIZM {$tehPodderjka}";		
		
		$tg->sendMessage($chat_id, $reply, markdown, true, null, $keyboard);			
	*/		
			
}elseif ($text == $knopaStep01) {  //Следующий шаг
	        
	$reply = "\x32\xE2\x83\xA3 Скопировать ссылку вашего поста с канала \n{$PZMarket}\n\nи отправить в \xF0\x9F\x91\x89 [ЗаказБот](https://t.me/Zakaz_prizm_bot?start=) \n\nс пометкой *в бот* указав  категорию (просто напишите название) где должен отображаться ваш пост.\n{$tehPodderjka}";
        		
	$tg->sendMessage($chat_id, $reply, markdown, true, null, $keyboardStep2);		
			
			
}elseif ($text == $knopaStep2_01) {  //подключение видео...	

/*
	$file_id="AAQCAAPfAwACanNQS3It-FiCpPZwYWnxDgAEAQAHbQADZjAAAhYE";
	$reply = "Зырь)))({$tehPodderjka}";	
	$tg->sendVideo($chat_id, $file_id); //, "71", $reply, null, $keyboardStep3, false, false, markdown
*/

	$media = new \TelegramBot\Api\Types\InputMedia\ArrayOfInputMedia();
	
	$media->addItem(new TelegramBot\Api\Types\InputMedia\InputMediaVideo($_SERVER['HTTP_HOST'].
		"/zMedia/zayavka.mp4"));

	$tg->sendMediaGroup($chat_id, $media);
		
		
	$tg->sendMessage($chat_id, $tehPodderjka, markdown, true, null, $keyboardStep3);


	
	
}elseif (($text == $DopKnopa[0]) || ($text == $DopKnopa[1]) || ($text == $DopKnopa[2]) || ($text == $DopKnopa[3]) || ($text == $DopKnopa[4]) || ($text == $DopKnopa[5]) || ($text == $DopKnopa[6]) || ($text == $DopKnopa[7]) || ($text == $DopKnopa[8]) || ($text == $DopKnopa[9]) || ($text == $DopKnopa[10]) || ($text == $DopKnopa[11])) {
	        
	$query = "SELECT * FROM ".$table5." WHERE otdel='{$text}'";
	if ($result = $mysqli->query($query)) {			
		$kol = $result->num_rows;
		if($kol>0){
		
			$arrStrok = $result->fetch_all();					
			
			if ($kol>$limit){
							
				//foreach($arrStrok as $arrS){	
				
				_pechat_lotov($chat_id, $arrStrok, 0, --$limit);
				
				$inLine = [[["text"=>"Далее","callback_data"=>$text.":".++$limit]]];
				$inLineKeyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLine);
					
				$tg->sendMessage($chat_id, "Что бы посмотреть ещё, жмите далее...".$tehPodderjka, markdown, true, null, $inLineKeyboard);						
				
				
			}else {
				_pechat_lotov($chat_id, $arrStrok, 0, --$kol);
				$tg->sendMessage($chat_id, $tehPodderjka, markdown);
			}
			
			
		}else {
			$reply = "\xE2\x9D\x97 В данном разделе поставщиков еще нет. Вы можете".
			" *стать первым*, для этого напишите нам в \xF0\x9F\x91\x89 [Тех.поддержку]".
			"(https://t.me/Prizm_market_supportbot?start=) \xF0\x9F\x91\x88";        
			
			$tg->sendMessage($chat_id, $reply, markdown);		
		}					
		
	}else throw new Exception("Не получилось подключиться к таблице {$table5}");		
		
			
}elseif ($text!=="/start"&&$text!=="s"&&$text!=="S"&&$text!=="с"&&$text!=="С"&&$text!=="c"&$text!=="C") {

	if ($this_admin==true) {
		include 'bot_10_admin.php';
	}else{
	
		$reply = "Я *не пойму* эту команду. \xF0\x9F\x98\xB3\nВозможно из-за ОБНОВЛЕНИЯ меня (бота) произошло недопонимание. \n" . $first_name . ", попробуйте нажать /start";
		
		$tg->sendMessage($chat_id, $reply, markdown);		
		
	}
}


if (($text)&&($this_admin==false)){
	//ОТПРАВКА ИФОРМАЦИИ О СООБЩЕНИИ В ГРУППУ 
	$reply = $first_name . "({$chat_id}) пишет:\n*" . $text . "*\n\xF0\x9F\x91\x89 @" . $user_name;
	$tg->sendMessage($admin_group, $reply, markdown, true);
}


//$tg->deleteMessage($chat_id, $message_id);

	
?>