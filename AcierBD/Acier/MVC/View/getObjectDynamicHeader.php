<?php

if(!isset($_SESSION))
session_start();

$anObject = null;
$tableName = $_GET["objectName"];

if($tableName == "ongletSemaine"){
	$id = $_GET["idObj"];
	echo "<th>code</th><th>" . $id . "</th>"; 
	require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_projects.php';
	
	$aProject = new FastechProject();
	$aProject->getAutreHeader();
	
	echo "<th>TOTAL</th><th>PAYÉ</th><th>RÉG.</th><th>TEMPS 1/2</th>";
	require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_prime.php';
	$anObject = new FastechPrime();
	$anObject->getObjectListAsDynamicHeaderFooter(true);
	echo "'<th>Congé</th><th>BANQUE</th>";
} else if($tableName == "ongletProjet"){
	require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_departement.php';
	$anObject = new FastechDepartement();
	$anObject->getObjectListAsDynamicHeaderFooter(true);
} else if($tableName == "ongletPrixrevient"){
	require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_departement.php';
	$id = $_GET["idObj"];
	$anObject = new FastechDepartement();
	$anObject->getObjectListAsDynamicHeader(true, $id);
}

$_SESSION['current_page'] = $tableName;
?>