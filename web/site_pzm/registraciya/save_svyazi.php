<?
include_once '../../a_conect.php';
include_once '../../myBotApi/Bot.php';
//exit('ok');
$token = $tokenSite;
$bot = new Bot($token);
$id_bota = strstr($token, ':', true);	
include '../../myBotApi/Variables.php';
$admin_group = $admin_group_Site;

$mysqli = new mysqli($host, $username, $password, $dbname);
// проверка подключения 
if (mysqli_connect_errno()) {
	$bot->sendMessage($admin_group, 'Чёт не выходит подключиться к MySQL');	
	exit('ok');
}

$логин = htmlspecialchars($_POST['login']);
$связь = htmlspecialchars($_POST['svyazi']);
$данные_связи = htmlspecialchars($_POST['svyazi_data']);

$bot->sendMessage($admin_group, $логин);	


//удаляем лишние пробелы
$логин = trim($логин);
$связь = trim($связь);
$данные_связи = trim($данные_связи);
$данные_связи = str_replace('(', '', $данные_связи);
$данные_связи = str_replace(')', '', $данные_связи);	
$данные_связи = str_replace('-', '', $данные_связи);

$запрос = "UPDATE `site_users` SET svyazi='{$связь}', svyazi_data='{$данные_связи}' WHERE login='{$логин}'"; 

$результат = $mysqli->query($запрос);


if (!$результат) {
	$bot->sendMessage($admin_group, 'Не смог добавить данные для связи с клиентом `site_svyazi`.. (работа сайта)');	
	$mysqli->close();
	exit('ok');
}

$запрос = "SELECT email FROM `site_users` WHERE login={$логин}"; 

$результат = $mysqli->query($запрос);

if ($результат->num_rows > 0) {
	$результМассив = $результат->fetch_all(MYSQLI_ASSOC);
	$емаил = $результМассив[0]['email'];
}


// закрываем подключение 
$mysqli->close();

$body = "&nbsp;&nbsp;Здравствуйте <b>{$логин}</b>, это письмо отправлено так как Вы успешно добавили данные для связи клиентов с Вами! Это информационное письмо, на него не нужно отвечать.";

$ответное_сообщение = "<b>Данные внесены!</b><br><br>Нажмите ВХОД в правом верхнем углу экрана.<br><br>Введите свой логин и пароль.";


include 'phpmailer.php';

?>