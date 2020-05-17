<?
$логин = $_COOKIE['login'];
//include_once '../../../vendor/autoload.php';	
include_once '../../a_conect.php';
include_once '../../myBotApi/Bot.php';
include_once '../../myBotApi/ImgBB.php';
$imgBB = new ImgBB($api_key);
//exit('ok');

$bot = new Bot($tokenAvtoZakaz);
$id_bota = strstr($tokenAvtoZakaz, ':', true);	
include_once '../../myBotApi/Variables.php';
include_once '../../BiblaAvtoZakaz/Functions_site.php';
$admin_group = $admin_group_AvtoZakaz;

$table_market = 'avtozakaz_pzmarket';
$mysqli = new mysqli($host, $username, $password, $dbname);
if (mysqli_connect_errno()) {
	echo "Чёт не выходит подключиться к MySQL<br><br>";	
	exit('ok');
}else { // начало
		
	$путь_к_фото = "https://prizmarket.online/app/web/site_pzm/lk".$_FILES['file']['tmp_name'];	// 
	
	//$путь_к_фото = "https://dashboard.heroku.com/apps/naherokubot/app/web".$_FILES['file']['tmp_name'];	
	

	// Подключение к Амазон
/*	$credentials = new Aws\Credentials\Credentials($aws_key_id, $aws_secret_key);
		
	$s3 = new Aws\S3\S3Client([
		'credentials' => $credentials, 
		'version'  => 'latest',
		'region'   => $aws_region
	]);
*/
	
	// поиск уникального номера файла (uniqid)
/*	$запрос = "SELECT id_zakaz FROM {$table_market} WHERE id_client='7' AND username='{$логин}' AND status=''";		
		
	if ($результат = $mysqli->query($запрос)) {		
		if ($результат->num_rows == 1) {		
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);			
			$uniqid = $результМассив[0]['id_zakaz'];
			if ($uniqid) {
				
				$key = "temp{$uniqid}.jpg"; //{$логин}-
				
				$result = $s3->deleteObjects([
					'Bucket' => $aws_bucket,			
					'Delete' => [
						'Objects' => [
							[
								'Key' => $key,						
							],            
						],				
					],
				]);
				
				if ($result['@metadata']['statusCode'] == '200') {
					$bot->sendMessage($master, "Старый Файл {$key} удалён с Амазон");
				}else {
					echo "Чего то не получается удалить лот {$key} из Amazon";	
					//exit;
				}
				
			}
		}		
	}
*/		
/* 	$uniqid = uniqid();	

	
	$key = "temp{$uniqid}.jpg";

	$file = file_get_contents($путь_к_фото);
	  
	$upload = $s3->putObject([
		'Bucket' => $aws_bucket,
		'Key'    => $key, 
		'Body'   => $file,	
		'ACL'    => 'public-read'
	]);	
*/


	$upload = $imgBB->upload($путь_к_фото);	
	

	if(!$upload) {
		echo "Не смог загрузить файл на imgBB";	
		echo "<br>".$путь_к_фото;		
		/*
		echo "<br><br>SERVER_SIGNATURE";
		echo "<br>".$_SERVER['SERVER_SIGNATURE'];
		
		echo "<br><br>PATH_TRANSLATED";
		echo "<br>".$_SERVER['PATH_TRANSLATED'];
		
		echo "<br><br>REQUEST_URI";
		echo "<br>".$_SERVER['REQUEST_URI'];
		
		echo "<br><br>HTTP_REFERER";
		echo "<br>".$_SERVER['HTTP_REFERER'];
		*/
		/*
		echo "<br><br>SERVER_ADDR";
		echo "<br>".$_SERVER['SERVER_ADDR'];
		
		echo "<br><br>SERVER_PROTOCOL";
		echo "<br>".$_SERVER['SERVER_PROTOCOL'];
		
		echo "<br><br>REQUEST_METHOD";
		echo "<br>".$_SERVER['REQUEST_METHOD'];
		
		echo "<br><br>SERVER_ADMIN";
		echo "<br>".$_SERVER['SERVER_ADMIN'];
		*/
		/*
		echo "<br><br>SERVER_SOFTWARE";
		echo "<br>".$_SERVER['SERVER_SOFTWARE'];
		
		echo "<br><br>HTTP_HOST";
		echo "<br>".$_SERVER['HTTP_HOST'];
		
		echo "<br><br>ORIG_PATH_INFO";
		echo "<br>".$_SERVER['ORIG_PATH_INFO'];
		
		echo "<br><br>PATH_INFO";
		echo "<br>".$_SERVER['PATH_INFO'];
		*/
		
		// одно и тоже, ЭТО 
		//echo "<br>".__FILE__;
		// и ЭТО
		//echo "<br>".$_SERVER['SCRIPT_FILENAME'];
		
		// в данном случае выдаст /app/web
		//echo "<br>".$_SERVER['DOCUMENT_ROOT'];
		
		exit;
	}else {		
		//$ссылка_на_фото = "https://{$aws_bucket}.s3.{$aws_region}.amazonaws.com/" . $key;
		$ссылка_на_фото = $upload['url'];	
		
		$bot->sendMessage($master, "Файл загружен на imgBB");
		
		$связь = _дай_связь($логин);
		
		if ($_POST['currency']) $валюта = $_POST['currency']." / PZM";
		else $валюта = "PZM";
		
		$время = time();
		
		$query = "DELETE FROM {$table_market} WHERE id_client='7' AND username='{$логин}' AND status=''";		
		if ($mysqli->query($query)) {			
			$query = "INSERT INTO {$table_market} (
			  `id_client`, `id_zakaz`, `kuplu_prodam`, `nazvanie`, `url_nazv`, `valuta`, 
			  `gorod`, `username`, `doverie`, `otdel`, `format_file`, `file_id`, `url_podrobno`, 
			  `status`, `podrobno`, `url_tgraph`, `foto_album`, `url_info_bot`, `date`
			) VALUES (
			  '7', '', '{$_POST['hesh_pk']}', '{$_POST['name']}', '{$_POST['link_name']}', '{$валюта}', '{$_POST['hesh_city']}', '{$логин}', '0', '{$_POST['hesh_kateg']}', 'фото', '', '', '', '{$_POST['opisanie']}', '{$ссылка_на_фото}', '', '{$связь}', '{$время}'
			)";							
			$result = $mysqli->query($query);			
			if (!$result) {
				echo "Не смог сделать запись в таблицу  (sozdanie-save_zakaz.php)";	
				exit;
			}else {
				_отправка_лота_админам_с_сайта(); 
			}
		}else {
			echo "Не смог удалить запись в таблице (sozdanie-save_zakaz.php)";	
			exit;
		}

		
		echo "Заявка отправлена РАЙминистрации.<br><br>";
		echo "Сообщение о решении будет отправленно Вам на email.<br><br>";
		echo "Все вопросы в <a href='https://teleg.link/Prizm_market_supportbot'>тех.поддержку.</a>";
	
	
		$array = [
			'login'   => $логин,
			'file' => $ссылка_на_фото
		];	
		
		if ($tester == 'да') $array = array_merge($array, [ 'tester' => $tester ]);
		 
		$ch = curl_init('http://f0430377.xsph.ru');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $array); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		$html = curl_exec($ch);
		curl_close($ch);	
		 
		//echo $html;
	
	}


} // конец

?>
