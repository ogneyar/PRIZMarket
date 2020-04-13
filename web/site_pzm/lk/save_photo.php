<?

echo "qqqqqqq<br><br>";

foreach( $_FILES as $file ){
	echo "ttttttt<br><br>". $file['tmp_name'];
}


/*
// Подключение к Амазон
$credentials = new Aws\Credentials\Credentials($aws_key_id, $aws_secret_key);
	
$s3 = new Aws\S3\S3Client([
	'credentials' => $credentials, 
    'version'  => 'latest',
    'region'   => $aws_region
]);

//echo $_POST['login'].", идёт загрузка файла";


// отправка файла на Амазон		
/*	
	$fileObject = $tg->getFile($file_id);		
	$file_url = $tg->getFileUrl();	
	$url = $file_url . "/" . $fileObject->getFilePath();
*/	
/*	
	$uploaddir = './uploads'; // . - текущая папка 
    
    // cоздадим папку если её нет
    if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );

    $files      = $_FILES; // полученные файлы
    $done_files = array();

    // переместим файлы из временной директории в указанную
    foreach( $files as $file ){
        $file_name = cyrillic_translit( $file['name'] );

        if( move_uploaded_file( $file['tmp_name'], "$uploaddir/$file_name" ) ){
            $done_files[] = realpath( "$uploaddir/$file_name" );
        }
    }
    
    $data = $done_files ? array('files' => $done_files ) : array('error' => 'Ошибка загрузки файлов.');
    
    die( json_encode( $data ) );
*/	
	
	/*
$key = "TEMP001.jpg";
	
$file = file_get_contents($_FILES['file']['tmp_name']);
  
$upload = $s3->putObject([
	'Bucket' => $aws_bucket,
	'Key'    => $key, 
	'Body'   => $file,	
	'ACL'    => 'public-read'
]);			
// ---------------------------			

if(!$upload) echo "Не смог загрузить файл";
else echo "Файл загружен на Амазон";
	*/
?>