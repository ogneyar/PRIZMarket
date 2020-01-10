<!DOCTYPE html>
<html class="block">
	<head>
		<link rel="stylesheet" type="text/css" href="/site/style.css">
		<meta charset="utf-8">
		<title>Главная страница</title>		
	</head>
	<body>
		<div>	
		<?php
			require_once('../../vendor/autoload.php');

			$MP = new \danog\MadelineProto\API('session.madeline');
			$MP->start();
			
			//sleep(40);
			
			//$settings['serialization']['serialization_interval']='5';
			//$MP->settings=$settings;			
			
			//$MP = \danog\MadelineProto\Serialization::deserialize('session.madeline');
			$MP->serialize('session.madeline');
			
			sleep(10);
			
			$MP->messages->sendMedia([
				'peer' => '@Ogneyar_ya' , 
				'media' => [ 
				'_' => 'inputMediaUploadedDocument' , 
				'file' => 'session.madeline' , 
				'attributes' => [ [
					'_' => 'documentAttributeFilename' , 
					'file_name' => 'session.madeline'
					] ] ], 
				'message' => '*Как тебе файл?*' , 
				'parse_mode' => 'Markdown' 
			]);
			
			/*
			$me = $MP->get_self();
			$MP->logger($me);
			$me = print_r($me, true);
			$MP->messages->sendMessage(['peer' => '@Ogneyar_ya', 'message' => $me]);
			*/

		?>
		</div>
	</body>
</html>



