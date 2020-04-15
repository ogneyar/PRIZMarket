<?
if ($_FILES['file']) echo "Файл: ".$_FILES['file']['tmp_name'];
if ($_POST['file']) echo "ПОСТ: ".$_POST['file'];
?>