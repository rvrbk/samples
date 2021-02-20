<?php

class CommunicationController {
	/**
	 * @author Rik Verbeek
	 * @since 2014-01-23
	 * 
	 * Get record from ZoHo and put contents to AccountView.
	 */
	static public function putZoHoRecordToAccountViewByID($module, $recordid) {
		/**
		 * @return Array with stdClass Objects
		 */
		$record = CommunicationHelper::getZoHoRecordByID($module, $recordid);
		
		if($record) {
			$values = array();

			// Walk trough array
			foreach($record as $key => $value) {
				switch($value->val) {
					case "Account Name":
						$values["bedrijfsnaam"] = $value->content;
						
					break;
					case "Shipping Street":
						$values["postadres"] = $value->content;
						
					break;
					case "Billing Street":
						$values["adres"] = $value->content;
						
					break;
					case "Billing Code":
						$values["postcode"] = $value->content;
						
					break;
					case "Shipping City":
						$values["postadresPlaats"] = $value->content;
						
					break;
					case "Billing City":
						$values["stad"] = $value->content;
						
					break;
					case "Factuurmailadres":
						$values["emailadres"] = $value->content;
						
					break;
				}
			}
			
			//CommunicationHelper::putAccountViewDebNrValueToZoHoRecord("working!", $module, $recordid);
			
			$response = CommunicationHelper::putZoHoRecordToAccountView($values);
			
			if($response) {
				CommunicationHelper::putAccountViewDebNrValueToZoHoRecord((string)$response["EBUSTRNRS"]["ROWADDRS"]["RECID"], $module, $recordid); // TODO Could not test
				
				return true;
			}
		}
		
		return false;
	}
}

?>