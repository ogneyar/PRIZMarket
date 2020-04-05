<?
if ($_GET['svyazi'] == 'Telegram') {
	$для_связи = "Telegram";
}elseif ($_GET['svyazi'] == 'Whatsup') {
	$для_связи = "Whatsup";
}elseif ($_GET['svyazi'] == 'Wiber') {
	$для_связи = "Wiber";
}
$json = json_encode($для_связи);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />	
	<title>Ввод данных для связи с Вами!</title>
	<?include_once '../site_files/head.php';?>
	<style type="text/css"></style>
	
	<script>
		$(document).ready (function (){			
			$("#done_svyazi").click (function (){			
				$("#done_svyazi").attr('disabled', true);		
				$('#warning').html (' ' + "<br>");
				$('#warning').show ();
				var number = $("#number").val ();				
				var fail = "";				
				var svyazi = <?=$json; ?>;				
				
				if (number.length < 4) fail = "Логин не менее 4х символов";
				
				if (fail != "") {
					$('#warning').html (fail  + "<br>");
					$('#warning').show ();
					return false;
				}
				
			});
		});		
	</script>
	
</head>
<body>
	<header>
		<?include_once '../site_files/header.php';?>
	</header>
	<div id="lk_menu">
		<?include_once '../lk/lk.php';?>		
	</div>
	<nav>
		<?include_once '../site_files/nav.php';?>
	</nav>
	<div id="slideMenu">Моё детище, а не просто сайт!</div>
	<div id="wrapper">
		<div id="TopCol">		
			<?include_once '../site_files/wrapper-topCol.php';?>
		</div>
		<div id="leftCol">		
			<?include_once 'wrapper-leftCol-svyazi.php';?>
		</div>
		<div id="rightCol">
			<?include_once '../site_files/wrapper-rightCol.php';?>
		</div>
	</div>
	<footer>
		<?include_once '../site_files/footer.php';?>
	</footer>
</body>
</html>
