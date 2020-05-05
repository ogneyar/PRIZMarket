<?
class BodyPost {
	//Метод формирования части составного запроса
	public static function PartPost($name, $val) {
		$body = 'Content-Disposition: form-data; name="' . $name . '"';
		// Проверяем передан ли класс oFile
		if($val instanceof oFile) {
		// Извлекаем имя файла
			$file = $val->Name();
			// Извлекаем MIME тип файла
			$mime = $val->Mime();
			// Извлекаем содержимое файла
			$cont = $val->Content();

			$body .= '; filename="' . $file . '"' . "\r\n";
			$body .= 'Content-Type: ' . $mime ."\r\n\r\n";
			$body .= $cont."\r\n";
		}else $body .= "\r\n\r\n".urlencode($val)."\r\n";
		return $body;
	}

	// Метод формирующий тело POST запроса из переданного массива
	public static function Get(array $post, $delimiter='-------------0123456789') {
		if(is_array($post) && !empty($post)) {
			$bool = false;
			// Проверяем есть ли среди элементов массива файл
			foreach($post as $val) if($val instanceof oFile) {$bool = true; break; };
			if($bool) {
				$ret = '';
				// Формируем из каждого элемента массива, составное тело POST запроса
				foreach($post as $name=>$val) 
					$ret .= '--' . $delimiter. "\r\n". self::PartPost($name, $val);
				$ret .= "--" . $delimiter . "--\r\n";
			}else $ret = http_build_query($post);
		}else throw new \Exception('Error input param!');
		return $ret;
	}
	
};
?>