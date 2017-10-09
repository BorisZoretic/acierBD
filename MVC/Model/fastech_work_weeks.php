<?php
require_once 'fastech_model.php';
class FastechWorkWeek extends FastechModel {
	protected $table_name = 'work_weeks';
	protected $primary_key = "id_work_week";
	protected $id_work_week = 0;
	protected $begin_day = 3; // Tuesdays (Set up by DEVS)
	protected $name = '';
	protected $begin_date = '';
	protected $id_state = 1; // 1 equals active by default
	function __construct() {
	}
	
	/**
	 * id_work_week
	 *
	 * @return Int
	 */
	public function getId_work_week() {
		return $this->id_work_week;
	}
	
	/**
	 * id_work_week
	 *
	 * @param Int $id_work_week        	
	 * @return FastechWorkWeek
	 */
	public function setId_work_week($id_work_week) {
		$this->id_work_week = $id_work_week;
		return $this;
	}
	
	/**
	 * beginDay
	 *
	 * @return Int
	 */
	public function getBeginDay() {
		return $this->beginDay;
	}
	
	/**
	 * beginDay
	 *
	 * @param Int $beginDay        	
	 * @return FastechWorkWeek
	 */
	public function setBeginDay($beginDay) {
		$this->begin_day = $beginDay;
		return $this;
	}
	
	/**
	 * name
	 *
	 * @return String
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * name
	 *
	 * @param String $name        	
	 * @return FastechWorkWeek
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	
	/**
	 * begin_date
	 *
	 * @return Date
	 */
	public function getBegin_date() {
		return $this->begin_date;
	}
	
	/**
	 * begin_date
	 *
	 * @param date $begin_date        	
	 * @return FastechWorkWeek
	 */
	public function setBegin_date($begin_date) {
		$this->begin_date = $begin_date;
		return $this;
	}
	
	/**
	 * id_state
	 *
	 * @return Int
	 */
	public function getId_state() {
		return $this->id_state;
	}
	
