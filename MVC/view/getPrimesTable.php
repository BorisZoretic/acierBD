<?php
require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Controller/db_prime_manager.php';
session_start ();

$aListOfPrimes = getAllActivePrimesInDatabase ();

echo "<th>ENTR<br>MÉCAN</th>";
echo "<th>AUTRE</th>";
echo "<th>TOTAL</th>";
echo "<th>PAYÉ</th>";
echo "<th>REG.</th>";

if ($aListOfPrimes!= null) {
	foreach ( $aListOfPrimes as $aPrime ) {
		$name = $aPrime->getName();
		echo "<th>" . $aPrime->getName () . "</th>";
	}
}
echo "<th>BANQUE</th>";
$_SESSION ['current_page'] = "Departement";
?>