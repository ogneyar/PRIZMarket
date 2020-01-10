<?php
include_once '../vendor/autoload.php';
	
include_once 'a_conect.php';
	
// Мастер это Я
$master='351009636';

$tg = new \TelegramBot\Api\BotApi($tokenMARKET);

$credentials = new Aws\Credentials\Credentials($aws_key_id, $aws_secret_key);
	
$s3 = new Aws\S3\S3Client([
	'credentials' => $credentials, 
    'version'  => 'latest',
    'region'   => $aws_region
]);

?>
<html>
    <head><meta charset="UTF-8">
	<title>АПЛОАД</title></head>
    <body>
        <h1>S3 upload example</h1>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['userfile']) && $_FILES['userfile']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['userfile']['tmp_name'])) {
    // FIXME: add more validation, e.g. using ext/fileinfo
    try {
	
        // FIXME: do not use 'name' for upload (that's the original filename from the user's computer)
   
		//$tg->sendMessage($master, $_FILES['userfile']['tmp_name']);
   
		//$result = $s3->listBuckets([]);   
		
		$file = file_get_contents($_FILES['userfile']['tmp_name']);
  
		$upload = $s3->putObject([
			'Bucket' => $aws_bucket,
			'Key'    => $_FILES['userfile']['name'], 
			'Body'   => $file,	
			'ACL'    => 'public-read'
		]);
	
		//$tg->sendMessage($master, 'тююю');
	
	/*
$retrive = $s3->getObject([
     'Bucket' => $aws_bucket,
     'Key'    => $_FILES['userfile']['name'],
     'SaveAs' => 'testkey_local'
]);

// Print the body of the result by indexing into the result object.
echo $retrive['Body'];

*/

	//$tg->sendMessage($master, $upload['ContentType']);
   
?>
		<p>Upload <a href="<?=htmlspecialchars($upload->get('ObjectURL'))?>">successful</a> :)</p>		
<?php } catch(Exception $e) { ?>
        <p>Upload error :(</p>
<?php } } ?>
        <h2>Upload a file</h2>
        <form enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <input name="userfile" type="file"><input type="submit" value="Upload">
        </form>
    </body>
</html>
