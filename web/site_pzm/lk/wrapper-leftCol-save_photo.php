<article id="lk">
<br>
<h4>
<?
//include_once '../../../vendor/autoload.php';	
//include_once '../../a_conect.php';

echo $_COOKIE['login'].", идёт загрузка файла";

foreach( $_FILES as $file ){
	$путь_к_фото = $file['tmp_name'];
	//echo "<br><br>" . $путь_к_фото . "<br><br>";
}

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
</h4>
</article>