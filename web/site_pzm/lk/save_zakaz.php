<?

echo $_POST['login'].", выберите основное фото";



?>
<form action="save_photo.php" method="post">
	<br><br>
	<label>Загрузите фото:<br></label>
		<input type="file" name="file" id="file" accept=".jpg, .jpeg, .png">	
	<br><br>
	<input type="submit" class="button" name="done" id="done" value="Применить">
</form>