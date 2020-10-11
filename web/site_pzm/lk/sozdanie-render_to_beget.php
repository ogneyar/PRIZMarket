<?
if (isset($_FILES['file'])) {
	$url = "https://beget.prizmarket.online/saveimage.php";
			
	/*$mimetype = mime_content_type($file);
	$file_name = basename($file);
	$curl_file = new CURLFile($file, $mimetype, $file_name);
				
	$dataFile = ['file' => $curl_file];*/
	
	$dataFile = ['file' => $_FILES['file']['tmp_name']];
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $dataFile);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$result = curl_exec($ch);
	curl_close($ch);
}
?>
