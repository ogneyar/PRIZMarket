<?
echo $_POST['file'];
if ($_FILES['filet']) echo "<br><br>Файл: ".$_FILES['filet']['tmp_name'];
if ($_POST['filet']) echo "<br><br>ПОСТ: ".$_POST['filet'];
?>