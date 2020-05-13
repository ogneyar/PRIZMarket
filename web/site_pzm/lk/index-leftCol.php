<article id="lk">
	<h4>
		<br>
		<label>Здесь будет реализована возможность изменения никнейма клиента, его пароля, смена почтового ящика.<br></label>	
		
		<label>Можно добавить аватарку и ещё чего нибудь.<br></label>
	</h4>	
</article>
<br>
<script async src="https://telegram.org/js/telegram-widget.js?8" data-telegram-share-url="https://prizmarket.herokuapp.com" data-size="large" data-text="notext"></script>
<br>
<script async src="https://telegram.org/js/telegram-widget.js?8" data-telegram-login="TesterSiteBot" data-size="medium" data-userpic="false" data-onauth="onTelegramAuth(user)"></script>
<script type="text/javascript">
  function onTelegramAuth(user) {
    alert('Logged in as ' + user.first_name + ' ' + user.last_name + ' (' + user.id + (user.username ? ', @' + user.username : '') + ')');
  }
</script>
