Во второй версии моего бота я пробую работу ИНЛАЙН кнопок
они работают, после опроса нажатия удаляются предыдущие сообщения...

теперь они изменяются, без удаления (editMessage)

Добавил работу с БД MySQL
пять таблиц: users, culc, zayavka, obrabotka_zayavok, pzmarkt

user
id | id_client | name_client | status | flag

id - номер записи в таблице
id_client - номер клиента, его айди в телеграм
name_client - его имя
status - статус: master | boss | admin | client
flag - 0 | 1 - можно ли этому клиенту работать с ботом

culc
id_client - номер клиента, его айди в телеграм
id - номер нажатия кнопки на клавиатуре 
knopka - какая кнопка нажата
flag - 0 | 1 - была ли нажата кнопка далее

zayavka


obrabotka_zayavok


pzmarkt


Объединил двух ботов: PZMasrketBot и Oder_a_Deal_bot (Маркет и Гарант)

дальнейшее позже опишу)) :)