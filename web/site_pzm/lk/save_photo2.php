<?
if ($_FILES['file']) echo "<br><br>Файл: ".$_FILES['file']['tmp_name'];
if ($_POST['file']) echo "<br><br>ПОСТ: ".$_POST['file'];
?>