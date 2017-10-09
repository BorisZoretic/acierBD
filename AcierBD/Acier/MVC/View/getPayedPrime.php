<?php
if (! isset ( $_SESSION ))
	session_start ();
$anObject = null;

if (isSet ( $_GET )) {
	
	
	if($_GET['tblId'] == "tblHeure"){
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_prime_payement.php';
		$anObject = new FastechPrimePayement();
	} else{
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_ccq_payement.php';
		$anObject = new FastechCCQPayement();
	}
	$anObject->getObjectListAsDynamicTableTableForWeek($_GET['prime'], $_GET['id_payement']);
	
}