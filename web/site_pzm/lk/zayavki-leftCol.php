<? 
// данные из файла zayavki_pzmarket.php
if (is_array($лот)) {
?>
	<article id="lk_z">
	<?
	foreach($лот as $публикация) {
		echo $публикация;
	}	
	?>
	</article>
<?
}else {
?>
	<article id="lk">
		<?=$лот;?>
	</article>
<?
}
?>