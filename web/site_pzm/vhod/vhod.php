<?php
setcookie("login", $_POST['login'], time()+20);

if ($_COOKIE['login']) echo "Добро пожаловать ". $_COOKIE['login'] ."!";
else echo "Не получилось войти(";

?>