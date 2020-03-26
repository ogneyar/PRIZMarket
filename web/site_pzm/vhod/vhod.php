<?php
if ($_POST['login']) {
	
	setcookie("login", $_POST['login'], time()+30, '/');

	if ($_COOKIE['login']) echo "Добро пожаловать ". $_COOKIE['login'] ."!";
	else echo "Не получилось войти(";
	
}
?>