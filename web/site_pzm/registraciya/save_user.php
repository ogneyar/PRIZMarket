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

$запрос = "SHOW TABLES"; 
$результат = $mysqli->query($запрос);
if ($результат)	{

	$bot->sendMessage($admin_group, "ДА");
	
/*	$количество = $результат->num_rows;	
	if($количество > 0) $массивРезульт = $результат->fetch_all(MYSQLI_ASSOC);		
	else throw new Exception('Таблица пуста.. (работа сайта)');	*/
}else $bot->sendMessage($admin_group, 'Не смог проверить таблицу `pzm`.. (работа сайта)');	

// закрываем подключение 
$mysqli->close();

$логин = htmlspecialchars($_POST['login']);
$пароль = htmlspecialchars($_POST['password']);
$емаил = htmlspecialchars($_POST['email']);

//удаляем лишние пробелы
$логин = trim($логин);
$пароль = trim($пароль);
$емаил = trim($емаил);

$пароль_md5 = md5($пароль);

$путь_сервера = "https://" . $_SERVER['SERVER_NAME']."/site_pzm/registraciya/index.php";

$ссылка_подтверждения = $путь_сервера . "?registration=1&login=" . $логин . "&pass=" . $пароль_md5;

include 'phpmailer.php';



?>