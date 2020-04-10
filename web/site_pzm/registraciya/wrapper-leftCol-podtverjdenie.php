<article id="podtverjdenie">		
<h4>
	<br>	
	<label>&nbsp;&nbsp;<b><?=$логин;?></b>, для окончания регистрации выберите один из возможных вариантов, каким образом клиенты смогут с Вами в дальнейшем связязываться!</label>
	<br><br>
	
	<form action="/site_pzm/registraciya/input_svyazi.php" align="center">
	
		<input type="hidden" name="login" value="<?=$логин;?>">
		
		<input type="submit" class="button" name="svyazi" id="telegram"  value="Telegram">
		&nbsp;&nbsp;
		<input type="submit" class="button" name="svyazi" id="whatsapp"  value="WhatsApp">
		&nbsp;&nbsp;
		<input type="submit" class="button" name="svyazi" id="wiber"  value="Wiber">
	</form>	
</h4>
</article>		
