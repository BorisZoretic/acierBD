<?php
if (! isset ( $_SESSION ))
	session_start ();
$anObject = null;

if (isSet ( $_GET )) {
	include $_SERVER ["DOCUMENT_ROOT"] . '/database_connect.php';
	
	require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_projects.php';
	$aProject = new FastechProject();
	$aListOfProject = $aProject->getListOfActiveBDObjects ();
	echo "<tr class='tableHover cursorDefault'><td>TOTAL</td><td></td>";
	
	if($aListOfProject!= null){
		foreach ( $aListOfProject as $anObject ) {
			if($anObject['bool_autre'] == 2){
				$query = "SELECT SUM(ewh.hours) as totalHours
						FROM employe_week_hours ewh
						JOIN projects p on p.id_project = ewh.id_project
						WHERE ewh.id_work_week = '" . $_GET['weekId'] . "' AND p.name = '" . $anObject['name'] . "' ";
				$result = $conn->query ($query);
				if ($result->num_rows > 0) {
					while ( $row = $result->fetch_assoc () ) {
						echo "<td>" . $row['totalHours'] . "</td>";
					}
				}
			}
		}
	}
	
	$query = "SELECT SUM(ewh.hours) as totalHours
			FROM employe_week_hours ewh
			JOIN projects p on p.id_project = ewh.id_project
			WHERE ewh.id_work_week = " . $_GET['weekId'];
	$result = $conn->query ($query);
	if ($result->num_rows > 0) {
		while ( $row = $result->fetch_assoc () ) {
			echo "<td>" . $row['totalHours'] . "</td>";
		}
	}
	
	require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_prime.php';
	$aPrime = new FastechPrime();
	$aListOfPrimes = $aPrime->getListOfActiveBDObjects ();
	
	$totalPayed = 0;
	$totalRegular = 0;
	$totalT2 = 0;
	$totalHoliday = 0;
	$totalBank = 0;
	$compteur = 1;
	$primeStuff = '';
	
	if($aListOfPrimes != null){
		foreach ( $aListOfPrimes as $anObject ) {
			$query = "SELECT SUM(p.payed) as totalPayed, SUM(p.regular) as totalRegular, SUM(p.payed)-SUM(p.regular) as totalT2, SUM(pp.amount) as totalHoursPrime, SUM(pp.amount)*pr.amount as totalPricePrime, SUM(bhp.holiday) as totalHoliday, SUM(bhp.bank) as totalBank
					FROM payements p
	                JOIN employees e ON e.order = p.id_employe AND e.bool_ccq = 1 
					 JOIN prime_payement pp ON pp.id_payement = p.id_payement
					JOIN bankholiday_payement bhp ON bhp.id_payement = p.id_payement
					JOIN prime pr ON pr.name = pp.prime
					WHERE p.id_work_week = '" . $_GET['weekId'] . "' AND pp.prime = '". $anObject['name']."'";
			$result = $conn->query ($query);
			if ($result->num_rows > 0) {
				while ( $row = $result->fetch_assoc () ) {
					$totalPayed = $row['totalPayed'];
					$totalRegular= $row['totalRegular'];
					$totalT2= $row['totalT2'];
					$totalHoliday= $row['totalHoliday'];
					$totalBank= $row['totalBank'];
					
					if ($_GET['tableId'] == "tblHeure")
						$totalPrime+=$row['totalPricePrime'];
						//$primeStuff .= "<td>" . $row['totalHoursPrime'] . "h</td><td>" . $row['totalPricePrime'] . "$</td>";
				}
			}
		}
		$primeStuff .= "<td>" . round($totalPrime, 2) . "$</td>";
	}
	
	require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_ccq.php';
	$aCCQ = new FastechCCQ();
	$aListOfCCQ = $aCCQ->getListOfActiveBDObjects ();
	$compteur = 1;
	
	if($aListOfCCQ!= null){
		foreach ( $aListOfCCQ as $anObject1 ) {
			$query = "SELECT SUM(p.payed) as totalPayed, SUM(p.regular) as totalRegular, SUM(p.payed)-SUM(p.regular) as totalT2, SUM(cp.amount) as totalHoursCCQ, SUM(bhp.holiday) as totalHoliday, SUM(bhp.bank) as totalBank
					FROM payements p
	                 JOIN employees e ON e.order = p.id_employe AND e.bool_ccq = 2  
					 JOIN ccq_payement cp ON cp.id_payement = p.id_payement
					JOIN bankholiday_payement bhp ON bhp.id_payement = p.id_payement
					JOIN ccq c ON c.name = cp.ccq
					where p.id_work_week = '" . $_GET['weekId'] . "' AND cp.ccq = '". $anObject1['name']."'";
			$result = $conn->query ($query);
			//echo "<br>" . $query;
			if ($result->num_rows > 0) {
				while ( $row = $result->fetch_assoc () ) {
					if($compteur == 1){
						$compteur++;
						echo "<td>" . ($totalPayed + $row['totalPayed']) . "</td><td>" . ($totalRegular + $row['totalRegular']) . "</td><td>" . ($totalT2 + $row['totalT2']) . "</td>";
						if ($_GET['tableId'] != "ccqs")
							echo  $primeStuff;
						$totalHoliday+= $row['totalHoliday'];
						$totalBank+= $row['totalBank'];
					}
					if ($_GET['tableId'] == "ccqs")
						echo "<td>" . $row['totalHoursCCQ'] . "</td>";
				}
			}
		}
	}
	
	echo "<td>" . $totalHoliday. "$</td><td>" . $totalBank. "h</td>";
	
	echo "</tr>";
}