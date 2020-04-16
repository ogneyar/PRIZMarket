<article id="lk">
	<h4>
		<!--<form action="save_zakaz.php" method="post" enctype="multipart/form-data">-->
		<br>		
			<input type="hidden" name="login" value="<?=$_COOKIE['login'];?>">
			
			<label>Выберите действие:<br></label>			
			<select name="hesh_pk" id="hesh_pk">			
				<option value="#продаю" id="hesh_p" selected>#продаю</option>
				<option value="#куплю" id="hesh_k">#куплю</option>
			</select>
		<br><br>		
			<label>Введите название товара/услуги:<br></label>
			<input type="text" placeholder="Название" name="name" id="name" size="15" maxlength="100">
		<br><br>		
			<label>Ссылка вшитая в названии:<br></label>
			<input type="text" placeholder="Ссылка, если нужна." name="link_name" id="link_name" size="20" maxlength="200">
		<br><br>		
			<label>Категория товара/услуги:<br></label>
			<input type="text" placeholder="Категория" name="hesh_kateg" id="hesh_kateg" size="15" maxlength="50">
		<br><br>
			<label>Валюта, помимо PRIZM:<br></label>
			<input type="text" placeholder="Валютебл" name="currency" id="currency" size="15" maxlength="100">
		<br><br>
			<label>Хештеги местонахождения:<br></label>
			<input type="text" placeholder="Хештеги города" name="hesh_city" id="hesh_city" size="15" maxlength="100">
		<br><br>
		
			<label>Загрузите фото:<br></label>
			<input type="file" name="file" id="file" accept=".jpg, .jpeg, .png">	
		<br><br>
		
			<label>Введите описание:<br></label>
			<textarea name="opisanie" id="opisanie" maxlength="500" rows="7" cols="25"></textarea>
		<br><br>
		
		<!--<input type="file" id="files" name="files" multiple accept="image/*"> ДОП ФОТО-->
		
			<label id="warning"><br></label>
			<input type="submit" class="button" name="done" id="done" value="Применить">
		<br>
		<!--</form>-->
	</h4>
</article>