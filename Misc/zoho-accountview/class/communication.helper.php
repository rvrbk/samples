<?php

class CommunicationHelper {
	/**
	 * @author Rik Verbeek
	 * @since 2014-01-23
	 * 
	 * Talk to ZoHo API to get specific record in module.
	 */
	static public function getZoHoRecordByID($module, $recordid) {
		$auth = new Auth();
		
		// Getting JSON format in object form.
		$record = json_decode(file_get_contents("https://crm.zoho.com/crm/private/json/" . $module . "/getRecordById?scope=crmapi&id=" . $recordid . "&authtoken=" . $auth->Token()));
		
		// If $record is not an object something is going wrong.
		if(is_object($record)) {
			return $record->response->result->$module->row->FL;
		}
		
		return false;
	}
	
	/**
	 * @author Rik Verbeek
	 * @since 2014-01-23
	 * 
	 * Talk to VM Webservice to put record.
	 */
	static public function putZoHoRecordToAccountView($values) {
		$ac = new Accountview();
		
		$values["action"] = "add";
		$values["langcode"] = "NL";
		
		$response = $ac->doRequest("setDebiteur", $values); // TODO Goes wrong? Though copied from working version.
		
		if(!$response["error"]) {
			return $response;
		}
		
		return false;
	}
	
	/**
	 * @author Rik Verbeek
	 * @since 2014-01-23
	 * 
	 * Store debnr from AccountView to ZoHo
	 */
	static public function putAccountViewDebNrValueToZoHoRecord($debnr, $module, $recordid) {
		$auth = new Auth();
				
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, "https://crm.zoho.com/crm/private/xml/" . $module . "/updateRecords");
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_MAXREDIRS, 1);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, "scope=crmapi&id=" . $recordid . "&xmlData=<" . $module . "><row no='1'><FL val='Debiteur'>" . $debnr . "</FL></row></" . $module . ">&authtoken=" . $auth->Token());
		
		curl_exec($curl);
		curl_close($curl);
	}
}

?>