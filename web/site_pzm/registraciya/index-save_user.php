<?
include_once '../../a_conect.php';
include_once '../../myBotApi/Bot.php';
//exit('ok');
$token = $tokenSite;
$bot = new Bot($token);
$id_bota = strstr($token, ':', true);	
include '../../myBotApi/Variables.php';
$admin_group = $admin_group_Site;

//if ($_POST['email']) $bot->sendMessage($admin_group, $_POST['email']);

if (!$_POST['login'] || !$_POST['password'] || !$_POST['email']) {

	echo "<center><br><br><br><br><br>Нет переданных данных.<br><br><br><br></center>";	
	exit;

}

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

$uniqid = uniqid();

$пароль_md5 = md5($пароль);

$путь_сервера = "https://" . $_SERVER['SERVER_NAME']."/site_pzm/registraciya/index.php";

$ссылка_подтверждения = $путь_сервера . "?login={$логин}&token={$uniqid}";

$время = time();

$запрос = "INSERT INTO `site_users` (
		  `login`,
		  `password`,
		  `email`,
		  `podtverjdenie`,
		  `vremya`,
		  `svyazi`,
		  `svyazi_data`,
		  `token`
	) VALUES ('{$логин}', '{$пароль}', '{$емаил}', 'null', '{$время}', 'null', 'null', '{$uniqid}')"; 
$результат = $mysqli->query($запрос);

// закрываем подключение 
$mysqli->close();

if (!$результат) {
	$bot->sendMessage($admin_group, 'Не смог добавить клиента `site_users`.. (работа сайта)');	
	exit('ok');
}

$body = "&nbsp;&nbsp;Здравствуйте <b>{$логин}</b>, это письмо отправлено Вам для продолжения регистрации на сайте <span>PRIZMarket</span>.<br><br>&nbsp;&nbsp;На это письмо отвечать не нужно. Просто перейдите по ссылке ниже.<br><br>&nbsp;&nbsp;<a href='{$ссылка_подтверждения}'>{$ссылка_подтверждения}</a>";

$ответное_сообщение = "<b>Сообщение отправлено!</b><br><br>Проверьте почту, перейдите по присланной Вам ссылке для окончания регистрации. Если письмо не пришло проверьте папку СПАМ.<br><br>После окончания регистрации зайдите в личный кабинет.";

include 'phpmailer.php';

?>