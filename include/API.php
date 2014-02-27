<?PHP
/*
* This class uses CURL to call a REST API
*/
class API {
	var $esponse_code;

    function __construct() {
        
    }
	/*
	Using this method an API could be called. Parameters are:
		method: POST,GET,PUT or custom the default is GET
		url: API URL
		data: Should be an array of data sent to the API example: $data=array("d1"=>"r2","d2"=>"r2")
		debug: If true will echo all debug information of the API 
	*/
	function CallAPI($method, $url, $data = false,$debug=false){
		$headers = array('Content-Type: application/json');
		$curl = curl_init();
		switch ($method){
			case "POST":
				curl_setopt($curl, CURLOPT_POST, true);
			
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case "PUT":
				curl_setopt($curl, CURLOPT_PUT, 1);
				break;
			CASE "DELETE":
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			default:
				if ($data)
					$url = sprintf("%s?%s", $url, http_build_query($data));
		}
		//debug Information settings
		if($debug==true){
			curl_setopt($curl, CURLOPT_VERBOSE, true);
			$verbose = fopen('php://temp', 'rw+');
			curl_setopt($curl, CURLOPT_STDERR, $verbose);
		}

		// Optional Authentication:
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    
	
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		// Disabling SSL Certificate support temporarily. Uncomment if needed
		// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	
		$response=curl_exec($curl);
		if ($response === FALSE) {
            die('Curl failed: ' . curl_error($curl));
        }
		//echo debug Information 
		if($debug==true){
			rewind($verbose);
			$verboseLog = stream_get_contents($verbose);
			echo "Verbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";
		}
		//Header, uncomment if needed
		/*
		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		echo $header = substr($response, 0, $header_size);
		echo $body = substr($response, $header_size);
		*/
		
		//Retrieve response code and set class variable
		$this->response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	
		return $response;
	}
}
?>