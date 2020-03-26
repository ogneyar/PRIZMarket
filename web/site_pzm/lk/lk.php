<?
$вывод = "";
if ($_COOKIE['login']) $вывод = $_COOKIE['login'];

$login_json = json_encode($вывод);
?>
<script>
	$(document).ready (function (){				
		$('#client').html (<?echo $login_json;?>);
		$('#client').show ();
	});
</script>

<ul class="lk_topmenu"><label id="client"></label>
	<li id="lk_mini-menu">
		<ul class="lk_submenu">	
			<li><a href="exit.php">Выход</a></li>			
		</ul>
</ul>