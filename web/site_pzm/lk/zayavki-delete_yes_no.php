<article id="repeat_delete">
	<form action='/site_pzm/lk/zayavki.php' method='post'>		
		<input type='hidden' name='id_lota' id='id_lota' value='<?=$номер_лота;?>'>

		<h4><br>
		<label>Вы уверены что хотите удалить лот <?=$номер_лота;?>?</label><br><br>
		<input type='button' class='button' name='done' id='done'  value='Да'>
		<input type='submit' class='button' name='done' id='none'  value='Нет'>
		</h4>
	</form>
</article>