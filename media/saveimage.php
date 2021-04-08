<center><br><br><br><br><br><br><br><br>
<?php
if (isset($_FILES['file'])) {
	
	//echo "имя файла: {$_FILES['file']['name']}<br>";
	//echo "его размер: {$_FILES['file']['size']}<br><br>";		
	
	//141.8.193.236
	
	$три_мегабайта = "3145728";
	$пять_мегабайт = "5242880";
	
	if ($_FILES['file']['size'] > $пять_мегабайт) {
		
		echo "Ваше фото больше 5 МегаБайт<br>";
		
	}else {
		$расширение = strrchr($_FILES['file']['name'], ".");
		
		$имя = uniqid().$расширение;
		
		if ($_POST['tester']) $имя = "test".$имя;
		
		// $путь_к_файлу_на_sprinthost = "/home/a0525484/domains/pzmarket.ru/public_html/media/image/".$имя;

		$путь_к_файлу_на_sprinthost = __DIR__. "/image/{$имя}";
		
		$загруженый_файл = $_FILES['file']['tmp_name'];
		
		$результат = move_uploaded_file($загруженый_файл, $путь_к_файлу_на_sprinthost); 
		
		echo "Процесс сохранения файла...<br/>";

		if ($результат) {
			
			$ссылка = "https://".$_SERVER['SERVER_NAME']."/image/{$имя}";

			// $ссылка = "https://media.pzmarket.ru/image/".$имя;
						
			$данные = [
				'login' => $_POST['login'],
				'url' => $ссылка
			];
				
			echo "Файл сохранён.";

			if ($_POST['tester']) {

				header("Location: https://naherokubot.herokuapp.com/site_pzm/lk/sozdanie.php?".http_build_query($данные));
				
			}else header("Location: https://pzmarket.ru/site_pzm/lk/sozdanie.php?".http_build_query($данные));
			
			
		}
	}
}else {
	echo "Нет файла.";
}
?>
</center>