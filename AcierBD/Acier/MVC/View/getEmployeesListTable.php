<?php
include_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Controller/db_employees_manager.php';

if(!isset($_SESSION))
session_start();

$aListOfEmployees = getAllActiveEmployesInDatabase();

if($aListOfEmployees!= null){
	foreach ($aListOfEmployees as $anEmployee) {
		echo "<tr><td>" . $anEmployee->id_employe . "</td>";
		echo "<td>" . $anEmployee->getFirstName() . " " . $anEmployee->getFamilyName() . "</td>";
		echo "<td>0</td>";
		echo "<td>0</td>";
		echo "<td>0</td>";
		echo "<td>0</td>";
		echo "<td>0</td></tr>";

	}
}
$_SESSION['current_page'] = "Employe";
?>