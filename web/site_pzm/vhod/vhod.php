<?php
if ($_POST['login']) {
	
	setcookie("login", $_POST['login'], time()+300, '/');
	
	echo "Добро пожаловать ". $_COOKIE['login'] ."!";	
	
}else echo "Не получилось войти(";
?>