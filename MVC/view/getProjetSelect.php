<?php
if (! isset ( $_SESSION ))
	session_start ();
$anObject = null;

	require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_projects.php';

	$aProject = new FastechProject();
	$aProject->getActiveObjectsAsSelect();
	

?>