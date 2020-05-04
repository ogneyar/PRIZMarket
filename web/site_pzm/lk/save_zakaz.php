<?
$логин = $_COOKIE['login'];
include_once '../../../vendor/autoload.php';	
include_once '../../a_conect.php';
include_once '../../myBotApi/Bot.php';
//exit('ok');
$bot = new Bot($tokenSite);
$id_bota = strstr($tokenSite, ':', true);	
include_once '../../myBotApi/Variables.php';
include_once '../../BiblaSite/Functions.php';
$admin_group = $admin_group_Site;
$админка = $admin_group;
$мастер = $master;
$table_market = 'avtozakaz_pzmarket';
$mysqli = new mysqli($host, $username, $password, $dbname);
if (mysqli_connect_errno()) {
	echo "Чёт не выходит подключиться к MySQL<br><br>";	
	exit('ok');
}else { // начало
	
	//if ($_FILES['file']) echo "Файл: ".$_FILES['file']['tmp_name']."<br><br>";
	if ($_POST['hesh_pk']) echo "К/П: ".$_POST['hesh_pk']."<br><br>";
	if ($_POST['name']) echo "Наименование: ".$_POST['name']."<br><br>";
	if ($_POST['link_name']) echo "Ссылка: ".$_POST['link_name']."<br><br>";
	if ($_POST['hesh_kateg']) echo "Категория: ".$_POST['hesh_kateg']."<br><br>";
	if ($_POST['currency']) echo "Валюта: ".$_POST['currency']."<br><br>";
	if ($_POST['hesh_city']) echo "Местонахождение: ".$_POST['hesh_city']."<br><br>";
	if ($_POST['opisanie']) echo "Описание: ".$_POST['opisanie']."<br><br>";

	$путь_к_фото = $_FILES['file']['tmp_name'];

	// Подключение к Амазон
	$credentials = new Aws\Credentials\Credentials($aws_key_id, $aws_secret_key);
		
	$s3 = new Aws\S3\S3Client([
		'credentials' => $credentials, 
		'version'  => 'latest',
		'region'   => $aws_region
	]);

	$key = "TEMP-".$логин.".jpg";
		
	$file = file_get_contents($путь_к_фото);
	  
	$upload = $s3->putObject([
		'Bucket' => $aws_bucket,
		'Key'    => $key, 
		'Body'   => $file,	
		'ACL'    => 'public-read'
	]);			
	// ---------------------------			

	if(!$upload) {
		echo "Не смог загрузить файл на Амазон";	
	}else {
		echo "Файл загружен на Амазон";
		$ссылка_на_амазон = "https://{$aws_bucket}.s3.{$aws_region}.amazonaws.com/" . $key;
		echo "<br><br>" . $ссылка_на_амазон;	
		$bot->sendMessage($мастер, "Файл загружен на Амазон");
		//$bot->setMyCommands($BotCommand);
		
		
		
		$query = "DELETE FROM {$table_market} WHERE id_client='7' AND username='{$логин}' AND status=''";		
		if ($mysqli->query($query)) {			
			$query = "INSERT INTO {$table_market} (
			  `id_client`, `id_zakaz`, `kuplu_prodam`, `nazvanie`, `url_nazv`, `valuta`, 
			  `gorod`, `username`, `doverie`, `otdel`, `format_file`, `file_id`, `url_podrobno`, 
			  `status`, `podrobno`, `url_tgraph`, `foto_album`, `url_info_bot`, `date`
			) VALUES (
			  '7', '', '{$_POST['hesh_pk']}', '{$_POST['name']}', '{$_POST['link_name']}', '{$_POST['currency']} / PZM', '{$_POST['hesh_city']}', '{$логин}', '0', '{$_POST['hesh_kateg']}', '', '', '', '', '{$_POST['opisanie']}', '{$ссылка_на_амазон}', '', '', ''
			)";							
			$result = $mysqli->query($query);			
			if (!$result) echo "Не смог сделать запись в таблицу {$table_market} (save_zakaz.php)";	
			
			//$bot->sendMessage($admin_group_AvtoZakaz, "Данные с сайта записаны в БД.");
			
			_отправка_лота_админам(); // BiblaSite/Functions.php
			
		}else echo "Не смог удалить запись в таблице {$table_market} (_запись_в_таблицу_маркет)";		
		
	}


} // конец

?>