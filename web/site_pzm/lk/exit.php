<?
setcookie("login", "", time()+10, '/');
header("Location: /index.php");
exit;
?>
