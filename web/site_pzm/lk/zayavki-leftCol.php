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

<!--<article id="lk">
	<article id="zayavki">
		<a href='' title=''>
			<img src="/site_pzm/img/art/PRIZM.png" />
		</a>
		<h4>Здесь может быть Ваша реклама!</h4>
	</article>
</article>-->

<!--<article id="lk">
		<br>
		<h4>
			<label>Пусто тута)<br></label>		
		</h4>
</article>-->