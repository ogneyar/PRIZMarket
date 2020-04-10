<article id="svyazi">
	<h4>
		<br>
		
		<?if ($для_связи == 'Telegram') {?>
			<label>Введите Ваш юзернейм (@username):<br></label>
		<?}elseif ($для_связи == 'WhatsApp') {?>
			<label>Введите номер WhatsApp (+7(777)777-77-77):<br></label>
		<?}elseif ($для_связи == 'Wiber') {?>
			<label>Введите номер Wiber (+5(555)555-55-55):<br></label>
		<?}?>
			<input type="text" name="number" id="number" size="15" maxlength="20">		
		<br><br>
			<label id="warning"><br></label>
			<input type="button" class="button" name="done_svyazi" id="done_svyazi" value="Ввод">
		<br>
	</h4>
</article>