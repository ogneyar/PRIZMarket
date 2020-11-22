<article id="lk">
	<h4>
		<!--<form action="save_zakaz.php" method="post" enctype="multipart/form-data">-->
		<br>		
			<input type="hidden" name="login" id="login" value="<?=$_COOKIE['login'];?>">
			
			<label>Выберите действие:<br></label>			
			<select name="hesh_pk" id="hesh_pk">			
				<option value="#продаю" id="hesh_p" selected>#продаю</option>
				<option value="#куплю" id="hesh_k">#куплю</option>
			</select>
		<br><br>		
			<label>Введите название товара/услуги: <font color="red">*</font><br></label>
			<input type="text" placeholder="Введите название..." name="name" id="name" size="15" maxlength="100">
		<br><br>		
			<label>Ссылка вшитая в названии:<br></label>
			<input type="text" placeholder="Введите, если нужна" name="link_name" id="link_name" size="20" maxlength="200">
		<br><br>		
			<label>Категория товара/услуги:<br></label>
			<select name="hesh_kateg" id="hesh_kateg">			
				<option value="#недвижимость">#недвижимость</option>
				<option value="#работа">#работа</option>
				<option value="#транспорт">#транспорт</option>
				<option value="#услуги" selected>#услуги</option>
				<option value="#личные_вещи">#личные_вещи</option>
				<option value="#для_дома_и_дачи">#для_дома_и_дачи</option>
				<option value="#бытовая_электроника">#бытовая_электроника</option>
				<option value="#животные">#животные</option>
				<option value="#хобби_и_отдых">#хобби_и_отдых</option>
				<option value="#для_бизнеса">#для_бизнеса</option>
				<option value="#продукты_питания">#продукты_питания</option>
				<option value="#красота_и_здоровье">#красота_и_здоровье</option>
			</select>
		
		<br><br>
			<label>Валюта с которой работаете:<br></label>
		
			<select name="currency" id="currency">			
				<option value="PRIZM" selected>Только PRIZM</option>
				<option value="Рубль / PZM">Рубль</option>
				<option value="Доллар / PZM">Доллар</option>
				<option value="Евро / PZM">Евро</option>
				<option value="Йена / PZM">Йена</option>
				<option value="Гривна / PZM">Гривна</option>
				<option value="Фунт / PZM">Фунт</option>
				<option value="Любая валюта">Любая валюта</option>
			</select>		
			
		<br><br>
			<label>Хештеги местонахождения: <font color="red">*</font><br></label>
			<input type="text" placeholder="Напр: #Россия #ВесьМир" name="hesh_city" id="hesh_city" size="20" maxlength="100">
		<br><br>
				
			<label>Введите описание: <font color="red">*</font><br></label>
			<textarea placeholder="Опишите подробно Ваш товар/услугу" name="opisanie" id="opisanie" maxlength="1500" rows="10" cols="30" wrap="soft"></textarea>
		<br><br>
		
			<label id="warning"><br></label>
			<input type="submit" class="button" name="done" id="done" value="Применить">
		<br>
		<!--</form>-->
	</h4>
</article>
