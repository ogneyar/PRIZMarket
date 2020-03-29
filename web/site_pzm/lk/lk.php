<?
$вывод = "";
if ($_COOKIE['login']) $вывод = $_COOKIE['login'];

$login_json = json_encode($вывод);
?>
<script>
	$(document).ready (function (){		

                var login = <?=$login_json;?>;
                if (login != "") {
                        $('#contact').hide ();
		
		        $('#client').html (login);
	        	$('#client').show ();
                }else $('#lk').hide ();
	});
</script>

<ul class="lk_topmenu">
	<a href="/site_pzm/lk/exit.php"><label id="client"></label></a>
	<li id="lk_mini-menu">
		<ul class="lk_submenu">	
			<li><a href="exit.php">Выход</a></li>			
		</ul>
</ul>
