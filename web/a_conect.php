<?php

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
?>