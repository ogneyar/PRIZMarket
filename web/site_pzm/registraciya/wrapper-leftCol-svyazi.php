<article id="svyazi">
<!--	<form action="/site_pzm/registraciya/index.php?registration=2&login=" method="get"> -->
		<br>
		<p>
		<?if ($для_связи == 'telegram') {?>
			<label>Введите логин:<br></label>
		<?}elseif (($для_связи == 'whatsup') || ($для_связи == 'wiber')) {?>
			<label>Введите номер:<br></label>
		<?}?>
			<input type="text" name="number" id="number" size="15" maxlength="20">
		</p>
		
		<p>
			<label id="warning"><br></label>
			<input type="button" name="done_svyazi" id="done_svyazi" value="Ввод">
		</p>
		<br><br>
<!--	</form> -->
</article>