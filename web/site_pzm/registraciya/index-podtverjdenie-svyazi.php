<?
$json_login = json_encode($_GET['login']);

if ($_GET['svyazi'] == 'Telegram') {
	$для_связи = "Telegram";
}elseif ($_GET['svyazi'] == 'WhatsApp') {
	$для_связи = "WhatsApp";
}elseif ($_GET['svyazi'] == 'Wiber') {
	$для_связи = "Wiber";
}
$json_svyazi = json_encode($для_связи);
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
				$('#warning').html (' ' + "<br>");
				$('#warning').show ();
				var number = $("#number").val ();				
				var fail = "";
				var login = <?=$json_login; ?>;
				var svyazi = <?=$json_svyazi; ?>;
				
				if (svyazi == 'Telegram') {
					if(number.indexOf('@')+1 > 0 ) {
						fail = "";
					}else fail = "Необходим символ '@'";
				}else {
					if (number.length < 11) fail = "Не менее 11 символов";
				}
				
				if (fail != "") {
					$('#warning').html (fail  + "<br>");
					$('#warning').show ();
					return false;
				}else {
					/*$("#done_svyazi").attr('disabled', true);*/
					$('#svyazi').html ("<br><h4>Ожидайте..</h4>");
					$('#svyazi').show ();		
				}
				
				$.ajax ({
					url: '/site_pzm/registraciya/index-podtverjdenie-svyazi-save.php',
					type: 'POST',
					cache: false,
					data: {'login': login, 'svyazi': svyazi, 'svyazi_data': number},
					dataType: 'html',
					success: function (data) {
						$('#svyazi').html ("<br><h4>" + data + "</h4>");
						$('#svyazi').show ();						
					}
				});
				
			});
		});		
	</script>
	
</head>
<body>
	<header>
		<?include_once '../site_files/header.php';?>
	</header>
	<div id="lk_menu">
		<?include_once '../lk/index-lk_menu.php';?>		
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
			<?include_once 'index-podtverjdenie-svyazi-leftCol.php';?>
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
