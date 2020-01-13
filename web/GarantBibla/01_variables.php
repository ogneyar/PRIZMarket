<?php

$body = file_get_contents('php://input'); //Получаем в $body json строку
$arr = json_decode($body, true); //Разбираем json запрос на массив в переменную $arr


// Имя таблицы Mysql в которой хранятся данные пользователей бота
$table='garant_users';
// Имя таблицы Mysql в которой хранятся данные о нажатых кнопках калькулятора
$table2='culc';
// Имя таблицы Mysql в которой хранятся данные о заявке, это временная таблица
$table3='zayavka';
// Имя таблицы Mysql в которой хранятся данные о заявке, принятой админом
$table4='obrabotka_zayavok';

// Имя таблицы chat_garant в которой хранятся данные о группах Администраторов ГарантБота
$table6='chat_garant';

//$except = __LINE__."\n".__FILE__."\n";

$userBot = $tg->getMe();
$username_bot = $userBot->getUsername();
$first_name_bot = $userBot->getFirstName();


$tehPodderjka = "\n\nВопросы в [тех.поддержку](https://t.me/Prizm_market_supportbot?start=) \xF0\x9F\x91\x88\n\n";

$cenaText='ЦЕНУ за 1 PZM';

// номер апдейта для привязки к номеру заказа
$update = $arr['update_id'];

// айди нового участника группы
$new_chat_part_id = $arr['message']['new_chat_participant']['id'];

// айди удалённого из группы
$left_chat_part_id = $arr['message']['left_chat_participant']['id'];

// Из какого чата пришло сообщение MESSAGE (private, group, super_group) 
$chat_type = $arr['message']['chat']['type'];

// Название чата из которого пришло сообщение MESSAGE
$chat_title = $arr['message']['chat']['title'];



// Номер сообщения callbackQuery
$callbackQueryId = $arr['callback_query']['id'];

// id от кого пришло сообщение CALLBACKQUERY
$callback_from_id = $arr['callback_query']['from']['id'];

//ИМЯ ОТ КОГО ПРИШЛО СООБЩЕНИЕ  CALLBACK_QUERY!!!
$callback_first_name = $arr['callback_query']['from']['first_name'];

//USER_name ОТ КОГО ПРИШЛО СООБЩЕНИЕ callback_query
$callback_user_name = $arr['callback_query']['from']['username'];
if ($callback_user_name=='') $callback_user_name = 'неизвестно';

//Номер пришедшего сообщения - CALLBACKQUERY!!!
$callbackMessageId = $arr['callback_query']['message']['message_id'];

// id чата из которого пришло сообщение CALLBACKQUERY
$callbackChatId = $arr['callback_query']['message']['chat']['id'];

// Из какого чата пришло сообщение CALLBACKQUERY (private, group, super_group) 
$callbackChat_type = $arr['callback_query']['message']['chat']['type'];

// Текст из сообщения, привязанного к callback_query
$callbackText = $arr['callback_query']['message']['text'];
 
// Название команды переданной callbackQuery от inLineКeyboardМаркап)
$callbackQuery = $arr['callback_query']['data'];





// имя чата - ссылка на этот чат
$chat_user_name = $arr['message']['chat']['username'];
if ($chat_user_name == '') $chat_user_name = 'неизвестно';




//USER_name ОТ КОГО ПРИШЛО СООБЩЕНИЕ  message
$user_name = $arr['message']['from']['username'];
if ($user_name=='') $user_name = 'неизвестно';

//USER_name ОТ КОГО ПРИШЛО СООБЩЕНИЕ  inline_query
$inline_query_user_name = $arr['inline_query']['from']['username'];
if ($inline_query_user_name=='') $inline_query_user_name = 'неизвестно'; 


//ИМЯ ОТ КОГО ПРИШЛО СООБЩЕНИЕ  MESSAGE!!!
$first_name = $arr['message']['from']['first_name'];


//ИМЯ ОТ КОГО ПРИШЛО СООБЩЕНИЕ  inline_query!!!
$inline_query_first_name = $arr['inline_query']['from']['first_name'];


//Получаем текст сообщения, которое нам пришло.
$text = $arr['message']['text']; 


// Текст из сообщения, привязанного к reply_to_message
$replyText = $arr['message']['reply_to_message']['text'];

  
// id чата из которого пришло сообщение MESSAGE
$chat_id = $arr['message']['chat']['id'];


