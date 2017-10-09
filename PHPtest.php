 <?php
 
 session_start();
 
 //require_once '../MVC/Model/db_workWeek_manager.php';
 require_once 'MVC/Controller/db_workWeek_manager.php';
 $aName = htmlspecialchars ( "suffixe" );
 $aStartDate = htmlspecialchars ( "2017-06-11" );
 
 $aWorkWeek = new WorkWeek ( $aName, $aStartDate );
 
 postWorkWeekInDatabase ( $aWorkWeek );
 
 $_SESSION ["work_weeks"] [$aWorkWeek->id_work_week] = $aWorkWeek;
				
?>
