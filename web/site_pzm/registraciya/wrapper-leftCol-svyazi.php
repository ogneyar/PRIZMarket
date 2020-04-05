<article id="registr">
		<br>
		<p>
		<?if ($для_связи == 'Telegram') {?>
			<label>Введите Ваш юзернейм (@username):<br></label>
		<?}elseif ($для_связи == 'Whatsup') {?>
			<label>Введите номер Whatsup (+7(777)777-77-77):<br></label>
		<?}elseif ($для_связи == 'Wiber') {?>
			<label>Введите номер Wiber (+5(555)555-55-55):<br></label>
		<?}?>
			<input type="text" name="number" id="number" size="15" maxlength="20">
		</p>
		
		<p>
			<label id="warning"><br></label>
			<input type="button" name="done_svyazi" id="done_svyazi" value="Ввод">
		</p>
		<br><br>
</article>