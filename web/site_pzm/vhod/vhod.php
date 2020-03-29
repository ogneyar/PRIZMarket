<?php
if ($_POST['login']) {
	
	setcookie("login", $_POST['login'], time()+60*60*24*365, '/');
	
	echo "<p><label>Добро пожаловать ". $_POST['login'] ."!</label></p>";	
	
}else echo "Не получилось войти(";
?>
