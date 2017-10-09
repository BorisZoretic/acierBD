<?php
include_once  $_SERVER["DOCUMENT_ROOT"] . '/MVC/Model/fastech_project.php';

if(!isset($_SESSION))
session_start();

$aProject = new FastechProject();
$aProject->getActiveObjectsAsSelect();
$_SESSION['current_page'] = "Projet";
?>