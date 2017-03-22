<?php ini_set('max_execution_time', 300);
/**
  * A minimal Zendesk API PHP implementation
  *
  * @package Zendesk
  *
  * @author  Julien Renouard <renouard.julien@gmail.com> (deeply inspired by Darren Scerri <darrenscerri@gmail.com> Mandrill's implemetation)
  *
  * @version 1.0
  *
  */
class Zendesk
{
	private $user = false;
	private $password = false;
	/**
	 * API Constructor. If set to test automatically, will return an Exception if the ping API call fails
	 *
	 * @param string $password usersPassword.
	 * @param string $user Username on Zendesk.
	 * @param string $subDomain Your subdomain on zendesk, without https:// nor trailling dot.
	 * @param string $suffix .json by default.
	 * @param bool $test=true Whether to test API connectivity on creation.
	 */
	public function __construct($user, $password, $subDomain, $suffix = '.json', $test = false)
	{		
		$this->password = $password;
		$this->user    = $user;
		$this->base    = 'https://' . $subDomain . '.zendesk.com/api/v2';
		$this->suffix  = $suffix;		
		if ($test === true && !$this->test())
		{			
			throw new Exception('Cannot connect or authentice with the Zendesk API');
		}
	}
	
	/**
	 * Perform an API call.
	 *
	 * @param string $url='/tickets' Endpoint URL. Will automatically add the suffix you set if necessary (both '/tickets.json' and '/tickets' are valid)
	 * @param array $json=array() An associative array of parameters
	 * @param string $action Action to perform POST/GET/PUT
	 *
	 * @return mixed Automatically decodes JSON responses. If the response is not JSON, the response is returned as is
	 */
	public function call($url, $json, $action)
	{
		if($action == "PUT")
		{
			$headers = array('Authorization'=>'Basic '.base64_encode($this->user.':'.$this->password), 'Content-Type'=>'application/json', 'X-HTTP-Method-Override'=>"PUT");
		}else
		{
			$headers = array('Authorization'=>'Basic '.base64_encode($this->user.':'.$this->password), 'Content-Type'=>'application/json');
		}
		
		if (substr_count($url, $this->suffix) == 0)
		{
			$url .= '.json';
		}
		
		if(is_null($json) || empty($json))
		{
			$result = wp_remote_get(trailingslashit($this->base).$url, array('headers'=>$headers, 'sslverify'=>false));
		}else
		{
			$result = wp_remote_post(trailingslashit($this->base).$url, array('headers'=>$headers, 'body'=>$json));
		}
		
		#if( ! is_wp_error( $result ) && $result['response']['code'] == 200 ){
		if( ! is_wp_error( $result ) ){
			$response = $result['body'];
			$decoded = json_decode($response);
		}
		
		return is_null($decoded) ? $response : $decoded;
	}
	
	function UploadFile($filename, $dir, $path)
	{
		$url = "/uploads.json?filename=".$filename;
		$file = fopen($path.$filename, "r");
		$size = filesize($path.$filename);
		$filedata = file_get_contents($path.$filename);
		
		$ch = curl_init($this->base.$url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_USERPWD, $this->user.":".$this->password);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/binary'));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $filedata);
		curl_setopt($ch, CURLOPT_INFILE, $file);
		curl_setopt($ch, CURLOPT_INFILESIZE, $size);
		curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 45);
		curl_setopt($ch, CURLOPT_VERBOSE, TRUE);

		$output = curl_exec($ch);
		$error = curl_error($ch);

		curl_close($ch);
		$decoded = json_decode($output);
		
		return $decoded;
	}
	
	function attachFile($url, $json, $action)
	{
		if (substr_count($url, $this->suffix) == 0)
		{
			$url .= '.json';
		}

		$ch = curl_init($this->base.$url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_USERPWD, $this->user.":".$this->password);
		switch($action){
			case "POST":
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
				break;
			case "GET":
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
				break;
			case "PUT":
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
			default:
				break;
		}
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);

		$output = curl_exec($ch);
		$error = curl_error($ch);
		
		curl_close($ch);
		
		return json_decode($output);
	}
	
	/**
	 * Tests the API using /users/ping
	 *
	 * @return bool Whether connection and authentication were successful
	 */
	public function test()
	{
		return $this->call('/tickets', '', 'GET');
	}
}
