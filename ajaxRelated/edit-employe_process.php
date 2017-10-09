<?php

if (isset ( $_GET ["name"] ) && isset ( $_GET ["value"]) && isset ( $_GET ["id"])  ) {
	
	require_once $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Controller/db_employees_manager.php';
	$aName = htmlspecialchars ( $_GET ["name"] );
	$aValue = htmlspecialchars ( $_GET ["value"] );
	$anID = htmlspecialchars ( $_GET ["id"] );

	updateEmployeDynamically($aName, $aValue, $anID);
	
}

?>