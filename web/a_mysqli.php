<?php
include_once $_SERVER['HTTP_REFERER'].'a_conect.php';

$mysqli = new mysqli($host, $username, $password, $dbname);

if (mysqli_connect_errno()) {	
	echo "<br><br><br><br><br><center>Ошибка! Нет подключения к БД.<br></center>"; 		
	exit;  	
}
?>
