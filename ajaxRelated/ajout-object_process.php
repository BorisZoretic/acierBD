<?php
session_start ();

$anObject = null;

$typeName = $_GET["typeName"];
require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_' . $typeName . '.php';

if ($typeName == "prime") {
	$anObject = new FastechPrime ();
} else if ($typeName == "work_weeks") {
	$anObject = new FastechWorkWeek();
} else if ($typeName == "employees") {
	$anObject = new FastechEmploye();
} else if ($typeName == "projects") {
	$anObject = new FastechProject();
	$anObject->setProduction_total("0");
	$anObject->setId_project(null);
} else if ($typeName == "departement") {
	$anObject = new FastechDepartement();
} else if ($typeName == "employe_week_hours"){
	$anObject = new FastechEmployekWeekHours();
	$anObject->setId_state(1);
} else if ($typeName == "ccq"){
	$anObject = new FastechCCQ();
} else if($typeName == "prix_revient"){
	$anObject = new FastechPrixRevient();
} else if($typeName == "taux_departement_revient"){
	$anObject = new FastechTauxDepartemenRevient();
} else if ($typeName == "banque"){
	$anObject = new FastechBanque();
}

$attributes = $anObject->getObjectAsArrayWithOutMetadata ();

$valuesToBeAdded = $_POST;

foreach ( $valuesToBeAdded as $key => $value ) {
	$attributeName = "set" . ucfirst ( $key );
	if($key == "bool_ccq" || $key == "bool_production" || $key == "bool_autre"){
		$value = 2;
	}
	if($key == "end_date" && $typeName == "prix_revient"){
		$value= strtotime($value);
		$value= strtotime("+7 day", $value);
		$value = date('Y-m-d', $value);
	}
	$anObject->$attributeName ( $value );
}
$anObject->addDBObject ();

if ($typeName == "employees") {
	require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_work_weeks.php';
	require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_payements.php';
	require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_bankholiday_payement.php';
	require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_prime_payement.php';
	require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_ccq_payement.php';
	require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_prime.php';
	require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_ccq.php';
	
	$employeList = $anObject->getListOfActiveBDObjects();
	$newestEmploye = end($employeList); 
	//For each work week that has a payement
	
	$aWorkWeek = new FastechWorkWeek();
	$payement = new FastechPayements();
	
	$primePayement = new FastechPrimePayement();
	$prime = new FastechPrime();
	$aListOfPrimes = $prime->getListOfActiveBDObjects();
	
	$ccqPayement = new FastechCCQPayement();
	$ccq = new FastechCCQ();
	$aListOfCCQ = $ccq->getListOfActiveBDObjects();
	
	$aListOfWorkWeeks = $aWorkWeek->getListOfActiveBDObjects();
	foreach($aListOfWorkWeeks as $aWorkWeek){
		$aLocalPayement = $payement->getListOfAllDBObjectsWhere(" id_work_week "," = ", $aWorkWeek['id_work_week']);
		if($aLocalPayement != null){
			$payementLocal = new FastechPayements();
			$payement->setId_work_week($aWorkWeek['id_work_week']);
			$payement->setId_employe($newestEmploye['order']);
			$payement->setPayed('0');
			$payement->setRegular('0');
			
			if($payement->addDBObjectResponse(false)){
				$localPayementList = $payementLocal->getListOfActiveBDObjects();
			
				$lastPayement = end($localPayementList);
				
				$bankHolidayPayement = new FastechBankHolidayPayement();
				$bankHolidayPayement->setId_payement($lastPayement['id_payement']);
				$bankHolidayPayement->setHoliday('0');
				$bankHolidayPayement->setBank('0');
				$bankHolidayPayement->addDBObjectResponse(false);
				
				if($newestEmploye['bool_ccq'] == 1){
					
					foreach($aListOfPrimes as $aPrime){
						
						$primePayement->setId_payement($lastPayement['id_payement']);
						$primePayement->setPrime($aPrime['name']);
						$primePayement->setAmount('0');
						$primePayement->addDBObjectResponse(false);
					}
				}else{
					foreach($aListOfCCQ as $aCCQ){
						$ccqPayement->setId_payement($lastPayement['id_payement']);
						$ccqPayement->setCcq($aCCQ['name']);
						$ccqPayement->setAmount('0');
						$ccqPayement->addDBObjectResponse(false);
					}
				}
			}
			
		}
	}
	
}
?>