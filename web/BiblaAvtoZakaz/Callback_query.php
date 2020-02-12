<?

if (strpos($callback_data, ":")!==false) {

	$komanda = strstr($callback_data, ':', true);	
	
	$id = substr(strrchr($callback_data, ":"), 1);
	
	$callback_data = $komanda;

}

if ($callback_data=='создать'){

	_создать();

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
	
	
}elseif ($callback_data=='продам') {	

	_продам();

}elseif ($callback_data=='куплю') {	

	_куплю();

}elseif ($callback_data=='да_нужна') {	

	_да_нужна();

}elseif ($callback_data=='не_нужна') {	

	_не_нужна();

}elseif ($callback_data==$категории[0]||$callback_data==$категории[1]||$callback_data==$категории[2]||$callback_data==$категории[3]||$callback_data==$категории[4]||$callback_data==$категории[5]||$callback_data==$категории[6]||$callback_data==$категории[7]||$callback_data==$категории[8]||$callback_data==$категории[9]||$callback_data==$категории[10]||$callback_data==$категории[11]) {	

	_запись_в_таблицу_маркет($callback_from_id, 'otdel', $callback_data);

	_выбор_валюты();

}elseif ($callback_data=='рубль') {	

	_рубль();

}elseif ($callback_data=='доллар') {	

	_доллар();

}elseif ($callback_data=='евро') {	

	_евро();

}elseif ($callback_data=='юань') {	

	_юань();

}elseif ($callback_data=='гривна') {	

	_гривна();

}elseif ($callback_data=='фунт') {	

	_фунт();

}elseif ($callback_data=='призм') {	

	_призм();

}elseif ($callback_data=='нужен_альбом') {	

	_нужен_альбом();

}elseif ($callback_data=='не_нужен_альбом') {	

	_не_нужен_альбом();

}elseif ($callback_data=='опубликовать') {	

	_вывод_лота_на_каналы($id);
	
}elseif ($callback_data=='доверяет') {	
		
	_доверяет($id);
	
	
}elseif ($callback_data=='редактировать') {	
		
	$bot->answerCallbackQuery($callback_query_id, "Функция ещё не реализованна!");
	
	
}elseif ($callback_data=='отказать') {	
	
	_отказать($id);
	
	
}elseif ($callback_data=='отказанно') {	
		
	$bot->answerCallbackQuery($callback_query_id, "Отказанно!");
	
	
}elseif ($callback_data=='старт') {	

	_start_AvtoZakazBota();
	
}elseif ($callback_data=='на_публикацию') {	

	_на_публикацию();
	
}elseif ($callback_data=='изменить_подробности') {	

	_изменить_подробности();
	
}


?>