// id от кого пришло сообщение MESSAGE
$from_id = $arr['message']['from']['id'];

// id от кого пришло сообщение inline_query
$inline_query_from_id = $arr['inline_query']['from']['id'];


//Номер пришедшего сообщения - MESSAGE!!!
$message_id = $arr['message']['message_id'];

 //Номер пришедшего сообщения - MESSAGE!!!
$reply_message_id = $arr['message']['reply_to_message']['message_id'];



// inline_query запрос
$inline_query = $arr['inline_query']['query'];

// Номер сообщения inline_query
$inline_query_id = $arr['inline_query']['id'];




//ПОСТРОЧНОЕ ЗАПОЛНЕНИЕ КНОПОК клавиатуры НУЛЕВОГО уровня KeybordInLine0    ссыль на ПРАВИЛА
$inLine0_but1=["text"=>"Правила","url"=>"https://t.me/Secure_deal_PZM/5"];
$inLine0_but2=["text"=>"Подать заявку","callback_data"=>"nachalo"];

$inLine0_str1=[$inLine0_but1];
$inLine0_str2=[$inLine0_but2];

$inLine0_keyb=[$inLine0_str1, $inLine0_str2];

$keyInLine0 = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLine0_keyb);


//ПОСТРОЧНОЕ ЗАПОЛНЕНИЕ КНОПОК клавиатуры ПЕРВОГО уровня KeybordInLine1
$inLine1_but1=["text"=>"#продам","callback_data"=>"prodam"];
$inLine1_but2=["text"=>"#куплю","callback_data"=>"kuplu"];
$inLine1_but3=["text"=>"в НАЧАЛО","callback_data"=>"menu"];
$inLine1_but4=["text"=>"Шаг НАЗАД","callback_data"=>"nazad_v_nachalo"];

$inLine1_str1=[$inLine1_but2, $inLine1_but1];
$inLine1_str2=[$inLine1_but3, $inLine1_but4];

$inLine1_keyb=[$inLine1_str1, $inLine1_str2];

//СОЗДАНИЕ КЛАВИАТУРЫ ПЕРВОГО уровня KeybordInLine1
$keyInLine1 = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLine1_keyb);


// ВРЕМЕННО ОТКЛЮЧЕНА!!!
//ПОСТРОЧНОЕ ЗАПОЛНЕНИЕ КНОПОК клавиатуры ВТОРОГО уровня KeybordInLine2
$inLine2_but1=["text"=>"PZM","callback_data"=>"nal1"];
$inLine2_but2=["text"=>"альфа-код","callback_data"=>"nal2"];
$inLine2_but3=["text"=>"ваучер livecoin","callback_data"=>"nal3"];
$inLine2_but4=["text"=>"Шаг НАЗАД","callback_data"=>"nachalo"];
$inLine2_str1=[$inLine2_but1];
$inLine2_str2=[$inLine2_but2, $inLine2_but3];
$inLine2_str3=[$inLine2_but4];
$inLine2_keyb=[$inLine2_str1, $inLine2_str2, $inLine2_str3];
$keyInLine2 = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLine2_keyb);



