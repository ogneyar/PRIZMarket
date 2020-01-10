<?php	

$otrad = '298466355';
// Группа администрирования бота (Админка)
$admin_group = '-1001311775764';
// Группа для тестирования бота (Тестрование Ботов)
$admin_group_test = '-362469306'; 
// Мастер это Я
$master='351009636';
	
$token = '983003157:AAFT2RsLpFdKLjb7qeo12t8EPDus6-TB6YI';
$tg = new \TelegramBot\Api\BotApi($token);
	
$mysqli = new mysqli($host, $username, $password, $dbname);

// проверка подключения 
if (mysqli_connect_errno()) {
	$tg->sendMessage($master, 'Чёт не выходит подключиться к MySQL');	
	exit('ok');
}
	
$query = "SELECT * FROM pzmarkt"; 
$result = $mysqli->query($query);
	
$i = $result->num_rows;

if($i>0) $arrS = $result->fetch_all();		
else exit('ok');	
		
$a=1;
//echo "<table class='div'><tr>";
echo "<div  class='div'>";
while ($a<3){
	//echo "<td>";
	
	echo "<div class='div3'>";
	if($i>0){
	
		$i--;		
		
		$format=$arrS[$i][2];
		while (($format=='video')&&($i>0)) {
			$i--;
			$format=$arrS[$i][2];
		}	
		
		$id_lota=$arrS[$i][0];	
		$otdel=$arrS[$i][1];
		
		$file_id=$arrS[$i][3];
		$url=$arrS[$i][4];
		$caption1=$arrS[$i][5];
		$caption2=$arrS[$i][6];
		$caption3=$arrS[$i][7];
		$caption4=$arrS[$i][8];
		$caption5=$arrS[$i][9];
		$doverie=$arrS[$i][10];
		$podrobno_url=$arrS[$i][11];
		
		
		$url = str_replace("t.me", "teleg.link", $url);
		
		
		$caption5_bezSobaki = substr(strrchr($caption5, "@"), 1);
		$caption5_url="https://teleg.link/{$caption5_bezSobaki}";		

					
		$caption="<p>{$caption1}</p><p>{$otdel}</p><p><a href={$url}>{$caption2}</a></p>".
			"<p>{$caption3}</p><p>{$caption4}</p><p><a href={$caption5_url}>{$caption5}</a></p>";			
						
		
		$file = $tg->getFile($file_id);
		
		$file_path = $file->getFilePath();
		

		$adress_file = "https://api.telegram.org/file/bot{$token}/{$file_path}";
		
		if ($format=='photo'){		
			echo "<img src={$adress_file} alt='Изображение лота' align='middle'>". 
					// width=auto height='500'    
				$caption;
		}
		
	}
	echo "</div>";
	
	//echo "</td>";	
	$a++;	
}	
//echo "</tr></table>";
echo "</div>";
	

	// закрываем подключение 
	$mysqli->close();		

	

?>		