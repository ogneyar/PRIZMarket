
<?php
if (isset($_POST['file'])) {

	// $результат = unlink("/home/a0525484/domains/pzmarket.ru/public_html/media/image/".$_POST['file']);	
	
	$результат = unlink(__DIR__. "/image/{$_POST['file']}");
	
	if ($результат) {
	
		// echo "Удалил файл ".$_POST['file'];

		echo "Удалил";
	
	}
	
}else {
	
	echo "Пусто";
	
}
?>