//ПОСТРОЧНОЕ ЗАПОЛНЕНИЕ КНОПОК клавиатуры ТРЕТЬЕГО уровня KeybordInLine3
$inLine3_but1=["text"=>"\x31\xE2\x83\xA3","callback_data"=>"key1"]; // 1
$inLine3_but2=["text"=>"\x32\xE2\x83\xA3","callback_data"=>"key2"]; // 2
$inLine3_but3=["text"=>"\x33\xE2\x83\xA3","callback_data"=>"key3"]; // 3
$inLine3_but4=["text"=>"\x34\xE2\x83\xA3","callback_data"=>"key4"]; // 4
$inLine3_but5=["text"=>"\x35\xE2\x83\xA3","callback_data"=>"key5"]; // 5
$inLine3_but6=["text"=>"\x36\xE2\x83\xA3","callback_data"=>"key6"]; // 6
$inLine3_but7=["text"=>"\x37\xE2\x83\xA3","callback_data"=>"key7"]; // 7
$inLine3_but8=["text"=>"\x38\xE2\x83\xA3","callback_data"=>"key8"]; // 8
$inLine3_but9=["text"=>"\x39\xE2\x83\xA3","callback_data"=>"key9"]; // 9
$inLine3_but10=["text"=>"\x30\xE2\x83\xA3","callback_data"=>"key10"];  // НОЛЬ
$inLine3_but11=["text"=>"\x30\xE2\x83\xA3\x30\xE2\x83\xA3","callback_data"=>"key11"];  // 0 0 
$inLine3_but12=["text"=>"\x30\xE2\x83\xA3\x30\xE2\x83\xA3\x30\xE2\x83\xA3","callback_data"=>"key12"];  // 0 0 0 
$inLine3_but13=["text"=>"\xF0\x9F\x94\x99","callback_data"=>"key13"];  // НАЗАД
$inLine3_but14=["text"=>",", "callback_data"=>"key14"];  // запятая
$inLine3_but15=["text"=>"\xE2\x9C\x85","callback_data"=>"key15"];  // ВВОД
$inLine3_but16a=["text"=>"в НАЧАЛО","callback_data"=>"menu"];
$inLine3_but16=["text"=>"Шаг НАЗАД","callback_data"=>"nachalo"];  // Шаг НАЗАД

$inLine3_str1=[$inLine3_but1, $inLine3_but2, $inLine3_but3];
$inLine3_str2=[$inLine3_but4, $inLine3_but5, $inLine3_but6];
$inLine3_str3=[$inLine3_but7, $inLine3_but8, $inLine3_but9];
$inLine3_str4=[$inLine3_but10, $inLine3_but11, $inLine3_but12];
$inLine3_str5=[$inLine3_but13, $inLine3_but14, $inLine3_but15];
$inLine3_str6=[$inLine3_but16a, $inLine3_but16];

$inLine3_keyb=[$inLine3_str1, $inLine3_str2, $inLine3_str3, $inLine3_str4, $inLine3_str5, $inLine3_str6];

//СОЗДАНИЕ КЛАВИАТУРЫ ТРЕТЬЕГО уровня KeybordInLine3
$keyInLine3 = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLine3_keyb);


// 4 и 5 ПОМЕНЯНЫ МЕСТАМИ!!!!!!
//ПОСТРОЧНОЕ ЗАПОЛНЕНИЕ КНОПОК клавиатуры ЧЕТВЁРТОГО уровня KeybordInLine4
$inLine4_but1=["text"=>"\x31\xE2\x83\xA3","callback_data"=>"4key1"]; // 1
$inLine4_but2=["text"=>"\x32\xE2\x83\xA3","callback_data"=>"4key2"]; // 2
$inLine4_but3=["text"=>"\x33\xE2\x83\xA3","callback_data"=>"4key3"]; // 3
$inLine4_but4=["text"=>"\x34\xE2\x83\xA3","callback_data"=>"4key4"]; // 4
$inLine4_but5=["text"=>"\x35\xE2\x83\xA3","callback_data"=>"4key5"]; // 5
$inLine4_but6=["text"=>"\x36\xE2\x83\xA3","callback_data"=>"4key6"]; // 6
$inLine4_but7=["text"=>"\x37\xE2\x83\xA3","callback_data"=>"4key7"]; // 7
$inLine4_but8=["text"=>"\x38\xE2\x83\xA3","callback_data"=>"4key8"]; // 8
$inLine4_but9=["text"=>"\x39\xE2\x83\xA3","callback_data"=>"4key9"]; // 9
$inLine4_but10=["text"=>"\x30\xE2\x83\xA3","callback_data"=>"4key10"];  // НОЛЬ
$inLine4_but11=["text"=>"\x30\xE2\x83\xA3\x30\xE2\x83\xA3","callback_data"=>"4key11"];  // 0 0 
$inLine4_but12=["text"=>"\x30\xE2\x83\xA3\x30\xE2\x83\xA3\x30\xE2\x83\xA3","callback_data"=>"4key12"];  // 0 0 0 
$inLine4_but13=["text"=>"\xF0\x9F\x94\x99","callback_data"=>"4key13"];  // НАЗАД
$inLine4_but14=["text"=>",", "callback_data"=>"4key14"];  // запятая
$inLine4_but15=["text"=>"\xE2\x9C\x85","callback_data"=>"4key15"];  // ВВОД
$inLine4_but16a=["text"=>"в НАЧАЛО","callback_data"=>"menu"];
$inLine4_but16=["text"=>"Шаг НАЗАД","callback_data"=>"nazad_iz_ceni"];  // Шаг НАЗАД

