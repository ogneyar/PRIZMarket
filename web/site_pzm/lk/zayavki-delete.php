<?php
include_once "../site_files/functions.php";
// Открыл базу данных, в конце обязательно надо закрыть

$номер_лота = $_POST['id_lota'];

$всё_норм = _сравни_лот_и_логин($логин, $номер_лота);
if ($всё_норм) {
	$всё_норм = _удали_лот($номер_лота);
	if ($всё_норм) {
		echo "Ваш лот {$номер_лота} удалён.";
	}else echo "Не смог удалить лот {$номер_лота}.<br><br>Обратитесь в <a href='https://teleg.link/Prizm_market_supportbot' target='_blank'>тех.поддержку</a>";
}else echo "Несоответствие Вашего логина с номером заявки.<br><br>Обратитесь в <a href='https://teleg.link/Prizm_market_supportbot' target='_blank'>тех.поддержку</a>";


?>
