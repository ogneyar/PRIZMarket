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
<label id="client"></label>