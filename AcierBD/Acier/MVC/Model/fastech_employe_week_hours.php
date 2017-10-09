<?php
require_once 'fastech_model.php';
class FastechEmployekWeekHours extends FastechModel {
	protected $table_name = 'employe_week_hours';
	protected $primary_key = "id_employe_hour";
	
	protected $id_employe_hour = 0;
	protected $id_work_week = '0';
	protected $id_employe = '0';
	protected $id_project = '0';
	protected $departement = '';
	protected $hours = 0;
	protected $id_state = 1; // 1 equals active by default
	function __construct() {
	}
	
	/**
	 * id_employe_hour
	 *
	 * @return Int
	 */
	public function getId_employe_hour() {
		return $this->id_employe_hour;
	}
	
	/**
	 * id_employe_hour
	 *
	 * @param Int $id_employe_hour        	
	 * @return FastechEmployekWeekHours
	 */
	public function setId_employe_hour($id_employe_hour) {
		$this->id_employe_hour = $id_employe_hour;
		return $this;
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
	 * @return FastechEmployekWeekHours
	 */
	public function setId_work_week($id_work_week) {
		$this->id_work_week = $id_work_week;
		return $this;
	}
	
	/**
	 * id_employe
	 *
	 * @return Int
	 */
	public function getId_employe() {
		return $this->id_employe;
	}
	
	/**
	 * id_employe
	 *
	 * @param Int $id_employe        	
	 * @return FastechEmployekWeekHours
	 */
	public function setId_employe($id_employe) {
		$this->id_employe = $id_employe;
		return $this;
	}
	
	/**
	 * id_project
	 *
	 * @return Int
	 */
	public function getId_project() {
		return $this->id_project;
	}
	
	/**
	 * id_project
	 *
	 * @param Int $id_project        	
	 * @return FastechEmployekWeekHours
	 */
	public function setId_project($id_project) {
		$this->id_project = $id_project;
		return $this;
	}
	
	/**
	 * departement
	 *
	 * @return String
	 */
	public function getDepartement() {
		return $this->departement;
	}
	
	/**
	 * departement
	 *
	 * @param String $departement        	
	 * @return FastechEmployekWeekHours
	 */
	public function setDepartement($departement) {
		$this->departement = $departement;
		return $this;
	}
	
	/**
	 * hours
	 *
	 * @return float
	 */
	public function getHours() {
		return $this->hours;
	}
	
	/**
	 * hours
	 *
	 * @param float $hours        	
	 * @return FastechEmployekWeekHours
	 */
	public function setHours($hours) {
		$this->hours = $hours;
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
	 * @return FastechEmployekWeekHours
	 */
	public function setId_state($id_state) {
		$this->id_state = $id_state;
		return $this;
	}
	function getObjectList($weekId, $ccq) {
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_employees.php';
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_projects.php';
		$full_name = "";
		$counter = 0;
		$counter1 = 0;
		$totalHours = array ();
		$employe = new FastechEmploye ();
		$aListOfEmployes = $employe->getListOfActiveBDObjects ();

		
		if ($aListOfEmployes != null) {
			foreach ( $aListOfEmployes as $anObject ) {
				
				echo "<tr class='tableHover'>";
				foreach ( $anObject as $key => $value ) {
					// ghetto?
					if ($key == "id_employe") {
						//array_push ( $totalHours, $this->getEmployeHours ( $value, $weekId ) );
						$totalHours[$value] = $this->getEmployeHours ( $value, $weekId );
						$id = $value;
						//echo "<td class='cursorDefault'>" . $value . "</td>";
					}
					if ($key == "first_name" || $key == "family_name") {
						$full_name .= $value . " ";
						$counter ++;
					}
					if ($counter == 2 && $key == "bool_ccq") {
						// zero's are temporary
						if($value == $ccq){
							echo "<td class='cursorDefault'>" . $id . "</td><td class='cursorDefault'>" . $full_name . "</td>";
							
							$aProject = new FastechProject();
							$aListOfProjects = $aProject->getListOfActiveBDObjects();
							
							if ($aListOfProjects != null){ 
								foreach ( $aListOfProjects as $aProject) {
									foreach ( $aProject as $key1 => $value1 ) {
										if($key1 == "bool_autre" && $value1 == 2){
											echo "<td class='cursorDefault'>" . $this->getProjectHours($id, $aProject['id_project'], $weekId) . "</td>";
										}
									}
								}
							}
							
							echo "<td class='alignRight cursorDefault'>" . $totalHours [$id] . "</td>";
							
							$counter1 ++;
						}
						$full_name = "";
						$counter = 0;
					}
				}
				echo "</tr>";
			}
		}
	}
	
	function getProductionTotal($projectId) {
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_work_weeks.php';
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_departement.php';
		include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
		
		$sql = "SELECT start_date FROM projects WHERE id_project = " . $projectId;
		$result = $conn->query ( $sql );
		
		if ($result->num_rows > 0) {
			while ( $row = $result->fetch_assoc () ) {
				foreach ( $row as $aRowName => $aValue ) {
					$date = $aValue;
				}
			}
			$conn->close ();
		}
		
		$aListOfWeeks = $this->getWeeksAfterDate ( "'" . $aValue . "'" );
		$totalHours = 0;
		$i = array ();
		$counter1 = 0;
		
		if ($aListOfWeeks != null) {
			foreach ( $aListOfWeeks as $aWeek ) {
				$weekTotalHours = 0;
				$departement = new FastechDepartement ();
				$aListOfDepartements = $departement->getListOfActiveBDObjects();
				if ($aListOfDepartements != null) {
					$counter = 0;
					foreach ( $aListOfDepartements as $aDepartement ) {
						foreach ( $aDepartement as $key1 => $value1 ) {
							if($aDepartement["bool_production"] == 1){
								if ($key1 == "name") {
									$hours = $this->getWeekProjectDepartementHours ( $projectId, $aWeek ['id_work_week'], $value1 );
									if ($counter1 == 0) {
										$departementTotalHours [$counter] = 0;
									}
									$departementTotalHours [$counter] += $hours;
									$counter ++;
									$weekTotalHours += $hours;
								}
							}
						}
					}
				}
				$counter1 ++;
				$totalHours += $weekTotalHours;
			}
	
			
		} 
		
		return $totalHours;
	}
	
	function getProjectHourList($projectId) {
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_work_weeks.php';
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_departement.php';
		include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
		
		$sql = "SELECT start_date FROM projects WHERE id_project = " . $projectId;
		$result = $conn->query ( $sql );
		
		if ($result->num_rows > 0) {
			while ( $row = $result->fetch_assoc () ) {
				foreach ( $row as $aRowName => $aValue ) {
					$date = $aValue;
				}
			}
			$conn->close ();
		}
		
		$aListOfWeeks = $this->getWeeksAfterDate ( "'" . $aValue . "'" );
		$totalHours = 0;
		$i = array ();
		$counter1 = 0;
		
		if ($aListOfWeeks != null) {
			foreach ( $aListOfWeeks as $aWeek ) {
				// echo "<br>";
				$weekTotalHours = 0;
				echo "<tr class='tableHover cursorDefault'><td>" . $aWeek ['name'] . "</td>";
				$departement = new FastechDepartement ();
				$aListOfDepartements = $departement->getListOfActiveBDObjects ();
				if ($aListOfDepartements != null) {
					$counter = 0;
					foreach ( $aListOfDepartements as $aDepartement ) {
						foreach ( $aDepartement as $key1 => $value1 ) {
							if ($key1 == "name") {
								$hours = $this->getWeekProjectDepartementHours ( $projectId, $aWeek ['id_work_week'], $value1 );
								echo "<td class='alignRight'>" . $hours . "</td>";
								if ($counter1 == 0) {
									$departementTotalHours [$counter] = 0;
								}
								$departementTotalHours [$counter] += $hours;
								$counter ++;
								$weekTotalHours += $hours;
							}
						}
					}
				}
				$counter1 ++;
				$totalHours += $weekTotalHours;
				echo "<td class='alignRight'>$weekTotalHours</td></tr>";
			}
			echo "<tr><td>TOTAL:</td>";
			for($i = 0; $i < $counter; $i ++) {
				echo "<td class='alignRight'>$departementTotalHours[$i]</td>";
			}
			echo "<td class='alignRight'>$totalHours</td></tr>";
		} else {
			echo "<tr><td>Aucune semaine n'a été trouvé</td></tr>";
		}
	}
	
	function getProjectHourListAsString($projectId) {
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_work_weeks.php';
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_departement.php';
		include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
		$depHeaderFooter= new FastechDepartement();
		$depHeader = $depHeaderFooter->getObjectListAsStaticHeaderFooterString(true);
		$depFooter = $depHeaderFooter->getObjectListAsStaticHeaderFooterString(false);
		
		$sql = "SELECT start_date FROM projects WHERE id_project = " . $projectId;
		$result = $conn->query ( $sql );
		$table = "";
		if ($result->num_rows > 0) {
			while ( $row = $result->fetch_assoc () ) {
				foreach ( $row as $aRowName => $aValue ) {
					$date = $aValue;
				}
			}
			$conn->close ();
		}
		
		$aListOfWeeks = $this->getWeeksAfterDate ( "'" . $aValue . "'" );
		$totalHours = 0;
		$i = array ();
		$counter1 = 0;
		
		if ($aListOfWeeks != null) {
			foreach ( $aListOfWeeks as $aWeek ) {
			
				$weekTotalHours = 0;
				$table .= "<tr class='tableHover cursorDefault'><td>" . $aWeek ['name'] . "</td>";
				$departement = new FastechDepartement ();
				$aListOfDepartements = $departement->getListOfActiveBDObjects ();
				if ($aListOfDepartements != null) {
					$counter = 0;
					foreach ( $aListOfDepartements as $aDepartement ) {
						foreach ( $aDepartement as $key1 => $value1 ) {
							if ($key1 == "name") {
								$hours = $this->getWeekProjectDepartementHours ( $projectId, $aWeek ['id_work_week'], $value1 );
								$table .="<td class='alignRight'>" . $hours . "</td>";
								if ($counter1 == 0) {
									$departementTotalHours [$counter] = 0;
								}
								$departementTotalHours [$counter] += $hours;
								$counter ++;
								$weekTotalHours += $hours;
							}
						}
					}
				}
				$counter1 ++;
				$totalHours += $weekTotalHours;
				$table .="<td class='alignRight'>$weekTotalHours</td></tr>";
			}
			$table .="<tr><td>TOTAL:</td>";
			for($i = 0; $i < $counter; $i ++) {
				$table .="<td class='alignRight'>$departementTotalHours[$i]</td>";
			}
			$table .="<td class='alignRight'>$totalHours</td></tr>";
		} else {
			$table .="<tr><td>Aucune semaine n'a été trouvé</td></tr>";
		}
		$table = "<thead>" .$depHeader . "</thead><tbody>" . $table . "</tbody><tfoot>" .$depFooter . "</tfoot>";
		
		return $table;
	}
	
	function getEmployeHours($id_employe, $id_work_week) {
		include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
		
		$sql = "SELECT hours FROM `" . $this->table_name . "` WHERE id_employe = " . $id_employe . " AND id_work_week = " . $id_work_week;
		$result = $conn->query ( $sql );
		
		if ($result->num_rows > 0) {
			$hoursTotal = 0;
			while ( $row = $result->fetch_assoc () ) {
				foreach ( $row as $aRowName => $aValue ) {
					$hoursTotal += $aValue;
				}
			}
			
			$conn->close ();
			return $hoursTotal;
		}
		$conn->close ();
		return 0;
	}
	
	function getProjectHours($id_employe, $id_project, $id_work_week) {
		include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
		
		$sql = "SELECT hours FROM `" . $this->table_name . "` WHERE id_employe = " . $id_employe. " AND id_project = " . $id_project . " AND id_work_week = " . $id_work_week;
		$result = $conn->query ( $sql );
		
		if ($result->num_rows > 0) {
			$hoursTotal = 0;
			while ( $row = $result->fetch_assoc () ) {
				foreach ( $row as $aRowName => $aValue ) {
					$hoursTotal += $aValue;
				}
			}
			
			$conn->close ();
			return $hoursTotal;
		}
		$conn->close ();
		
		return 0;
	}
	function getWeeksAfterDate($date) {
		include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
		
		$sql = "SELECT id_work_week, name, begin_date FROM work_weeks WHERE begin_date >= " . $date;
		//echo $sql . "<br>";
		$result = $conn->query ( $sql );
		
		if ($result->num_rows > 0) {
			$aListOfWeeks = array ();
			$counter = 0;
			while ( $row = $result->fetch_assoc () ) {
				$anObject = Array ();
				foreach ( $row as $aRowName => $aValue ) {
					//echo $aValue . "<br>";
					$anObject [$aRowName] = $aValue;
				}
				$aListOfWeeks [$counter] = $anObject;
				$counter ++;
			}
			$conn->close ();
			return $aListOfWeeks;
		}
		$conn->close ();
		return null;
	}
	function getWeekProjectDepartementHours($id_project, $id_work_week, $departement) {
		include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
		
		$sql = "SELECT hours FROM `" . $this->table_name . "` WHERE id_project = " . $id_project . " AND id_work_week = " . $id_work_week . " AND departement = '" . $departement . "'";
		$result = $conn->query ( $sql );
		if ($result->num_rows > 0) {
			$hoursTotal = 0;
			while ( $row = $result->fetch_assoc () ) {
				foreach ( $row as $aRowName => $aValue ) {
					$hoursTotal += $aValue;
				}
			}
			
			$conn->close ();
			return $hoursTotal;
		}
		$conn->close ();
		return null;
	}
}

/*
 * for($i=2;$i<5;++$i){
 * $anEmploye = new FastechEmployekWeekHours();
 * $anEmploye->setId_employe_hour(null);
 * $anEmploye->setId_work_week($i);
 * $anEmploye->setId_employe($i);
 * $anEmploye->setId_project($i);
 * $anEmploye->setDepartement("test");
 * $test = $i + 20;
 * $anEmploye->setHours($test);
 * $anEmploye->addDBObject();
 * }
 * $employe = new FastechEmployekWeekHours();
 * $employe->getObjectListAsDynamicTable(false);
 * print_r($employe);
 * $employes = $employe->getObjectListAsDynamicTable(false);
 * echo "<pre>";
 * print_r($employes);
 * echo "</pre>";
 *
 * $employe = new FastechEmployekWeekHours();
 * $employe->getWeeksAfterDate("'2017-07-01'");
 */

?>