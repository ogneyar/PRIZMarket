<article id="podtverjdenie">		
	<br>
	<p>
		<label>Для окончания регистрации <?$_GET['login'];?> выберите один из вариантов как клиенты смогут с Вами связаться!</label>
		<br><br>
	</p>
	<br>
	<p>
	<form action="/site_pzm/registraciya/input_svyazi.php" align="center">
	
		<input type="hidden" name="login" value="<?=$логин;?>">
		
		<input type="submit" class="button" name="svyazi" id="telegram"  value="Telegram">
		&nbsp;&nbsp;
		<input type="submit" class="button" name="svyazi" id="whatsapp"  value="WhatsApp">
		&nbsp;&nbsp;
		<input type="submit" class="button" name="svyazi" id="wiber"  value="Wiber">
	</form>
	</p>
</article>		
