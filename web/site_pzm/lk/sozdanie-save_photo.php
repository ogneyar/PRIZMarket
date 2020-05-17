<article id="lk">
<h4><br>
<?
$логин = $_COOKIE['login'];
include_once '../../../vendor/autoload.php';	
include_once '../../a_conect.php';
include_once '../../myBotApi/Bot.php';
//exit('ok');

$bot = new Bot($tokenAvtoZakaz);
$id_bota = strstr($tokenAvtoZakaz, ':', true);	
include_once '../../myBotApi/Variables.php';
include_once '../../BiblaAvtoZakaz/Functions_site.php';
$admin_group = $admin_group_AvtoZakaz;
$table_market = 'avtozakaz_pzmarket';

if (empty($_FILES['file'])) {
	echo "Ошибка! Не выбран файл.";	
	//exit;
}else {

if ($_FILES['file']['type'] != 'image/jpeg') {
	//echo "Ошибка! Формат файла должен быть .jpg";	
	//exit;
	//echo $_FILES['file']['type']."<br>";
}
﻿﻿
$mysqli = new mysqli($host, $username, $password, $dbname);
if (mysqli_connect_errno()) {
	echo "Чёт не выходит подключиться к MySQL";	
	exit;
}else { // начало	
	// Подключение к Амазон
	$credentials = new Aws\Credentials\Credentials($aws_key_id, $aws_secret_key);
		
	$s3 = new Aws\S3\S3Client([
		'credentials' => $credentials, 
		'version'  => 'latest',
		'region'   => $aws_region
	]);
	
 	$uniqid = uniqid();	
	
	$key = "temp{$uniqid}.jpg";

	$путь_к_фото = $_FILES['file']['tmp_name'];
	
	$file = file_get_contents($путь_к_фото);
	  
	$upload = $s3->putObject([
		'Bucket' => $aws_bucket,
		'Key'    => $key, 
		'Body'   => $file,	
		'ACL'    => 'public-read'
	]);	

	if(!$upload) {
		echo "Не смог загрузить файл на Амазон";			
		exit;
	}else {		
		$ссылка_на_фото = "https://{$aws_bucket}.s3.{$aws_region}.amazonaws.com/" . $key;	
		$bot->sendMessage($master, "Файл {$key} загружен на Амазон");		
		
		_запись_в_маркет_с_сайта($логин, 'url_tgraph', $ссылка_на_фото);
		
		_отправка_лота_админам_с_сайта(); 
		
		/*
		$связь = _дай_связь($логин);
		
		if ($_POST['currency']) $валюта = $_POST['currency']." / PZM";
		else $валюта = "PZM";
		
		$время = time();
		
		$query = "DELETE FROM {$table_market} WHERE id_client='7' AND username='{$логин}' AND status=''";		
		if ($mysqli->query($query)) {			
			$query = "INSERT INTO {$table_market} (
			  `id_client`, `id_zakaz`, `kuplu_prodam`, `nazvanie`, `url_nazv`, `valuta`, 
			  `gorod`, `username`, `doverie`, `otdel`, `format_file`, `file_id`, `url_podrobno`, 
			  `status`, `podrobno`, `url_tgraph`, `foto_album`, `url_info_bot`, `date`
			) VALUES (
			  '7', '{$uniqid}', '{$_POST['hesh_pk']}', '{$_POST['name']}', '{$_POST['link_name']}', '{$валюта}', '{$_POST['hesh_city']}', '{$логин}', '0', '{$_POST['hesh_kateg']}', 'фото', '', '', '', '{$_POST['opisanie']}', '{$ссылка_на_фото}', '', '{$связь}', '{$время}'
			)";							
			$result = $mysqli->query($query);			
			if (!$result) {
				echo "Не смог сделать запись в таблицу  (sozdanie-save_zakaz.php)";	
				exit;
			}else {
		*/	
			/*	
				$array = [ 'login' => $логин, 'file' => $ссылка_на_фото ];		
				// инфа о том с какого сайта (тестового или оригинала) идёт посылка
				if ($tester == 'да') $array = array_merge($array, [ 'tester' => $tester ]);		
				// отправка madeLine фото для публикации её в телеге
				$ch = curl_init("http://f0430377.xsph.ru"."?".http_build_query($array));
				//curl_setopt($ch, CURLOPT_POST, 1);
				//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($array)); 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_HEADER, false);
				$html = curl_exec($ch);
				curl_close($ch);	
			*/
		/*	
				_отправка_лота_админам_с_сайта(); 
			}
		}else {
			echo "Не смог удалить запись в таблице (sozdanie-save_zakaz.php)";	
			exit;
		}
		
		*/
		
		echo "Заявка отправлена РАЙминистрации.<br><br>";
		echo "Сообщение о решении будет отправленно Вам на email.<br><br>";
		echo "Все вопросы в <a href='https://teleg.link/Prizm_market_supportbot'>тех.поддержку.</a>";
			
		
	}

} // конец

}
?>
</h4>
</article>