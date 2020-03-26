<?php
if ($_POST['login']) {
	
	setcookie("login", $_POST['login'], time()+60*60*24*365, '/');
	
	echo "Добро пожаловать ". $_POST['login'] ."!";	
	
}else echo "Не получилось войти(";
?>