$inLine4_str1=[$inLine4_but1, $inLine4_but2, $inLine4_but3];
$inLine4_str2=[$inLine4_but4, $inLine4_but5, $inLine4_but6];
$inLine4_str3=[$inLine4_but7, $inLine4_but8, $inLine4_but9];
$inLine4_str4=[$inLine4_but10, $inLine4_but11, $inLine4_but12];
$inLine4_str5=[$inLine4_but13, $inLine4_but14, $inLine4_but15];
$inLine4_str6=[$inLine4_but16a, $inLine4_but16];

$inLine4_keyb=[$inLine4_str1, $inLine4_str2, $inLine4_str3, $inLine4_str4, $inLine4_str5, $inLine4_str6];

//СОЗДАНИЕ КЛАВИАТУРЫ ЧЕТВЁРТОГО уровня KeybordInLine4
$keyInLine4 = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLine4_keyb);


// 4 и 5 ПОМЕНЯНЫ МЕСТАМИ!!!!!!
//ПОСТРОЧНОЕ ЗАПОЛНЕНИЕ КНОПОК клавиатуры ПЯТОГО уровня KeybordInLine5
$inLine5_but1=["text"=>"Рубли","callback_data"=>"rubl"];
$inLine5_but2=["text"=>"Доллары","callback_data"=>"dollar"];
$inLine5_but3=["text"=>"BTC","callback_data"=>"BTC"];
$inLine5_but4=["text"=>"ETH","callback_data"=>"Efirium"];
$inLine5_but8=["text"=>"в НАЧАЛО","callback_data"=>"menu"];
$inLine5_but9=["text"=>"Шаг НАЗАД","callback_data"=>"nazad_iz_val"];

$inLine5_str1=[$inLine5_but1, $inLine5_but2];
$inLine5_str2=[$inLine5_but3, $inLine5_but4];
$inLine5_str9=[$inLine5_but8, $inLine5_but9];

$inLine5_keyb=[$inLine5_str1, $inLine5_str2, $inLine5_str9];

//СОЗДАНИЕ КЛАВИАТУРЫ ПЯТОГО уровня KeybordInLine5
$keyInLine5 = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLine5_keyb);




//ПОСТРОЧНОЕ ЗАПОЛНЕНИЕ КНОПОК клавиатуры ШЕСТОГО (с половиной) уровня KeybordInLine_bank
$inLine_bank_but1=["text"=>"Сбербанк","callback_data"=>"bank1"];
$inLine_bank_but2=["text"=>"Альфа","callback_data"=>"bank2"];
$inLine_bank_but3=["text"=>"Тинькофф","callback_data"=>"bank3"];
$inLine_bank_but4=["text"=>"РусСтандарт","callback_data"=>"bank4"];
$inLine_bank_but5=["text"=>"ВТБ","callback_data"=>"bank5"];
$inLine_bank_but6=["text"=>"QIWI","callback_data"=>"bank6"];
$inLine_bank_but7=["text"=>"ЯД","callback_data"=>"bank7"];
$inLine_bank_but8=["text"=>"Advcash","callback_data"=>"bank8"];
$inLine_bank_but9=["text"=>"Payeer","callback_data"=>"bank9"];
$inLine_bank_but10=["text"=>"ePayment's","callback_data"=>"bank10"];
$inLine_bank_but11=["text"=>"Готово","callback_data"=>"gotovo_bank"];

$inLine_bank_str1=[$inLine_bank_but1, $inLine_bank_but2];
$inLine_bank_str2=[$inLine_bank_but3, $inLine_bank_but4];
$inLine_bank_str3=[$inLine_bank_but5, $inLine_bank_but6];
$inLine_bank_str4=[$inLine_bank_but7, $inLine_bank_but8];
$inLine_bank_str5=[$inLine_bank_but9, $inLine_bank_but10];
$inLine_bank_str9=[$inLine_bank_but11];

$inLine_bank_keyb=[$inLine_bank_str1, $inLine_bank_str2, $inLine_bank_str3, $inLine_bank_str4, $inLine_bank_str5, $inLine_bank_str9];
$keyInLine_bank = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLine_bank_keyb);


