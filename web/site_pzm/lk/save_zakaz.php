<?
$логин = $_COOKIE['login'];
echo $логин . ", выберите фото";


?>
<form action="/site_pzm/lk/sozdanie.php" method="post" enctype="multipart/form-data">
	<br><br>
	<input type="hidden" name="photo" value="1">
	<!--<label>Загрузите фото:<br></label>-->
	<input type="file" name="file" id="file">	
	<br><br><br>
	<input type="submit" class="button" name="done" id="done" value="Применить">
</form>