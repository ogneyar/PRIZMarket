<?

if ($тело == "Прива") {

   $массив = [
      "access_token" => $vk_token, 
      "peer_id" => $user_id_vk, 
      "message" => "Ну да, здравствуй)", 
      "v" => $vk_api_version
   ];

  file_get_contents("https://api.vk.com/method/". "messages.send?". http_build_query($массив));


}else {

        $bot_vk->messagesSend($user_id_vk, "не пойму(");

} 

?>