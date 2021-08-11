<?php

if (isset($_SERVER['HTTPS'])) {
	if ($_SERVER['HTTPS'] != 'on') {		
		header('Location: https://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']); 		
	}
}

	$OtladkaBota = getenv('OTLADKA'); 

	$aws_key_id = getenv('AWS_ACCESS_KEY_ID');
	$aws_secret_key = getenv('AWS_SECRET_ACCESS_KEY');
	$aws_region = getenv('AWS_REGION');
	$aws_bucket = getenv('AWS_BUCKET_NAME');

	$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
	$host = $url["host"];
	$username = $url["user"];
	$password = $url["pass"];
	$dbname = substr($url["path"], 1);

	$tokenMARKET = getenv('TOKEN_MARKET');
	$tokenGARANT = getenv('TOKEN_GARANT');
	$tokenInfo = getenv("TOKEN_INFO");
    $tokenZakaz = getenv('TOKEN_ZAKAZ');
	$tokenAvtoZakaz = getenv('TOKEN_AVTOZAKAZ');
	$tokenTimer = getenv('TOKEN_TIMER');
	$tokenTimer2 = getenv('TOKEN_TIMER_2');
	$tokenSite = getenv('TOKEN_SITE');
	$tokenICQnew = getenv('TOKEN_ICQNEW');	
	
	$cmc_api_key = getenv('CMC_PRO_API_KEY');
	$tokenTGraph = getenv('TOKEN_TELEGRAPH');
	$api_key = getenv('API_KEY_IMGBB');	
	
	$master = getenv('MASTER');
	$tester = getenv('TESTER');
	$Макс_гарант = getenv('MAKS_GARANT');
	$Макса_группа = getenv('MAKS_GROUP');
	$admin_group_market = getenv('ADMIN_GROUP_MARKET');
	$admin_group_garant = getenv('ADMIN_GROUP_GARANT');		
	$admin_group_Info = getenv('ADMIN_GROUP_INFO');
	$admin_group_Zakaz = getenv('ADMIN_GROUP_ZAKAZ');
	$admin_group_AvtoZakaz = getenv('ADMIN_GROUP_AVTOZAKAZ');	
	$admin_group_Site = getenv('ADMIN_GROUP_SITE');
	$test_group = getenv('TEST_GROUP');
	$channel_market = getenv('CHANNEL_MARKET');
	$channel_info = getenv('CHANNEL_INFO');
	$channel_podrobno = getenv('CHANEL_PODROBNO');
	$channel_media_market = getenv('CHANNEL_MEDIA_MARKET');

	$media_url = "https://media.prizmarket.ru";
	
	$smtp_login = getenv("SMTP_LOGIN");
	$smtp_pass = getenv("SMTP_PASSWORD");
	$smtp_port = getenv("SMTP_PORT");
	$smtp_server = getenv("SMTP_SERVER");
	
	$ICQtoken = getenv('ICQ_TOKEN');
	$ICQmaster = getenv('ICQ_MASTER');
	$ICQ_channel_market = getenv('ICQ_CHANNEL_MARKET');
	$ICQ_channel_podrobno = getenv('ICQ_CHANEL_PODROBNO');
	
	$vk_api_version = getenv('VK_API_VERSION');
	$vk_token = getenv('VK_TOKEN');
	$vk_token2 = getenv('VK_TOKEN2');
	$vk_secret_key = getenv('VK_SECRET_KEY');
	$vk_api_response = getenv('VK_API_RESPONSE');
	$vk_group_id = getenv('VK_GROUP_ID');
	$vk_album_id = getenv('VK_ALBUM_ID');
	$vk_master = getenv('VK_MASTER');
	
?>
