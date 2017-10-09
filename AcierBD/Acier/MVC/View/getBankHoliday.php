<?php
if (! isset ( $_SESSION ))
	session_start ();
$anObject = null;

if (isSet ( $_GET )) {
	
	require_once $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_bankholiday_payement.php';
	
	$anObject = new FastechBankHolidayPayement();
	$anObject->getObjectListAsDynamicTableTableForWeek($_GET['id_payement']);
	
}