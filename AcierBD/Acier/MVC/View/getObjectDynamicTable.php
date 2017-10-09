<?php

if(!isset($_SESSION))
session_start();
$anObject = null;
$tableName = $_GET["objectName"];

if($tableName== "ongletPrime"){
	require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_prime.php';
	$anObject = new FastechPrime();
	$anObject->getObjectListAsDynamicTable(true);
	
} else if($tableName == "ongletSemaine"){
	require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_work_weeks.php';
	$anObject = new FastechWorkWeek();
	$anObject->getObjectListAsDynamicTable(false);
	
} else if($tableName == "ongletEmploye"){
	require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_employees.php';
	$anObject = new FastechEmploye();
	$anObject->getObjectListAsDynamicTable(true);
} else if($tableName == "ongletProjet"){
	require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_projects.php';
	$anObject = new FastechProject();
	$anObject->getObjectListAsDynamicTable(false);
} else if($tableName == "ongletDepartement"){
	require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_departement.php';
	$anObject = new FastechDepartement();
	$anObject->getObjectListAsDynamicTable(true);
} else if($tableName == "ongletCompte"){
	require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_users.php';
	$anObject = new FastechUser();
	if($_SESSION['username'] == "admin"){
		$anObject->getObjectListAsDynamicTable(false);
	}
	else{
		$anObject->getCurrentUserAsDynamicTable($_SESSION['username']);
	}
	
} else if($tableName == "ongletHeure"){
	require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_employe_week_hours.php';
	$weekId = $_GET["id"];
	$isCCQ = $_GET["isCCQ"];
	$anObject = new FastechEmployekWeekHours();
	$anObject->getObjectList($weekId, $isCCQ);
	$tableName = "ongletSemaine";
} else if($tableName == "ongletProjetHeure"){
	require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_employe_week_hours.php';
	$projectId = $_GET["id"];
	$anObject = new FastechEmployekWeekHours();
	$anObject->getProjectHourList($projectId);
	$tableName = "ongletProjet";
} else if($tableName== "ongletCCQ"){
	require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_ccq.php';
	$anObject = new FastechCCQ();
	$anObject->getObjectListAsDynamicTable(true);
} else if($tableName == "ongletBanque"){
	require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_bankholiday_payement.php';
	$anObject = new FastechBankHolidayPayement();
	$anObject->getBankAsDynamicTable();
} else if($tableName == "ongletPrixrevient"){
	require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_prix_revient.php';
	$anObject = new FastechPrixRevient();
	$anObject->getDynamicTable();
} else if($tableName == "ongletConsultRevient"){
	require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_prix_revient.php';
	$id = $_GET["idRevient"];
	$anObject = new FastechPrixRevient();
	$anObject->getDynamicConsultTable($id);
	$tableName = "ongletPrixrevient";
} else if($tableName == "ongletTauxrevient"){
	require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_taux_revient.php';
	$anObject = new FastechTauxRevient();
	$anObject->getObjectListAsDynamicTable(true);
} else if ($tableName == "tableSpec"){
    require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_taux_departement_revient.php';
    $anObject = new FastechTauxDepartemenRevient();
    $anObject->getObjectListAsDynamicTableForRevient($_GET['idRevient']);
}

$_SESSION['current_page'] = $tableName;

?>