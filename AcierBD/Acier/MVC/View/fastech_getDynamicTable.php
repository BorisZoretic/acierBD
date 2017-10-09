<?php
//require_once $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_departement.php';
require_once $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_employe.php';
session_start ();

 $anObject = new FastechEmploye();

$anObject->getObjectListAsDynamicTable("");

$_SESSION ['current_page'] = "Departement";
?>