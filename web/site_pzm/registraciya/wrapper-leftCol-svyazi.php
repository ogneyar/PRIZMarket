<article id="registr">
		<br>
		<p>
		<?if ($для_связи == 'Telegram') {?>
			<label>Введите логин:<br></label>
		<?}elseif (($для_связи == 'Whatsup') || ($для_связи == 'Wiber')) {?>
			<label>Введите номер:<br></label>
		<?}?>
			<input type="text" name="number" id="number" size="15" maxlength="20">
		</p>
		
		<p>
			<label id="warning"><br></label>
			<input type="button" name="done_svyazi" id="done_svyazi" value="Ввод">
		</p>
		<br><br>
</article>