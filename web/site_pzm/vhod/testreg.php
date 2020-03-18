<?php
session_start();
if (isset($_POST['login'])) { 
	$login = $_POST['login']; 
	if ($login == '') { 
		unset($login);
	} 
} //заносим введенный пользователем логин в переменную $login, если он пустой, то уничтожаем переменную
if (isset($_POST['password'])) { 
	$password=$_POST['password']; 
	if ($password =='') { 
		unset($password);
	} 
} //заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную
if (empty($login) or empty($password)) {
	//если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
    exit ("Вы ввели не всю информацию, вернитесь назад и заполните все поля!");
}
//если логин и пароль введены,то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
$login = stripslashes($login);
$login = htmlspecialchars($login);
$password = stripslashes($password);
$password = htmlspecialchars($password);
//удаляем лишние пробелы
$login = trim($login);
$password = trim($password);
// подключаемся к базе
    
include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 
 
$result = mysql_query("SELECT * FROM users WHERE login='$login'",$db); //извлекаем из базы все данные о пользователе с введенным логином
$myrow = mysql_fetch_array($result);
if (empty($myrow['password'])) {
    //если пользователя с введенным логином не существует
    exit ("Извините, введённый вами login или пароль неверный.");
}else {
    //если существует, то сверяем пароли
    if ($myrow['password'] == $password) {
		//если пароли совпадают, то запускаем пользователю сессию! Можете его поздравить, он вошел!
		$_SESSION['login'] = $myrow['login']; 
		$_SESSION['id'] = $myrow['id'];//эти данные очень часто используются, вот их и будет "носить с собой" вошедший пользователь
		echo "Вы успешно вошли на сайт! <a href='index.php'>Главная страница</a>";
    }else {
		//если пароли не сошлись
		exit ("Извините, введённый вами login или пароль неверный.");
	}
}
?>