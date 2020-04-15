<?
include_once '../../../vendor/autoload.php';	
include_once '../../a_conect.php';

if ($_FILES['file']) echo "Файл: ".$_FILES['file']['tmp_name']."<br><br>";

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

if(!$upload) echo "Не смог загрузить файл";
else {
	echo "Файл загружен на Амазон";
	$ссылка_на_амазон = "https://{$aws_bucket}.s3.{$aws_region}.amazonaws.com/" . $key;
	echo "<br><br>" . $ссылка_на_амазон;
}

?>