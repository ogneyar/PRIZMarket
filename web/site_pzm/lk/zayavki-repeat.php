<article id="repeat_delete">
<h4><br>
<?php
$номер_лота = $_POST['id_lota'];

$давно = _последняя_публикация_на_сайте($логин);	

if ($давно) {		
	_установка_времени($номер_лота);
	$время = _ожидание_публикации($номер_лота);
	
	$время_публикации = date("H:i", $время);
	
	echo "<label>{$логин}<br><br>Повтор публикации в {$время_публикации} мск</label>";
	
	include_once '../../myBotApi/Bot.php';
	$bot = new Bot($tokenSite);
	$сообщение = "{$логин} (сайт) лот {$номер_лота}\nПовтор публикации в {$время_публикации} мск";
	$bot->sendMessage($admin_group_AvtoZakaz, $сообщение);		
        $bot->sendMessage($channel_info, "?");
	
}else {?>
	<label><?=$логин;?>, после последней публикации прошло менее суток.<br></label>	
	<label>При особом желании Вы можете публиковать чаще, для этого напишите нам в <a href="https://teleg.link/zakazLOTbot" target="_blank">телеграм</a>.<br></label>
	<label>БезОплатно публиковать можно раз в сутки.<br></label>
<?
}
?>
</h4>
</article>
