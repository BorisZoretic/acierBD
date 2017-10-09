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

$table ="";
if(isset($_POST['data'])){
	$table= htmlspecialchars($_POST['data']);
}


$dompdf->loadHtml($style . $table);
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'letter');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();