//ПОСТРОЧНОЕ ЗАПОЛНЕНИЕ КНОПОК клавиатуры ШЕСТОГО уровня KeybordInLine6
$inLine6_but1=["text"=>"Выбрать банк","callback_data"=>"vibor_banka"];
$inLine6_but2=["text"=>"Ввести свой","callback_data"=>"vvod_banka"];
$inLine6_but3=["text"=>"Очистить список","callback_data"=>"ochist_bank"];
$inLine6_but4=["text"=>"Шаг НАЗАД","callback_data"=>"nazad_iz_banka"];
$inLine6_but5=["text"=>"в НАЧАЛО","callback_data"=>"menu"];
$inLine6_but6=["text"=>"ДАЛЕЕ","callback_data"=>"dalee_iz_banka"];
$inLine6_str1=[$inLine6_but1, $inLine6_but2];
$inLine6_str2=[$inLine6_but3, $inLine6_but4];
$inLine6_str3=[$inLine6_but5, $inLine6_but6];
$inLine6_keyb=[$inLine6_str1, $inLine6_str2, $inLine6_str3];
$keyInLine6 = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLine6_keyb);



//ПОСТРОЧНОЕ ЗАПОЛНЕНИЕ КНОПОК клавиатуры СЕДЬМОГО уровня KeybordInLine7
$inLine7_but1=["text"=>"Согласен(на)","callback_data"=>"soglasen"];
$inLine7_but2=["text"=>"Правила","url"=>"https://t.me/Secure_deal_PZM/5"];
$inLine7_but17=["text"=>"Добавить своего гаранта","callback_data"=>"dobav_garanta"];
$inLine7_but18=["text"=>"Без гаранта","callback_data"=>"bez_garanta"];
$inLine7_but19=["text"=>"Гарант приветствуется","callback_data"=>"garant_privet"];
$inLine7_but20a=["text"=>"в НАЧАЛО","callback_data"=>"menu"];
$inLine7_but20=["text"=>"Шаг НАЗАД","callback_data"=>"nazad_garant"];
$inLine7_str1=[$inLine7_but1];
$inLine7_str2=[$inLine7_but2];
$inLine7_str7=[$inLine7_but17];
$inLine7_str8=[$inLine7_but18];
$inLine7_str9=[$inLine7_but19];
$inLine7_str10=[$inLine7_but20a, $inLine7_but20];
$inLine7_keyb=[$inLine7_str1, $inLine7_str2, $inLine7_str10];
$keyInLine7 = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLine7_keyb);


//ПОСТРОЧНОЕ ЗАПОЛНЕНИЕ КНОПОК клавиатуры ВОСЬМОГО уровня KeybordInLine8
$inLine8_but1=["text"=>"Готово!","callback_data"=>"otpravka"];
$inLine8_but2=["text"=>"в НАЧАЛО","callback_data"=>"menu"];
$inLine8_but9=["text"=>"Шаг НАЗАД","callback_data"=>"nazad_k_garant"];

$inLine8_str1=[$inLine8_but1];
$inLine8_str2=[$inLine8_but2];

$inLine8_keyb=[$inLine8_str1, $inLine8_str2];

//СОЗДАНИЕ КЛАВИАТУРЫ ВОСЬМОГО уровня KeybordInLine8
$keyInLine8 = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLine8_keyb);


//ПОСТРОЧНОЕ ЗАПОЛНЕНИЕ КНОПОК клавиатуры ДЕВЯТОГО уровня KeybordInLine9    АДМИНИСТРИРОВАНИЕ
$inLine9_but1=["text"=>"Отклонить","callback_data"=>"otklon"];
$inLine9_but2=["text"=>"Принять","callback_data"=>"prinyat"];
$inLine9_str1=[$inLine9_but1];
$inLine9_str2=[$inLine9_but2];
$inLine9_keyb=[$inLine9_str1, $inLine9_str2];
$keyInLine9 = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLine9_keyb);



$HideKeyboard = new \TelegramBot\Api\Types\ReplyKeyboardHide(true);


// подготовка клиента к написанию ответного сообщения
$forceRep = new \TelegramBot\Api\Types\ForceReply(true);






?>