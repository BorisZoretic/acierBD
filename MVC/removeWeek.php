<?php
$id = htmlspecialchars($_GET['key']);

require_once  $_SERVER["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Controller/db_workWeek_manager.php';

$answer = removeWorkWeekByID($id);
echo $answer;
?>