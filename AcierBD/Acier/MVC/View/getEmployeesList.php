<?php
include_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Controller/db_employees_manager.php';

if(!isset($_SESSION))
session_start();

$aListOfEmployees = getAllActiveEmployesInDatabase();

echo "<option value='Choisissez un employé'>Choisissez un employé</option>";
if($aListOfEmployees!= null){
	foreach ($aListOfEmployees as $anEmployee) {
		
		echo "<option ";
		
		echo " value=" . $anEmployee->getFirstName() . " " . $anEmployee->getFamilyName().  ">" . $anEmployee->getFirstName() . "-" . $anEmployee->getFamilyName() ."</option>";

	}
}
$_SESSION['current_page'] = "Employe";
?>