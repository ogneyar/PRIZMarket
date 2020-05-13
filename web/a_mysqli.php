<?php
include_once 'a_conect.php';

$mysqli = new mysqli($host, $username, $password, $dbname);
// проверка подключения 
if (mysqli_connect_errno()) {	
	echo "Ошибка! Нет подключения к БД.\n";	 
	$mysqli->close();		
	exit('ok');  	
}
?>
