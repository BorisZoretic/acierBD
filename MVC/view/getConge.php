<?php
if (! isset ( $_SESSION ))
	session_start ();
$anObject = null;

if (isSet ( $_GET )) {
	
	require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_bankholiday_payement.php';
	
	$anObject = new FastechBankHolidayPayement();
	$anObject->updateHoliday($_GET['id_payement'], $_GET['id_week'], $_GET['id_employe']);
	
}