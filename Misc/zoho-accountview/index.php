<?php

// Include classes
foreach(new DirectoryIterator("class") as $context) {
	if(!$context->isDot()) {
		require($context->getPath() . DIRECTORY_SEPARATOR . $context->getFilename());
	}
}

CommunicationController::putZoHoRecordToAccountViewByID("Accounts", "938396000000349003");

?>