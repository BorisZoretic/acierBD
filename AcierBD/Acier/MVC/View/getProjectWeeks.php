<?php
session_start ();
require_once $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Controller/db_workWeek_manager.php';
include_once $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Controller/db_departement_manager.php';

$aListOfweeks = getAllActiveWorkWeeksInDatabase ();
$aListOfDepartements = getAllActiveDepartementsInDatabase ();

if ($aListOfweeks != null) {
	foreach ( $aListOfweeks as $aWeek ) {
		
		echo "<tr class='cursor tableHover'>";
		echo "<td>" . $aWeek->getName () . "</td>";
		if ($aListOfDepartements != null) {
			foreach ( $aListOfDepartements as $aDepartement ) {
				
				echo "<td>0</td>";
			}
			echo "<td>0</td>";
		}
		echo "</tr>";
	}
	
	if ($aListOfDepartements != null) {
		echo "<tr><td>Total:</td>";
		$i = 1;
		foreach ( $aListOfDepartements as $aDepartement ) {
			echo "<td>calcul" . $i . "</td>";
			$i ++;
		}
	}
	
	if ($aListOfDepartements != null) {
		echo "<td>0</td></tr><tr><td>Taux:</td>";
		$i = 1;
		foreach ( $aListOfDepartements as $aDepartement ) {
			echo "<td>" . $aDepartement->getValue() . "</td>";
		}
		echo "<td></td></tr>";
	}
}
$_SESSION ['current_page'] = "Semaine;"
?>