<?
include_once '../../../vendor/autoload.php';	
include_once '../../a_conect.php';
include_once '../../myBotApi/Bot.php';
//exit('ok');
$token = $tokenSite;
$bot = new Bot($token);
$id_bota = strstr($token, ':', true);	
include_once '../../myBotApi/Variables.php';
$admin_group = $admin_group_Site;
$админка = $admin_group;
$мастер = $master;

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

$key = "TEMP-".$_COOKIE['login'].".jpg";
	
$file = file_get_contents($путь_к_фото);
  
$upload = $s3->putObject([
	'Bucket' => $aws_bucket,
	'Key'    => $key, 
	'Body'   => $file,	
	'ACL'    => 'public-read'
]);			
// ---------------------------			

if(!$upload) {
	echo "Не смог загрузить файл";	
}else {
	echo "Файл загружен на Амазон";
	$ссылка_на_амазон = "https://{$aws_bucket}.s3.{$aws_region}.amazonaws.com/" . $key;
	echo "<br><br>" . $ссылка_на_амазон;	
	$bot->sendMessage($мастер, "Файл загружен на Амазон");
	//$bot->setMyCommands($BotCommand);
}








/*

$query = "DELETE FROM {$table_market} WHERE id_client={$callback_from_id} AND status=''";				
if ($mysqli->query($query)) {			
	$query = "INSERT INTO {$table_market} (
	  `id_client`, `id_zakaz`, `kuplu_prodam`, `nazvanie`, `url_nazv`, `valuta`, 
	  `gorod`, `username`, `doverie`, `otdel`, `format_file`, `file_id`, `url_podrobno`, 
	  `status`, `podrobno`, `url_tgraph`, `foto_album`, `url_info_bot`, `date`
	) VALUES (
	  '{$callback_from_id}', '', '', '', '', '', '', '@{$callback_from_username}', '', '', '', '', '', '', '', '', '', '', ''
	)";							
}else throw new Exception("Не смог удалить запись в таблице {$table_market} (_запись_в_таблицу_маркет)");

$result = $mysqli->query($query);			
if (!$result) throw new Exception("Не смог сделать запись в таблицу {$table_market} (_запись_в_таблицу_маркет)");			

*/






?>