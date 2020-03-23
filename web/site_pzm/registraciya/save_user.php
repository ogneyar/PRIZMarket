<?
include_once '../../a_conect.php';
include_once '../../myBotApi/Bot.php';
//exit('ok');
$token = $tokenMARKET;
$bot = new Bot($token);
$id_bota = strstr($token, ':', true);	
include '../../myBotApi/Variables.php';
$admin_group = $admin_group_market;

//if ($_POST['email']) $bot->sendMessage($admin_group, $_POST['email']);

$mysqli = new mysqli($host, $username, $password, $dbname);
// проверка подключения 
if (mysqli_connect_errno()) {
	$bot->sendMessage($admin_group, 'Чёт не выходит подключиться к MySQL');	
	exit('ok');
}


$логин = htmlspecialchars($_POST['login']);
$пароль = htmlspecialchars($_POST['password']);
$емаил = htmlspecialchars($_POST['email']);

//удаляем лишние пробелы
$логин = trim($логин);
$пароль = trim($пароль);
$емаил = trim($емаил);

$пароль_md5 = md5($пароль);

$путь_сервера = "https://" . $_SERVER['SERVER_NAME']."/site_pzm/registraciya/index.php";

$ссылка_подтверждения = $путь_сервера . "?registration=1&login=" . $логин;

$время = time();

$запрос = "INSERT INTO `site_users` (
		  `login`,
		  `password`,
		  `email`,
		  `podtverjdenie`,
		  `vremya`
	) VALUES ('{$логин}', '{$пароль}', '{$емаил}', 'null', {$время})"; 
$результат = $mysqli->query($запрос);

// закрываем подключение 
$mysqli->close();

if (!$результат) {
	$bot->sendMessage($admin_group, 'Не смог добавить клиента `site_users`.. (работа сайта)');	
	exit('ok');
}

include 'phpmailer.php';

?>