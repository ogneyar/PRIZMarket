<!DOCTYPE html>
<html>
	<head>		
	<!--	<link rel="stylesheet" type="text/css" href="/site/style_mobile.css"> -->
		<link rel="stylesheet" type="text/css" href="/site/style_pc.css">
		<meta charset="utf-8">
		<title>Форма заказа</title>		
		
	</head>
	<body>
	
	
	
	
	
	
	
	
	
	
	<div> <!-- class="fon-img" -->
		<section>  <!-- class="block-img" -->
			<table class="tab_knop" align="center">
			<tr>
				<td class="td_knop" align="center">
					<form action="/index.php" method="GET">
						<!-- action="https://teleg.link/prizm_market" -->
						<button class="knopa"><img class="knopa_img" alt="Здесь красивая картинка" src="/site/photo/PRIZMarket.png"/></button>
					</form>
				</td>				
			
				<td class="td_knop" align="center">
					<form action="/site/zakaz_form.php" method="GET">
						<button class="knopa"><img class="knopa_img" alt="Здесь красивая картинка" src="/site/photo/PRIZMarketZakaz.png"/></button>
					</form>
				</td>		

				<td class="td_knop" align="center">
					<form action="https://www.youtube.com/channel/UCXo_PcOU2E-ek-pbdDGUYLA" method="GET">
						<!-- action="/Proto/index.php" -->
						<button class="knopa"><img class="knopa_img" alt="Здесь красивая картинка" src="/site/photo/PRIZMarketChat.png"/></button>
					</form>
				</td>				
			</tr>			
			</table>	
		
		</section><br>
	</div>
	
	
	
	
	
	
	
	
	<center>

	<div class="div">	
	<table class="tab_block">
	
	<tr>	
		<td class="block-text"><h1>Введите данные</h1></td>	
	</tr>	
	
	
	<form action="zakaz_bot.php" enctype="multipart/form-data" method="post">
	
	<tr>		
		<td class="block-text">
		<h2>
			<strong>Выберите #куплю/ #продаю:</strong><br>		
		</h2>
		</td>
	</tr>
	<tr>
		<td class="block-text">
		<select class="select" name = "teg">			
			<option value = "k" selected>#куплю</option>
			<option value = "p">#продаю</option>
		</select>
		</td>
	</tr>
	<tr>
		<td class="block-text"><br>	 		
		<h2>		
			<strong>Опишите предмет или услугу:</strong><br>		
		</h2>
		</td>
	</tr>
	<tr>
		<td class="block-text">
		
		<textarea class="textarea" name="opisanie" maxlength="500" rows="7" cols="45" required></textarea>
		<br>

		</td>
	</tr>
	<tr>
		<td class="block-text">
		<h2>	
			<strong>Обозначьте стоимость (в PRIZM):</strong><br>	
		</h2>
		</td>
	</tr>
	<tr>
		<td class="block-text">
		
		<input class="input" type="text" name="stoimost" maxlength="20" size="20" required>
		<br>
		
		</td>
	</tr>
	<tr>
		<td class="block-text">
		<h2>
			<strong>Укажите контакт  (@username):</strong><br>		
		</h2>
		</td>
	</tr>
	<tr>
		<td class="block-text">
		
		<input class="input" type="text" name="user_name" maxlength="20" size="20" required>
		<br>
		
		</td>
	</tr>
	<tr>
		<td class="block-text">
		<h2>
			<strong>Укажите Ваш *населённый пункт*:</strong><br>		
		</h2>
		</td>
	</tr>
	<tr>
		<td class="block-text">
		
		<input class="input" type="text" name="gorod" maxlength="20" size="20" required>
		<br><br>
		
		</td>
	</tr>
	
	<tr>
	
		<td class="block-text">
		<h2>
		<strong>Загрузите фото: </strong>
		</h2>		
		</td>
	</tr>
	<tr>
		<td class="block-text">
		
		<input class="input_file" type="file" name="photo">			
		
		<br><br><br><br><br><br><br>
		
		</td>
	
	</tr>
	
	<tr>
		<td class="block-text">
			<p><input class="input_submit" type="submit" name="submit" value="Отправить"></p><br>
		</td>
	
	</tr><br><br>
	
	</form>
	
	</table>
	
	</div>
	
	<br>
	<div class="div2">
		<table class="tab_block">
			<tr>
				<td class="block-text"><h3>Ну и здесь что будет написано станет Вам известно скоро, когда Я сам это узнаю.</h3><br><br><h4>Мастер(c)</h4></td>				
			</tr>
		</table>	
	</div>
	
	</center><br>
	
	
	
	
	
	
	
	
	
	
<?php 
	include 'footer.html';
?>
		
	</body>
</html>