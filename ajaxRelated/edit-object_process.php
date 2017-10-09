<?php
$anObject = null;
$typeName = $_GET["typeName"];
require_once $_SERVER["DOCUMENT_ROOT"] . '/MVC/Model/fastech_' . $typeName . '.php';

$aName = '';
$aValue= '';
$anID= 0;

if ($typeName == "prime") {
    $anObject = new FastechPrime();
} else if ($typeName == "work_weeks") {
    $anObject = new FastechWorkWeek();
} else if ($typeName == "employees") {
    $anObject = new FastechEmploye();
} else if ($typeName == "projects") {
    $anObject = new FastechProject();
} else if ($typeName == "departement") {
    $anObject = new FastechDepartement();
} else if ($typeName == "users") {
    $anObject = new FastechUser();
} else if ($typeName == "payements") {
    $anObject = new FastechPayements();
} else if ($typeName == "prime_payement") {
    require_once $_SERVER["DOCUMENT_ROOT"] . '/MVC/Model/fastech_payements.php';
	
    $anObject = new FastechPrimePayement();
    $aPayement = new FastechPayements();
    
    $weekId = $_GET["weekId"];
    $employeId = $_POST["id_employe"];
    
    $id_payement = $aPayement->getPayementFromDB($employeId, $weekId);
    
    $prime = $_POST["prime"];
    
    $aCompletePrimePayement = $anObject->getPayementPrimeFromDB($prime, $id_payement);
    
    $aName = 'amount';
    $aValue = $_POST["amount"];
    $anID = $aCompletePrimePayement['id_prime_payement'];
    
} else if ($typeName == "ccq") {
    $anObject = new FastechCCQ();
} else if ($typeName == "ccq_payement") {
    $anObject = new FastechCCQPayement();
} else if ($typeName == "prix_revient") {
    $anObject = new FastechPrixRevient();
} else if ($typeName == "taux_revient") {
    $anObject = new FastechTauxRevient();
}

if($typeName != "prime_payement"){
 $aName = htmlspecialchars($_POST["name"]);
 $aName = str_replace(' ', '&nbsp;', $aName);
 $aValue = htmlspecialchars($_POST["value"]);
 $aValue = str_replace('_', ' ', $aValue);
 // $aValue = str_replace(' ', '&nbsp;', $aValue);
 $anID = trim(htmlspecialchars($_POST["id"]));
 $anID = str_replace(' ', '&nbsp;', $anID);
}

$anObject->updateObjectDynamically($aName, $aValue, $anID);

