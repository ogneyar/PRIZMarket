<?php
setcookie("login", $_POST['login']);

if ($_COOKIE['login']) echo "Добро пожаловать ". $_COOKIE['login'];
else echo "Не вышло(";

?>