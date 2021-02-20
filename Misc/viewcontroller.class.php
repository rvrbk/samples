<?php

class ViewController {
	static public function Save($params) {
		$view = new View();
		
		$timestamp = date("YmdHis");
		
		if(isset($params["viewid"])) {
			$view = new View($params["viewid"]);
			
			ViewHelper::removeViewColumnsByViewID($view->ViewID());
			
			if($view->VisualIDs() != null) {
				foreach($view->VisualIDs() as $visualid) {
					FamilyHelper::CleanRelationsByRelationIDs($view->ViewID(), $visualid);
				}
			}
		}
		
		if(count($_FILES) > 0) {
			$uploadresult = FileTransferHelper::UploadFile($params["modulecode"], $timestamp);

			if(is_array($uploadresult)){
				return array("type" => "error", 
					"data" => $uploadresult);
			}
		}

		$view->ModuleCode($params["modulecode"]);
		
		if(isset($params["date"])) {
			$view->Date(date("Y-m-d H:i:s", strtotime($params["date"])));
		}
		
		$view->IsCategory(HtmlHelper::CastCheckboxToBoolean($params, "category"));
		$view->IsProtected(HtmlHelper::CastCheckboxToBoolean($params, "protected"));
		$view->IsRootNode(HtmlHelper::CastCheckboxToBoolean($params, "rootnode"));
		$view->IsHomeView(HtmlHelper::CastCheckboxToBoolean($params, "home"));
		$view->IsLocked(HtmlHelper::CastCheckboxToBoolean($params, "locked"));
		
		$view->Save();
		
		foreach(explode(",", str_replace(" ", "", APP_LOCALES)) as $locale) {
			$version = new Version();
			
			$version->Locale($locale);
			$version->ViewID($view->ViewID());
			
			if(isset($params["name"])) {
 				$version->Name(DatabaseHelper::Neutralize($params["name"][$version->Locale()]));
			}
			
			if(isset($params["content"])) {
				$version->Content(DatabaseHelper::Neutralize($params["content"][$version->Locale()]));
			}
			
			if(isset($params["referer"])) {
				$version->Referer(DatabaseHelper::Neutralize($params["referer"][$version->Locale()]));
			}
			
			$version->Save();
		}
		
		if(isset($params["viewcolumn"])) {
			foreach($params["viewcolumn"] as $key => $value) {
				$vc = new ViewColumn();
				
				$locale = APP_DEFAULTLOCALE;
				
				$properties = explode(",", $key);
				
				for($index = 0; $index < count($properties); $index++) {
					switch($index) {
						case 0;
							$cast = $properties[$index];
					
						break;
						case 1;
							$name = $properties[$index];
					
						break;
						case 2;
							$locale = $properties[$index];
					
						break;
					}
				}
				
				$vc->Cast($cast);
				$vc->Name($name);
				$vc->Locale($locale);
				$vc->ViewID($view->ViewID());
				$vc->Value($value);
				
				$vc->save();
			}
		}
			
		if(isset($params["parentids"])) {
			FamilyHelper::AddParents($params, $view->ViewID(), "views", $view->ModuleCode());
		}
		else {
			FamilyHelper::AddParents(array("parentids" => array(0)), $view->ViewID(), "views", $view->ModuleCode());
		}
		
		if(isset($params["childids"])) {
			FamilyHelper::AddChildren($params, $view->ViewID(), "views", $view->ModuleCode());
		}
				
		if(count($_FILES) > 0 && $_FILES["file"]["tmp_name"] != "") {
			VisualHelper::AddVisuals(array("visualpaths" => array(FileTransferHelper::getSaveFilename($_FILES["file"]["name"], $view->ModuleCode(), $timestamp))), $view->ViewID());
		}
		
		if(isset($_GET["moduledescription"])) {
			ModuleHelper::SetDescriptionID(array("viewid" => $view->ViewID()));
		}
	}
}

?>