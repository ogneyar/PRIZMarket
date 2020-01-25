<?php

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
	
	$master = getenv('MASTER');
	$admin_group_market = getenv('ADMIN_GROUP_MARKET');
	$admin_group_garant = getenv('ADMIN_GROUP_GARANT');		
	$admin_group_Info = getenv('ADMIN_GROUP_INFO');
	$admin_group_Zakaz = getenv('ADMIN_GROUP_ZAKAZ');
	$admin_group_AvtoZakaz = getenv('ADMIN_GROUP_AVTOZAKAZ');	
	$test_group = getenv('TEST_GROUP');
	$channel_market = getenv('CHANNEL_MARKET');
	$channel_info = getenv('CHANNEL_INFO');
	
?>
