<?php
if (! isset ( $_SESSION ))
	session_start ();
$anObject = null;

	require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_departement.php';

	$aDepartement = new FastechDepartement();
	$aDepartement->getActiveObjectsAsSelect();
	

?>