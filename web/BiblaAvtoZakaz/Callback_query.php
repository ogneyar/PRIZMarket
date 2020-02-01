<?

if (strpos($callback_data, ":")!==false) {

	$komanda = strstr($callback_data, ':', true);	
	
	$id = substr(strrchr($callback_data, ":"), 1);
	
	$callback_data = $komanda;

}

if ($callback_data=='создать'){

	_создать();

}elseif ($callback_data=='продам') {	

	_продам();

}elseif ($callback_data=='куплю') {	

	_куплю();

}elseif ($callback_data=='да_нужна') {	

	_да_нужна();

}elseif ($callback_data=='не_нужна') {	

	_не_нужна();

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
	
}


?>