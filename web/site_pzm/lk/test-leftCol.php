<article id="lk">
		<br>
		<h4>
			<br>		
			<input type="hidden" name="login" id="login" value="<?=$_COOKIE['login'];?>">
			
			<label>Введите чёнить: <br></label>
			<input type="text" placeholder="Введите чёнить..." name="name" id="name" size="15" maxlength="100">
		<br><br>				
			<label id="warning"><br></label>
			<input type="submit" class="button" name="done" id="done" value="Нажми">
		<br>
		</h4>
</article>

<?
/*	
	$array = [ 'login' => $логин, 'file' => $ссылка_на_фото ];		
	// инфа о том с какого сайта (тестового или оригинала) идёт посылка
	if ($tester == 'да') $array = array_merge($array, [ 'tester' => $tester ]);		
	// отправка madeLine фото для публикации её в телеге
	$ch = curl_init("http://f0430377.xsph.ru"."?".http_build_query($array));
	//curl_setopt($ch, CURLOPT_POST, 1);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($array)); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$html = curl_exec($ch);
	curl_close($ch);	
*/		
?>