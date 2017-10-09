<?php
if (! isset ( $_SESSION ))
	session_start ();

	require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_work_weeks.php';

	$aWorkWeek = new FastechWorkWeek();
	$aWorkWeek->getActiveObjectsAsSelectSpecific($_GET['begin_date']);
	

?>