<?php
session_start ();

$anObject = null;

$windowName = $_GET["windowName"];
$id = $_GET["id"];


if ($windowName == "ongletPrime") {
	require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_prime.php';
	$anObject = new FastechPrime();
} else if ($windowName == "ongletCCQ") {
	require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_ccq.php';
	$anObject = new FastechCCQ();
} else if ($windowName == "ongletDepartement") {
	require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_departement.php';
	$anObject = new FastechDepartement();
}

$anObject->deleteDBObject($id);
?>