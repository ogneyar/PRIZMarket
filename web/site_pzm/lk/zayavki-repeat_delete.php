<?php
if (!$_COOKIE['login']) header('Location: /site_pzm/vhod/index.php');
if (!$_COOKIE['token']) header('Location: /site_pzm/vhod/index.php');
$логин = $_COOKIE['login'];
$токен = $_COOKIE['token'];
include_once '../../a_conect.php';
//include_once 'lk_pzmarket.php';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title>Ваши заявки на PRIZMarket!</title>
	<?include_once '../site_files/head.php';?>	
	
	<script>
		$(document).ready (function (){
			$("#done").click (function (){				
				var login = $("#login").val ();
				var token = $("#token").val ();	
				var id_lota = $("#id_lota").val ();
				
				$.ajax ({
					url: '/site_pzm/lk/zayavki-repeat_delete-delete.php',
					type: 'POST',
					cache: false,
					data: {'login': login, 'token': token, 'id_lota': id_lota},
					dataType: 'html',
					success: function (data) {
						$('#repeat_delete').html ("<br><h4>" + data + "</h4>");
						$('#repeat_delete').show ();						
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
		<?include_once 'index-lk_menu.php';?>
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
			<?include_once 'zayavki-repeat_delete-leftCol.php';?>
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
