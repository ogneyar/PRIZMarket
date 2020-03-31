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
                }else $('#lk_menu').hide ();
	});
</script>