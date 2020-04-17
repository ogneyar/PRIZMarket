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
	$bot->setMyCommands($BotCommand);
}else {
	echo "Файл загружен на Амазон";
	$ссылка_на_амазон = "https://{$aws_bucket}.s3.{$aws_region}.amazonaws.com/" . $key;
	echo "<br><br>" . $ссылка_на_амазон;	
	$bot->sendMessage($мастер, "Привеееет");	
}

?>