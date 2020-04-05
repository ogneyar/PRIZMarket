<article id="vhod">
<?if ($_COOKIE['login']) {?>
	<p><label>
	<?echo "<br>Вы вошли как {$_COOKIE['login']}!<br><br>Можете зайти в личный кабинет, а если необходимо зайти под другим аккаунтом нажмите выход на значке с Вашим ником справа вверху сайта.";?>
	<br></label>
<?}else {?>
<!--<form action="/site_pzm/vhod/testreg.php" method="post">-->
<br>
<p>
	<label>Ваш логин:<br></label>
	<input name="login" placeholder="Ваш логин" name="login" id="login" type="text" size="15" maxlength="15">
</p>
<p>
    <label>Ваш пароль:<br></label>
    <input name="password" placeholder="Ваш пароль" name="password" id="password" type="password" size="15" maxlength="15">
</p>
<p>
	<label id="warning"><br></label>
    <input type="submit" class="button" name="submit" id="submit" value="Войти">
	<br><br>
	
	<a href="/site_pzm/registraciya/index.php">Зарегистрироваться</a> 
</p>
<!--</form>-->
<?}?>
<br>
</article>