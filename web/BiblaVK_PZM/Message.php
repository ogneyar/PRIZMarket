<?

if ($text == "Прива") {
	
	$random_id = time();
	
	$массив = [
		"access_token" => $vk_token, 
		"random_id" => $random_id, 
		"peer_id" => $from_id, 
		"message" => "Ну да, здравствуй)", 
		"v" => $vk_api_version
	];

	file_get_contents("https://api.vk.com/method/". "messages.send?". http_build_query($массив));


}elseif ($text == "загрузи") {	
	
	$результат = $vk->photosGetUploadServer($vk_album_id, $vk_group_id);
	
	if ($результат['error_msg']) {		
		$vk->messagesSend($from_id, "Ошибка: ".$результат['error_msg']);
		exit;		
	}
	
	//$vk->messagesSend($from_id, "результат: ".print_r($результат));
	
	$vk->messagesSend($from_id, "upload_url: ".$результат['upload_url']);
		
	$результат = $vk->upload($результат['upload_url'], "http://f0430377.xsph.ru/image/test5eccceaecbdc4.jpg");
		
	$server = $результат['server'];
	$photos_list = $результат['photos_list'];
	$hash = $результат['hash'];
		
	$vk->messagesSend($from_id, "server: {$server}, photos_list: {$photos_list}, hash: {$hash}");
		
	$результат = $vk->photosSave($vk_album_id, $vk_group_id, $server, $photos_list, $hash);
		
	//echo "id фото: ".$результат['id'];
		
	$vk->messagesSend($from_id, "id фото: ".$результат['id']);

}else {

    $vk->messagesSend($from_id, "не пойму(");

} 

?>