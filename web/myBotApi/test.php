<?
include_once "class.ofile.php";
include_once "class.bodypost.php";

$bot_icq->sendText($chatId, "Это начало.");

// Генерируем уникальную строку для разделения частей POST запроса
$delimiter = '-------------'.uniqid();

$файл = "https://i.ibb.co/YZVdQrH/file-108.jpg";

$image_mime = mime_content_type($файл);

$content = file_get_contents($файл);

// Формируем объект oFile содержащий файл
$file = new oFile($файл, $image_mime, $content);

// Формируем тело POST запроса
$post = BodyPost::Get(array(
	'token' => "001.2839288818.3919878723:752122979",
	'chatId' => "752067062", 
	'file'=>$file
	), $delimiter);

// Инициализируем  CURL
$ch = curl_init();

// Указываем на какой ресурс передаем файл
curl_setopt($ch, CURLOPT_URL, "https://api.icq.net/bot/v1/messages/sendFile");
// Указываем, что будет осуществляться POST запрос
curl_setopt($ch, CURLOPT_POST, 1);
// Передаем тело POST запроса
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

/* Указываем дополнительные данные для заголовка:
     Content-Type - тип содержимого, 
     boundary - разделитель и 
     Content-Length - длина тела сообщения */
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data; boundary=' . $delimiter,
'Content-Length: ' . strlen($post)));

// Отправляем POST запрос на удаленный Web сервер
curl_exec($ch);

$bot_icq->sendText($chatId, "Это конец.");
?>