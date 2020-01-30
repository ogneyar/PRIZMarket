<?

/**-------------+
 * Class Tgraph |
 * -------------+
 *
 * ---------------
 * Список методов:
 * ---------------
 *
 * createPagePhoto
 *
 * getPage
 *
 */

class Tgraph
{
    // токен ТелеГраф
    private $access_token = null;
    // ссылка для доступа к апи ТелеГраф
    private $apiUrl = "https://api.telegra.ph/";
    
	/*
	** @param str $access_token
	*/
    public function __construct($access_token)
    {
        $this->access_token = $access_token;
    }    
  
    
    /* 
	** Отправляем запрос в ТелеГраф
	**
    ** @param str $method
    ** @param array $data    
	**
    ** @return mixed
    */
    public function call($method, $data)
    {
        $result = null;
        if (is_array($data)) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl . $method);
            curl_setopt($ch, CURLOPT_POST, count($data));
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            $result = curl_exec($ch);
            curl_close($ch);
        }
        return $result;
    }
    
	
	
	
    
    /*
	**  функция создания PAGE (листа, страницы)
	**
	**  @param str $title
	**  @param str $photoURL
 	**  @param bool $return_content
	**  @param str $author_name
	**
	**
	**  @return array
	*/
    public function createPagePhoto(
		$title,		
		$photoURL,
		$return_content = false,
		$author_name = null
	) {
		
		$content = [
			[
				'tag' => 'figure',
				'children' => [
					[
						'tag' => 'img',
						'attrs' => [
							'src' => $photoURL
						]
					],
					[
						'tag' => 'figcaption',
					 'children' => [""]
					]
				]
			],
			[
				'tag' => 'p',
				'children' => [
					[
						'tag' => 'br'
					]
				]
			]
		];
		
		$content = json_encode($content);
		
		$response = $this->call("createPage", [
			'access_token' => $this->access_token,
			'title' => $title,
			'author_name' => $author_name,			
			'content' => $content,
			'return_content' => $return_content
		]);	
				
		$response = json_decode($response, true);
		
		if ($response['ok']) {
			$response = $response['result'];
		}else $response = false;
		
		return $response;
	}
	
	
	
	/*
	**  функция выдачи информации о PAGE (листе, странице)
	**
	**  @param str $path	
 	**  @param bool $return_content
	**
	**
	**  @return array
	*/
    public function getPage(
		$path,		
		$return_content = false		
	) {
		
		$response = $this->call("getPage/".$path, [			
			'return_content' => $return_content
		]);	
				
		$response = json_decode($response, true);
		
		if ($response['ok']) {
			$response = $response['result'];
		}else $response = false;
		
		return $response;
	}
	
	
}



?>