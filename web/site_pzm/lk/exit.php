<?php
setcookie("login", "", time()+10, '/');
setcookie("token", "", time()+10, '/');
header("Location: /index.php");
exit;
?>
