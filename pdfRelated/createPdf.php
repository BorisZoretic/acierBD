<?php
require_once $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/dompdf/autoload.inc.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$style="table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
} 

thead,tfoot{
 background-color:#323232;
color:white;
}
*{
font-size:10px;
}
";


$style = "<style>" . $style . "</style>";

$tableName = $_GET["objectName"];

/*
switch ($tableName) {
	case "printPrime":
		require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_prime.php';
		$anObject = new FastechPrime();
		$table = $anObject->getObjectListAsStaticTableString();
		break;
	case "printEmploye":
		require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_employees.php';
		$anObject = new FastechEmploye();
		$table = $anObject->getObjectListAsStaticTableString();
		break;
	case "printProject":
		require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_projects.php';
		$anObject = new FastechProject();
		$table = $anObject->getObjectListAsStaticTableString();
		break;
	case "printSpecificProject":
		$projectID = $_GET['projectID'];
		require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_employe_week_hours.php';
		$anObject = new FastechEmployekWeekHours();
		$table = $anObject->getProjectHourListAsString($projectID);
		break;
	case "printDepartement":
		require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_departement.php';
		$anObject = new FastechDepartement();
		$table = $anObject->getObjectListAsStaticTableString();
		break;
	case "printPrimeCCQ":
		require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_ccq.php';
		$anObject = new FastechCCQ();
		$table = $anObject->getObjectListAsStaticTableString();
		break;
	case "printBank":
		require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_bankholiday_payement.php';
		$anObject = new FastechBankHolidayPayement();
		$table = $anObject->getObjectListAsStaticTableString();
		break;
}*/


$table= "<table>" . $_SESSION['tblPDF'] . "</table>";


$dompdf->loadHtml($style . $table);
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'letter');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();