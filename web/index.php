<?php
include_once '../vendor/autoload.php';	
include_once 'a_conect.php';
include_once 'site_pzm/pzmarket.php';
?>
<!DOCTYPE html>
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />	
	<title>PRIZMarket!</title>
	<?include_once 'site_pzm/site_files/head.php';?>
	
	<style type="text/css">
		@media (min-width: 700px) {
		nav a:first-child, nav#fixed a:first-child {
			border-top: 5px solid rgba(255,235,59);
		}} 
	</style>	
	
	<script>
		$(document).ready (function (){
			$("#dalee").click (function (){				
				$('#escho').html (' ' + "<br>");
				$('#escho').show ();
				
				//var last_lot = $("#last_lot").val ();
				
				var last_lot = <?=$json_last_lot; ?>;
				
				$.ajax ({
					url: '/site_pzm/pzmarket.php',
					type: 'POST',
					cache: false,
					data: {'last_lot': last_lot},
					dataType: 'html',
					success: function (data) {
						$('#escho').html ( data );
						$('#escho').show ();						
					}
				});
				
			});			
			
		});		
	</script>
	
</head>
<body>
	<header>
		<?include_once 'site_pzm/site_files/header.php';?>
	</header>
	<div id="lk_menu">
		<?include_once 'site_pzm/lk/index-lk_menu.php';?>		
	</div>
	<nav>
		<?include_once 'site_pzm/site_files/nav.php';?>
	</nav>
	<div id="slideMenu">Моё)</div>
	<div id="wrapper">
		<div id="TopCol">		
			<?include_once 'site_pzm/site_files/wrapper-topCol.php';?>
		</div>
		<div id="leftCol">		
			<?include_once 'site_pzm/site_files/wrapper-leftCol.php';?>
		</div>
		<div id="rightCol">
			<?include_once 'site_pzm/site_files/wrapper-rightCol.php';?>
		</div>
	</div>
	<footer>
		<?include_once 'site_pzm/site_files/footer.php';?>
	</footer>
</body>
</html>