if ($aName == "bool_ccq") {
    include $_SERVER["DOCUMENT_ROOT"] . '/database_connect.php';
    
    require_once $_SERVER["DOCUMENT_ROOT"] . '/MVC/Model/fastech_work_weeks.php';
    
    require_once $_SERVER["DOCUMENT_ROOT"] . '/MVC/Model/fastech_payements.php';
    
    require_once $_SERVER["DOCUMENT_ROOT"] . '/MVC/Model/fastech_prime_payement.php';
    require_once $_SERVER["DOCUMENT_ROOT"] . '/MVC/Model/fastech_ccq_payement.php';
    
    require_once $_SERVER["DOCUMENT_ROOT"] . '/MVC/Model/fastech_prime.php';
    require_once $_SERVER["DOCUMENT_ROOT"] . '/MVC/Model/fastech_ccq.php';
    
    
    require_once $_SERVER["DOCUMENT_ROOT"] . '/MVC/Model/fastech_bankholiday_payement.php';
    
    $payements = new FastechPayements();
    $fastechPayements = new FastechPayements();
    $primePayements = new FastechPrimePayement();
    $ccqPayements = new FastechCCQPayement();
    $holidayPayement = new FastechBankHolidayPayement();
    
    
    $aListOfPayementsForEmployee = $fastechPayements->getListOfActiveBDObjectsWithCondition("id_employe", $anID, "=");
  
    
    $ccq = new FastechCCQ();
    $aListOfCCQs = $ccq->getListOfActiveBDObjects();
    $prime = new FastechPrime();
    $aListOfPrimes = $prime->getListOfActiveBDObjects();
    
    if (sizeof($aListOfPayementsForEmployee) > 0) {
        // If employe is CCQ, add payement to prime payement
        
        // If size >0 , add prime payement
        foreach ($aListOfPayementsForEmployee as $aPayement) {
            // Get both lists (CCQ and Prime)
            $aListOfPrimePayements = $primePayements->getListOfActiveBDObjectsWithCondition("id_payement", $aPayement['id_payement'], "=");
            $aListOfCCQPayements = $ccqPayements->getListOfActiveBDObjectsWithCondition("id_payement", $aPayement['id_payement'], "=");
            $aListOfHolidayPayements = $holidayPayement->getListOfActiveBDObjectsWithCondition("id_payement", $aPayement['id_payement'], "=");
                          
            // Employe becomes CCQ
            if ($aValue == 2) {
                //Check if they have entry in prime payement
                if ($aListOfPrimePayements != null) {
                    //Get id of all prime payements
                    foreach ($aListOfPrimePayements as $aPrimePayement) {
                        $aListOfCCQPayements = $ccqPayements->getListOfActiveBDObjectsWithCondition("id_payement", $aPayement['id_payement'], "=");                     
                        //Check if payement ccq already exist for this prime payement
                        if($aListOfCCQPayements != null){
                            foreach ($aListOfCCQPayements  as $aCCQPayement) {
                                //Add if doesnt exist
                                if($aCCQPayement['id_payement'] != $aPrimePayement['id_payement']){
                                    foreach ($aListOfCCQs as $localCCQ) {
                                        $localPrimePayement = new FastechCCQPayement();
                                        $localPrimePayement->setId_payement($aPrimePayement['id_payement']);
                                        $localPrimePayement->setCcq($localCCQ['ccq']);
                                        $localPrimePayement->setAmount("0");
                                        $localPrimePayement->setId_state("1");
                                        $localPrimePayement->addDBObject();
                                    }
                                }
                            }
                        }
                        else{
                            foreach ($aListOfCCQs as $localCCQ) {
                             
                                $localPrimePayement = new FastechCCQPayement();
                                $localPrimePayement->setId_payement($aPrimePayement['id_payement']);
                                $localPrimePayement->setCcq($localCCQ['name']);
                                $localPrimePayement->setAmount("0");
                                $localPrimePayement->setId_state("1");                                
                                $localPrimePayement->addDBObject();
                            }
                        }
                       
                    }
                    
                }
                
            }
            //Employe is no longer CCQ
            else{
                if ($aListOfCCQPayements!= null) {
                    //Get id of all ccq payements
                    foreach ($aListOfCCQPayements  as $aCCQPayement) {
                        $aListOfPrimePayements = $primePayements->getListOfActiveBDObjectsWithCondition("id_payement", $aPayement['id_payement'], "=");
                        
                        //Check if payement prime   already exist for this ccq payement
                        if($aListOfPrimePayements != null){
                            foreach ($aListOfPrimePayements as $aPrimePayement ) {
                                //Add if doesnt exist
                                if($aCCQPayement['id_payement'] != $aPrimePayement['id_payement']){
                                    foreach ($aListOfPrimes  as $localPrime) {
                                        $localPrimePayement = new FastechPrimePayement();
                                        $localPrimePayement->setId_payement($aPrimePayement['id_payement']);
                                        $localPrimePayement->setPrime($localPrime['name']);
                                        $localPrimePayement->setAmount(0);
                                        $localPrimePayement->setId_state(1);
                                        $localPrimePayement->addDBObject();
                                    }
                                }
                            }
                        }else{
                            foreach ($aListOfPrimes  as $localPrime) {
                                $localPrimePayement = new FastechPrimePayement();
                                $localPrimePayement->setId_payement($aPrimePayement['id_payement']);
                                $localPrimePayement->setPrime($localPrime['name']);
                                $localPrimePayement->setAmount(0);
                                $localPrimePayement->setId_state(1);
                                $localPrimePayement->addDBObject();
                            }
                        }
                       
                        
                    }
                }
            }
           
        }
    }
}

// Add to holiday

?>