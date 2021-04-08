<article id="lk">
<h4><br>
<?php
include_once '../../myBotApi/Bot.php';
include_once '../../BiblaAvtoZakaz/Functions_site.php';
//exit('ok');

$bot = new Bot($tokenAvtoZakaz);
$id_bota = strstr($tokenAvtoZakaz, ':', true);	

$admin_group = $admin_group_AvtoZakaz;
$table_market = 'avtozakaz_pzmarket';

if (empty($_GET['url'])) {
	echo "<br><h4>Ошибка! Не выбран файл.</h4>";		
	exit;
}else {

	$есть = _есть_ли_запись($логин, 'url_tgraph');
	
	if ($есть) {
		
		echo $логин."<br><br>";
		
	}else {
	
		$bot->sendMessage($master, "Файл {$_GET['url']} загружен на :)");		
		
		_запись_в_маркет_с_сайта($логин, 'url_tgraph', $_GET['url']);
		
		$время = time();
		_запись_в_маркет_с_сайта($логин, 'date', $время);
		
		_отправка_лота_админам_с_сайта(); 
		
	}
	
	echo "Заявка отправлена РАЙминистрации.<br><br>";
	echo "Сообщение о решении будет отправленно Вам на email.<br><br>";
	echo "Все вопросы в <a href='https://t.me/Prizm_market_supportbot'>тех.поддержку.</a>";
	
}

?>
</h4>
</article>