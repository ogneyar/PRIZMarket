<article id="repeat_delete">
	<form action='/site_pzm/lk/zayavki.php' method='post'>		
		<input type='hidden' name='id_lota' id='id_lota' value='<?=$_POST['id_lota'];?>'>

		<h4><br>
		<label>Вы уверены что хотите удалить лот <?=$_POST['id_lota'];?>?</label><br><br>
		<input type='submit' class='button' name='done' id='done'  value='Да'>
		<input type='submit' class='button' name='done' id='none'  value='Нет'>
		</h4>
	</form>
</article>