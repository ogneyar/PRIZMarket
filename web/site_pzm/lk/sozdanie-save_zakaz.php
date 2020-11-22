<?php
$логин = "";
if (isset($_COOKIE['login'])) $логин = $_COOKIE['login'];
include_once '../../a_conect.php';

//exit('ok');

include_once '../../BiblaAvtoZakaz/Functions_site.php';

$table_market = 'avtozakaz_pzmarket';

$mysqli = new mysqli($host, $username, $password, $dbname);
if (mysqli_connect_errno()) {
	echo "Чёт не выходит подключиться к MySQL";	
	exit;
}else { 
	
	$связь = _дай_связь_сайт($логин);
		
	if (isset($_POST['currency'])) $валюта = $_POST['currency'];
		
	if (isset($_POST['hesh_city'])) $hesh_city = $_POST['hesh_city'];
	$hesh_city = str_replace(' ', '', $hesh_city);
	$hesh_city = str_replace('#', ' #', $hesh_city);

	if (isset($_POST['hesh_pk'])) $hesh_pk = $_POST['hesh_pk'];
	if (isset($_POST['name'])) $name = $_POST['name'];
	if (isset($_POST['link_name'])) $link_name = $_POST['link_name'];
	if (isset($_POST['hesh_kateg'])) $hesh_kateg = $_POST['hesh_kateg'];
	if (isset($_POST['opisanie'])) $opisanie = $_POST['opisanie'];
		
	$query = "DELETE FROM {$table_market} WHERE id_client='7' AND username='{$логин}' AND status=''";		
	if ($mysqli->query($query)) {			
		$query = "INSERT INTO {$table_market} (
			  `id_client`, `id_zakaz`, `kuplu_prodam`, `nazvanie`, `url_nazv`, `valuta`, 
			  `gorod`, `username`, `doverie`, `otdel`, `format_file`, `file_id`, `url_podrobno`, 
			  `status`, `podrobno`, `url_tgraph`, `foto_album`, `url_info_bot`, `date`
		) VALUES (
			  '7', '', '{$hesh_pk}', '{$name}', '{$link_name}', '{$валюта}', '{$hesh_city}', '{$логин}', '0', '{$hesh_kateg}', 'фото', '', '', '', '{$opisanie}', '', '', '{$связь}', '0'
		)";							
		$result = $mysqli->query($query);			
		if (!$result) {
			echo "Не смог сделать запись в таблицу  (sozdanie-save_zakaz.php)";	
			exit;
		}
	}else {
		echo "Не смог удалить запись в таблице (sozdanie-save_zakaz.php)";	
		exit;
	}		

 	if ($tester == 'да') {
?>
	<form action="http://f0430377.xsph.ru/saveimage.php" method="post" enctype="multipart/form-data">
		<input type='hidden' name='tester' value='да'>
<?php 
	}else {
?>
	<form action="http://f0430377.xsph.ru/saveimage.php" method="post" enctype="multipart/form-data">
<?php 
}
?>
		<input type='hidden' name='login' value='<?=$логин;?>'>
			
		<label>Загрузите фото: <font color="red">*</font><br></label>
		<input type="file" name="file" id="file" accept=".jpeg, .jpg, .png">	
		<br><br>
		<input type="submit" class="button" name="dalee" id="dalee" value="Далее">
	</form>
<?php
} // конец
?>

<script>
	$(document).ready (function (){
		$("#dalee").click (function ( event ){
			event.stopPropagation(); // остановка всех текущих JS событий
			event.preventDefault();  // остановка дефолтного события

			$('#fon_load').css({
				'opacity':'0.6',
				'visibility':'visible'
			});
		});
	});
</script>