	/**
	 * id_state
	 *
	 * @param Int $id_state        	
	 * @return FastechWorkWeek
	 */
	public function setId_state($id_state) {
		$this->id_state = $id_state;
		return $this;
	}
	public function getListOfActiveBDObjects() {
		include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
		
		$internalAttributes = get_object_vars ( $this );
		
		$sql = "SELECT * FROM `" . $this->table_name . "` WHERE id_state = 1 ORDER BY `begin_date` DESC";
		$result = $conn->query ( $sql );
		
		if ($result->num_rows > 0) {
			$fastechObjects = array ();
			while ( $row = $result->fetch_assoc () ) {
				$anObject = Array ();
				$anObject ["primary_key"] = $this->primary_key;
				$anObject ["table_name"] = $this->table_name;
				foreach ( $row as $aRowName => $aValue ) {
					if ($aRowName != "begin_day") {
						$anObject [$aRowName] = $aValue;
						if ($aRowName == "begin_date") {
							$anObject ["payable"] = date ( 'Y-m-d', strtotime ( $aValue . " + 4 days" ) );
							//echo $anObject ["payable"];
						}
					}
				}
				$fastechObjects [$row [$this->primary_key]] = $anObject;
			}
			
			$conn->close ();
			return $fastechObjects;
		}
		$conn->close ();
		return null;
	}
	public function getObjectListAsDynamicTable($showPrimaryKey = true) {
		$aListOfObjects = $this->getListOfActiveBDObjects ();
		if ($aListOfObjects != null) {
			foreach ( $aListOfObjects as $anObject ) {
				
				echo "<tr class='tableHover'>";
				foreach ( $anObject as $key => $value ) {
					if ($key != "table_name" && $key != "primary_key" && $key != "id_state") {
						$id_object = $anObject ["primary_key"];
						$table_name = $anObject ["table_name"];
						
						if ($key != "id_work_week") {
							echo "<td><form table='" . $table_name . "' class='edit' idobj='" . $anObject [$id_object] . " '>";
							echo "<input  class='editable'  name='" . $key . "' value='" . $value . "'> </form></td>";
						} else {
							echo "<td style='display:none'><form table='" . $table_name . "' class='edit' idobj='" . $anObject [$id_object] . " '>";
							echo "<input  class='editable'  name='" . $key . "' value='" . $value . "'> </form></td>";
						}
					}
				}
				
				echo "</tr>";
			}
		}
	}
	function getActiveObjectsAsSelectSpecific($startDate) {
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_employe_week_hours.php';
		
		$anEmployeWeekHours = new FastechEmployekWeekHours ();
		
		$aListOfObjects = $anEmployeWeekHours->getWeeksAfterDate ( "'" . $startDate . "'" );
		if ($aListOfObjects != null) {
			foreach ( $aListOfObjects as $anObject ) {
				echo "<option class='editable' value='" . $anObject ["begin_date"] . "'>" . $anObject ["name"] . "</option>";
			}
		}
	}
	function getPrixRevientAsDynamicTable($dateBegin, $dateEnd, $id_project, $idRevient, $bool) {
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_departement.php';
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_taux_departement_revient.php';
		include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
		
		$tempArrayResponse = array();
		$compteurTotal = 0;
		$compteurProduction = 0;
		
		$aDep = new FastechDepartement ();
		$aListOfDeps = $aDep->getListOfActiveBDObjects ();
		
		$aTauxDepartementRevient = new FastechTauxDepartemenRevient();
		$aListOfTDR = $aTauxDepartementRevient->getListOfActiveBDObjectsWithId($idRevient);
		
		
		$newAmount = 0;
		
		foreach ( $aListOfDeps as $anObject ) {
			$originalBeginDate = $dateBegin;
			$aName = $anObject ['name'];
		    if ($bool == 4){
			    
			    if($aListOfTDR != null){
			    	foreach ( $aListOfTDR as $aTDR ) {
			    		if($aTDR['departement'] == $aName){
				        	$query = $this->getQuery($id_project, $aTDR['begin_date'], $aTDR['end_date'], $aName, $aTDR['taux']);
				            $result = $conn->query ( $query);
				            if ($result->num_rows > 0) {
				                while ( $row = $result->fetch_assoc () ) {
				                	if($anObject['bool_production'] != 2)
				                    	$compteurProduction+= $row['hoursTotal'];
				                }
				            }
				            $originalBeginDate = $aTDR['end_date'];
			       		}
			        }
			    }
			    
			    $query = $this->getQuery($id_project, $originalBeginDate, $dateEnd, $aName, $newAmount);
			    $result = $conn->query ( $query);
			    if ($result->num_rows > 0) {
			        while ( $row = $result->fetch_assoc () ) {
			        	if($anObject['bool_production'] != 2)
			            	$compteurProduction+= $row['hoursTotal'];
			        }
			    }
			} else if($bool == 1 || $bool == 2){
				$totalTDRHours = 0;
				$totalTDRValue = 0;
				if($aListOfTDR != null){
					foreach ( $aListOfTDR as $aTDR ) {
						if($aTDR['departement'] == $aName){
							$query = $this->getQuery($id_project, $aTDR['begin_date'], $aTDR['end_date'], $aName, $aTDR['taux']);
							$result = $conn->query ( $query);
							if ($result->num_rows > 0) {
								while ( $row = $result->fetch_assoc () ) {
									if($bool == 1){
										$compteurTotal += $row['hoursTotal'];
										$totalTDRHours += $row['hoursTotal'];
										//echo "<td>" . ($totalTDRHours) . "</td>";
									} else{
										$compteurTotal += $row['valueTotal'];
										$totalTDRValue += $row['valueTotal'];
										//echo "<td>" . ($totalTDRValue) . "</td>";
									}
								}
							}
							$originalBeginDate = $aTDR['end_date'];
						}
					}
				}
				$query = $this->getQuery($id_project, $originalBeginDate, $dateEnd, $aName, $newAmount);
				$result = $conn->query ( $query);
				if ($result->num_rows > 0) {
					while ( $row = $result->fetch_assoc () ) {
						if($bool == 1){
							$compteurTotal+= $row['hoursTotal'];
							echo "<td>" . ($row['hoursTotal'] + $totalTDRHours) . "</td>";
						} else{
							$compteurTotal+= $row['valueTotal'];
							echo "<td>" . round($row['valueTotal'] + $totalTDRValue, 2) . "</td>";
						}
					}
				}
			}
		}
		
		if ($bool == 4){
			require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_taux_revient.php';
			$aTaux= new FastechTauxRevient();
			$aTauxList = $aTaux->getListOfActiveBDObjects();
			foreach ( $aTauxList as $anObject ) {
				$count = count($aListOfDeps)-4;
				echo "<td colspan='$count'></td>";
				echo "<td>total MO & achats</td><td></td><td>" . $compteurProduction . "</td><td>" . $anObject['taux'] . "</td><td></td><td>" . $compteurProduction*$anObject['taux']. "$</td>";
				return $compteurProduction*$anObject['taux'];
			}
		} else if ($bool == 1){
			echo "<td></td>";
			echo "<td>" . round($compteurTotal, 2) . "h</td>";
		} else if ($bool == 2){
			echo "<td></td>";
			echo "<td>" . round($compteurTotal, 2) . "$</td>";
			return round($compteurTotal, 2) ;
		} else if ($bool == 3){
			$count = count($aListOfDeps);
			echo "<td colspan='$count'></td><td></td>";
		} else if($bool == 5){
			$count = count($aListOfDeps)-4;
			echo "<td colspan='$count'></td>";
			
		} else if ($bool == 6 || $bool == 7){
			$count = count($aListOfDeps);
			echo "<td colspan='" . $count . "'></td><td></td>";
		}
		return 0;
	}
	
