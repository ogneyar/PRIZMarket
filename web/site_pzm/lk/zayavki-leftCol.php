<?php 
include_once 'zayavki_pzmarket.php';

// данные из файла zayavki_pzmarket.php
if (is_array($лот)) {
?>

	<article id="lk_z">
	<?php
	foreach($лот as $публикация) {
		echo $публикация;
	}	
	?>
	<br><hr><br>
	</article>

<?php 
}else {
?>

	<article id="lk">
		<?=$лот;?>
	</article>
	
<?php 
}
?>