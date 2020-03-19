<?
$логин = htmlspecialchars($_POST['login']);
$пароль = htmlspecialchars($_POST['password']);
$емаил = htmlspecialchars($_POST['email']);

//удаляем лишние пробелы
$логин = trim($логин);
$пароль = trim($пароль);
$емаил = trim($емаил);

include '../phpmailer.php';
?>