	function getQuery($id_project, $dateBegin, $dateEnd, $aName, $newAmount){
		$query = '';
		if($newAmount == 0){
			$query = "SELECT d.name as depName, SUM(hours) as hoursTotal, d.amount *SUM(hours) as valueTotal
						FROM employe_week_hours ewh
						JOIN work_weeks ww on ww.id_work_week  = ewh.id_work_week
						JOIN departement d on ewh.departement = d.name
						WHERE id_project = " . $id_project . " AND  d.name = '".$aName."'
						AND ww.begin_date >= '".$dateBegin."' AND ww.begin_date  < '".$dateEnd."'";
		} else {
			$query = "SELECT d.name as depName, SUM(hours) as hoursTotal, " . $newAmount . "*SUM(hours) as valueTotal
					FROM employe_week_hours ewh
					JOIN work_weeks ww on ww.id_work_week  = ewh.id_work_week
					JOIN departement d on ewh.departement = d.name
					WHERE id_project = " . $id_project . " AND  d.name = '".$aName."'
					AND ww.begin_date >= '".$dateBegin."' AND ww.begin_date  < '".$dateEnd."'";
			
			echo $aName. " ". $newAmount ."<br><br>";
		}
		return $query;
	}
}


 /*$aWorkWeek = new FastechWorkWeek();
  echo "<table style='border: 1px solid black'>";
  for ($i = 1; $i < 8; $i++){
  	echo "<tr style='border: 1px solid black'>";
  	$aWorkWeek->getPrixRevientAsDynamicTable('2017-06-15', '2017-07-06', 1, 3, $i);
  	echo "</tr>";
  }
  echo "</table>";*/
 /*$temp =  $aWorkWeek->getPrixRevientAsDynamicTable('2017-06-17','2017-07-17');
  echo "<pre>";
  print_r ($temp);
  echo "</pre>";*/

?>