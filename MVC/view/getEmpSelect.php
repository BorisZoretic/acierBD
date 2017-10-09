<?php
if (! isset ( $_SESSION ))
	session_start ();

	require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_employees.php';

	$anEmploye = new FastechEmploye();
	$anEmploye->getActiveObjectsAsSelect();
	

?>