<article id="podtverjdenie">		
<h4>
	<br>	
	<label>&nbsp;&nbsp;<b><?=$логин;?></b>, для окончания регистрации выберите один из вариантов, как клиенты смогут с Вами связаться!</label>
	<br><br><br>
	
	<form action="/site_pzm/registraciya/index-podtverjdenie-svyazi.php" align="center">
	
		<input type="hidden" name="login" value="<?=$логин;?>">
		
		<input type="submit" class="button" name="svyazi" id="telegram"  value="Telegram">
		&nbsp;&nbsp;
		<input type="submit" class="button" name="svyazi" id="whatsapp"  value="WhatsApp">
		<!--&nbsp;&nbsp;
		<input type="submit" class="button" name="svyazi" id="wiber"  value="Wiber">-->
	</form>	
</h4>
</article>		
