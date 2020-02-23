<?
if (strpos($callback_data, ":")!==false) {
	$komanda = strstr($callback_data, ':', true);		
	$id = substr(strrchr($callback_data, ":"), 1);	
	$callback_data = $komanda;
}

if ($callback_data=='создать'){
	_создать();
	
}elseif ($callback_data=='продам') {		
	_продам_куплю('#продам');
	
}elseif ($callback_data=='куплю') {	
	_продам_куплю('#куплю');
	
}elseif ($callback_data=='нужна_ссылка') {	
	_ожидание_ввода('url_nazv', 'nazvanie');	
	$bot->answerCallbackQuery($callback_query_id, "Ожидаю ввода Вашей ссылки!");	
	$reply = "Пришлите мне ссылку, типа:\n\n  https://mysite.ru/supersite/";	
	$bot->sendMessage($chat_id, $reply, null, $клавиатура_отмена_ввода);
	
}elseif ($callback_data=='не_нужна_ссылка') {	
	_выбор_категории();
	
}elseif ($callback_data==$категории[0]||$callback_data==$категории[1]||
		 $callback_data==$категории[2]||$callback_data==$категории[3]||
		 $callback_data==$категории[4]||$callback_data==$категории[5]||
		 $callback_data==$категории[6]||$callback_data==$категории[7]||
		 $callback_data==$категории[8]||$callback_data==$категории[9]||
		 $callback_data==$категории[10]||$callback_data==$категории[11]) {		
	_запись_в_таблицу_маркет($callback_from_id, 'otdel', $callback_data);
	_выбор_валюты();
	
}elseif ($callback_data=='рубль') {	
	_когда_валюта_выбрана('₽');
	
}elseif ($callback_data=='доллар') {	
	_когда_валюта_выбрана('$');
	
}elseif ($callback_data=='евро') {	
	_когда_валюта_выбрана('€');
	
}elseif ($callback_data=='юань') {	
	_когда_валюта_выбрана('¥');
	
}elseif ($callback_data=='гривна') {	
	_когда_валюта_выбрана('₴');
	
}elseif ($callback_data=='фунт') {	
	_когда_валюта_выбрана('£');
	
}elseif ($callback_data=='призм') {	
	_когда_валюта_выбрана();
	
}elseif ($callback_data=='нужен_альбом') {	
	_очистка_таблицы_медиа();	
	_запись_в_таблицу_маркет($callback_from_id, 'foto_album', '1');	
	_ожидание_ввода('foto_album', 'foto_album');		
	$reply = "|\n|\n|\n|\n|\n|\n|\n|\nСкиньте мне разом все фото, которые должны оказаться в альбоме (НЕ по одной фотке)";	
	$bot->sendMessage($chat_id, $reply, null, $клавиатура_отмена_ввода);	
	
}elseif ($callback_data=='не_нужен_альбом') {
	_очистка_таблицы_медиа();	
	_запись_в_таблицу_маркет($callback_from_id, 'foto_album', '0');	
	_опишите_подробно();	
	
// после предпросмотра клиент отправляет лот админам на публикацию
}elseif ($callback_data=='на_публикацию') {	
	_на_публикацию();	

// редактирование клиентом текста с подробностями
}elseif ($callback_data=='изменить_подробности') {	
	_изменить_подробности();		

// если клиент нажал кнопку "В начало"
}elseif ($callback_data=='старт') {	
	_старт_АвтоЗаказБота();	
	
	
}elseif ($callback_data=='опубликовать') {	
	_вывод_лота_на_каналы($id);	
	
}elseif ($callback_data=='доверяет') {		
	_запись_в_таблицу_маркет($id, 'doverie', '1');	
	$bot->answerCallbackQuery($callback_query_id, "Хорошо, отмечен доверием!");	
	
}elseif ($callback_data=='не_доверяет') {	
	_запись_в_таблицу_маркет($id, 'doverie', '0');	
	$bot->answerCallbackQuery($callback_query_id, "ОТМЕНА отметки доверием!");	
	
}elseif ($callback_data=='редактировать_название') {	
	_ожидание_ввода('замена_названия', $id);
	$bot->answerCallbackQuery($callback_query_id, "Пришли мне новый текст с названием.", true);	
	
}elseif ($callback_data=='редактировать_ссылку') {	
	_ожидание_ввода('замена_ссылки', $id);	
	$bot->answerCallbackQuery($callback_query_id, "Пришли мне новую ссылку.", true);	
	
}elseif ($callback_data=='редактировать_хештеги') {		
	_ожидание_ввода('замена_хештегов', $id);	
	$bot->answerCallbackQuery($callback_query_id, "Пришли мне новый текст с хештегами.", true);		
	
}elseif ($callback_data=='редактировать_подробности') {		
	_ожидание_ввода('замена_подробностей', $id);	
	$bot->answerCallbackQuery($callback_query_id, "Пришли мне новый текст подробностей.", true);	
	
}elseif ($callback_data=='редактировать_фото') {		
	_ожидание_ввода('замена_фото', $id);	
	$bot->answerCallbackQuery($callback_query_id, "Пришли мне новое фото.", true);	
	
}elseif ($callback_data=='отказать') {		
	_отказать($id);	
	
}elseif ($callback_data=='отказанно') {			
	$bot->answerCallbackQuery($callback_query_id, "Отказанно!");		
	
}elseif ($callback_data=='отправлено') {			
	$bot->answerCallbackQuery($callback_query_id, "Отправлено!");	
	
	
	
}elseif ($callback_data=='повторить') {	
	_вывод_списка_лотов("повтор");
	
}elseif ($callback_data=='повтор') {	
	_повтор($id);
	
}elseif ($callback_data=='отправить_на_повтор') {	
	_отправить_на_повтор($id);
	
}elseif ($callback_data=='удалить') {		
	_вывод_списка_лотов("удаление");		
	
}elseif ($callback_data=='удаление') {		
	_удаление($id);		
	
}elseif ($callback_data=='удалить_выбранный_лот') {		
	_удалить_выбранный_лот($id);	
		
	
}elseif ($callback_data=='показать_редакт') {	
	_показать_редакт($id);		
	
}elseif ($callback_data=='доверяет_редакт') {	
	_редакт_таблицы_маркет($id, 'doverie', '1');	
	$bot->answerCallbackQuery($callback_query_id, "Хорошо, отмечен доверием!");	
	
}elseif ($callback_data=='не_доверяет_редакт') {	
	_редакт_таблицы_маркет($id, 'doverie', '0');	
	$bot->answerCallbackQuery($callback_query_id, "ОТМЕНА отметки доверием!");
	
}elseif ($callback_data=='название_редакт') {	
	_ожидание_ввода('название_редакт', $id);	
	$bot->answerCallbackQuery($callback_query_id, "Пришли мне новый текст с названием.");		
	
}elseif ($callback_data=='ссылку_редакт') {	
	_ожидание_ввода('ссылку_редакт', $id);	
	$bot->answerCallbackQuery($callback_query_id, "Пришли мне новую ссылку.");		
	
}elseif ($callback_data=='хештеги_редакт') {	
	_ожидание_ввода('хештеги_редакт', $id);	
	$bot->answerCallbackQuery($callback_query_id, "Пришли мне новый текст с хештегами.");	
	
}elseif ($callback_data=='подробности_редакт') {	
	_ожидание_ввода('подробности_редакт', $id);	
	$bot->answerCallbackQuery($callback_query_id, "Пришли мне новый текст с подробностями.");		
	
}elseif ($callback_data=='фото_редакт') {	
	_ожидание_ввода('фото_редакт', $id);	
	$bot->answerCallbackQuery($callback_query_id, "Пришли мне новое фото.");	
	
}elseif ($callback_data=='покажи') {	
	_отправка_лота($chat_id, $id, true);	
}





?>