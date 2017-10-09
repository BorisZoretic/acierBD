<?php
if (! isset ( $_SESSION ))
	session_start ();
$anObject = null;

if (isSet ( $_GET )) {
	
	require_once $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_payements.php';
	
	$anObject = new FastechPayements();
	$anObject->getObjectListAsDynamicTableTableForWeek($_GET['id_employe'], $_GET['id_work_week']);

}