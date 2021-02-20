<?php

class Auth {
	private $token;
	
	public function Token($value = null) {
		if(!isset($value)) {
			return $this->token;
		}
		
		$this->token = $value;
	}
	
	/**
	 * @author Rik Verbeek 
	 * @since 2014-01-23
	 * 
	 * Generate and distill authorization key.
	 */
	public function __construct() {
		$contents = file_get_contents("https://accounts.zoho.com/apiauthtoken/nb/create?SCOPE=ZohoCRM/crmapi&EMAIL_ID=xx@xxxx.nl&PASSWORD=xxxxx");
		$contents = substr($contents, strpos($contents, "=") +1);
		$contents = substr($contents, 0, strpos($contents, "R") -1);
		
		$this->token = $contents;
	}
}

?>