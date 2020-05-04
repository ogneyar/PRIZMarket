<?
class oFile {
	private $name;
	private $mime;
	private $content;

	public function __construct($name, $mime=null, $content=null) {
		// Проверяем, если $content=null, значит в переменной $name - путь к файлу
		if(is_null($content)) {
			// Получаем информацию по файлу (путь, имя и расширение файла)
			$info = pathinfo($name);
			// проверяем содержится ли в строке имя файла и можно ли прочитать файл
			if(!empty($info['basename']) && is_readable($name)) {
				$this->name = $info['basename'];
				// Определяем MIME тип файла
				$this->mime = mime_content_type($name);
				// Загружаем файл
				$content = file_get_contents($name);
				// Проверяем успешно ли был загружен файл
				if($content!==false) $this->content = $content;
				else throw new Exception('Don`t get content - "'.$name.'"');
			}else throw new Exception('Error param');
		}else {
			// сохраняем имя файла
			$this->name = $name;
			// Если не был передан тип MIME пытаемся сами его определить
			if(is_null($mime)) $mime = mime_content_type($name);
			// Сохраняем тип MIME файла
			$this->mime = $mime;
			// Сохраняем в свойстве класса содержимое файла
			$this->content = $content;
		};
	}

	// Метод возвращает имя файла
	public function Name() { return $this->name; }

	// Метод возвращает тип MIME
	public function Mime() { return $this->mime; }

	// Метод возвращает содержимое файла
	public function Content() { return $this->content; }

};
?>