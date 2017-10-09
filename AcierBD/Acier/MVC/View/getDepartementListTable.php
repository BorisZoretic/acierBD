<?php
include_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Controller/db_departement_manager.php';

if(!isset($_SESSION))
session_start();

$aListOfDepartements = getAllActiveDepartementsInDatabase();

echo "<th>Semaine</th>";
if($aListOfDepartements != null){
	foreach ($aListOfDepartements as $aDepartement) {

		echo "<th>" . $aDepartement->getName() . "</th>";

	}
}
echo "<th>TOTAL HRES</th>";
$_SESSION['current_page']="Departement";
?>