<?php

setcookie("login", $_POST['логин']);

if ($_COOKIE['login']) echo "Добро пожаловать ". $_COOKIE['login'];

?>