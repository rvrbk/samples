<?php
class Accountview{
	private $webserviceUrl = "http://xxx.xxxx.xx/webserviceclient_accountview/wsdl/webserviceServer.wsdl";
	private $client;	
	private $webservice;
	private $action;
	private $ip;
	private $domain;		
	
	function __construct(){
		$this->client = new SoapClient($this->webserviceUrl, array("trace" => 1));
	}
	
	public function setWebservice($webservice){
		$this->webservice = $webservice;	
	}
	public function setAction($action){
		$this->action = $action;	
	}
	public function setIp($ip){
		$this->ip = $ip;	
	}
	public function setDomain($domain){
		$this->domain = $domain;	
	}
    
    /**
	* function handleRequest
	* @param string as json {webservice,action,type,value}
	* @return string json
	*/
    public function doRequest($action,$values=array()){
		//$this->__setSoapHeaderAuthentication(); //aanroepen authenticatie header
		
		$this->setIp($_SERVER['REMOTE_ADDR']);
		$this->setDomain($_SERVER['SERVER_NAME']);
		
		//build request
		$request 			   = array();
		$request["webservice"] = $this->webservice;
		$request["action"] 	   = $action;
		$request["values"]	   = $values;
		$request["domein"]	   = $this->domain;
		$request["ip"]	   	   = $this->ip;
		$jsonRequest 		   = json_encode($request);
		
     	try{
			$response = $this->client->__soapCall("handleRequest",array($jsonRequest));
   			return json_decode($response,true);
        }catch(SoapFault $exception){
				echo "REQUEST HEADERS:\n<pre><br>";
				echo $this->client->__getLastResponse()."<br><br>";
         		echo $exception;die();
        }
    }
}
?>