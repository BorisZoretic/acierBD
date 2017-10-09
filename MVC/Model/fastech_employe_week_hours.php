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
	
	function getObjectList($weekId, $ccq){
		include $_SERVER ["DOCUMENT_ROOT"] . '/database_connect.php';
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_employees.php';
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_prime.php';
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_payements.php';
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_bankholiday_payement.php';
		
		$employe = new FastechEmploye();
		$aListOfEmployes = $employe->getListOfActiveBDObjects();
		
		//$aListOfEmployes = $employe->getListOfActiveBDObjects ();
		
		
		$payement = new FastechPayements();
		if($ccq == 1){
			$aPayementList = $payement->getListOfAllDBObjectsWhere(" id_work_week "," = ", $weekId);
		} else {
			$aPayementList = null;
		}
		$prime = new FastechPrime();
		
		if($aPayementList == null) {
			$sql = "INSERT INTO `payements` (`id_payement`, `payed`, `regular`, `id_work_week`, `id_employe`, `id_state`) VALUES ";
			
			$sql3 = "INSERT INTO `bankholiday_payement` (`id_bankholiday_payement`, `id_payement`, `holiday`, `bank`, `id_state`) VALUES ";
		}
		
		if($ccq == 1){
			$sql2 = "INSERT INTO `prime_payement` (`id_prime_payement`, `id_payement`, `prime`, `amount`, `id_state`) VALUES ";
		} else {
			$sql2 = "INSERT INTO `ccq_payement` (`id_prime_payement`, `id_payement`, `ccq`, `amount`, `id_state`) VALUES ";
		}
		
		$empCounter =0;
		if ($aListOfEmployes != null) {
			foreach ( $aListOfEmployes as $aSelectedEmploye ) {
				
				$payements = new FastechPayements();
				$id_payement= $payements->getPayementFromDB($aSelectedEmploye['order'], $weekId);
                                $totalPrimeAmount = 0;
                                $primeCounter = 1;
				
				
				if ($aSelectedEmploye['bool_ccq'] == $ccq){
					$completeInfo = $this->getEmployeCompleteInfo($aSelectedEmploye['order'], $weekId, $id_payement, $ccq);
					echo "<tr class='tableHover'>";
					if ($completeInfo != null){
						$empCounter++;
						foreach ( $completeInfo as  $key => $value) {
								if($key == "Nom"){
									echo "<td class='cursorDefault'>" . $value . "</td>";
									$this->getProjetAutre($aSelectedEmploye['order'], $weekId);
								}else if(strpos($key, 'Prime_') !== false){
									$aListOfPrimes = $prime->getListOfActiveBDObjects();
									
									$pieces = explode("_", $key);
									$piecesValue = explode("_", $value);
									
									if ($aListOfPrimes != null){
										$compt = 1;
										$namePrime = "Prime";
										foreach($aListOfPrimes as $aPrime){
											$name = $namePrime . $compt;
											if($name == $pieces[1]){
												$thePrime = $prime->getObjectFromDB( $aPrime['name']);
											}
											$compt++;
										}
									}
									
									$totalPrimeAmount += ($piecesValue[0] * $thePrime['amount']);
									
									if(sizeOf($aListOfPrimes) == $primeCounter){
										echo "<td>" . round($totalPrimeAmount, 2) . "$</td>";
									}
									
									$primeCounter++;
								} else if(strpos($key, 'CCQ_') !== false){
									$pieces = explode("_", $key);
									$piecesValue = explode("_", $value);
									
									echo "<td><form style='display:table;' table='ccq_payement' class='edit col-lg-4' idObj='". $piecesValue[1] ."'>";
									echo "<input class='editable' name='amount' value='" . $piecesValue[0] . "'></form></td>";
								}else if ($key == "payed" || $key == "regular"){
									echo "<td><form table='payements' class='edit' idObj='".$id_payement."'>";
									echo "<input class='editable' name='" . $key . "' value='" . $value . "'> </form></td>";
								} else if ($key == "banque"){
									$bank = $completeInfo["total"] - $completeInfo["payed"];
									echo "<td class='cursorDefault'>" . $bank . "</td>";
									
									$aBankPayement = new FastechBankHolidayPayement();
									$aBankPayement->updateObjectDynamically('bank', $bank, $id_payement);
									
									echo "<td><a class='cursor clickConge underlineBtn' idpayement='" . $id_payement . "' idemploye='" . $aSelectedEmploye['order'] . "'>Congé</a></td>";
								}else{
									echo "<td class='cursorDefault'>" . $value . "</td>";
								}
						}
					} else{
							echo "<script>console.log('top')</script>";
							if($aPayementList == null) {
								$sql .=  "(NULL, '0', '0', '".$weekId."', '".$aSelectedEmploye['order']."', '1')";
								
								$empCounter++;
								if($empCounter < $this->getNBCCQ($aListOfEmployes, $ccq)){
									$sql .= ", ";
								
									
								} else{
									
									if (!$result = $conn->query($sql)) {
										// Oh no! The query failed.
										exit;
									}
									else{
										
										if($ccq == 1){
											$sql2 .= $this->getQueryPrimePayement($weekId, $ccq);
										} else {
											$sql2 .= $this->getQueryCCQPayement($weekId, $ccq);
										}
										
										
										if (!$result = $conn->query($sql2)) {
											exit;
										} else{
											
											$sql3 .= $this->getQueryBankHolidayPayement($weekId, $ccq);
											if (!$result = $conn->query($sql3)) {
												exit;
											}
											else{
												$this->getObjectList($weekId, $ccq);
											}
										}
									}
								}
							} else {
								if($ccq == 1){
									$sql2 .= $this->getQueryPrimePayement($weekId, $ccq);
								} else {
									$sql2 .= $this->getQueryCCQPayement($weekId, $ccq);
								}
								
								echo "<script>console.log('first')</script>";
								if (!$result = $conn->query($sql2)) {
									exit;
								} else{
									$this->getObjectList($weekId, $ccq);
								}
							}
							//echo $sql . "<br><br>" . $sql2;
						//}
					}
					echo "</tr>";
				}
			}
		}
		
		//echo "<br><br>" . $empCounter;
		
		return true;
	}
	
	function getProjetAutre($id, $weekId){
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_projects.php';
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
	}
	
	function getNBCCQ($aListOfEmployes, $ccq){
		
		$nbCCQ =0;
		
		foreach($aListOfEmployes as $anObject){
			if($anObject['bool_ccq'] == $ccq)
				$nbCCQ++;
		}
		return $nbCCQ;
	}
	
	function getQueryCCQPayement($weekId, $ccqBool){
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_ccq.php';
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_payements.php';
		
		$ccqs = new FastechCCQ();
		$payements = new FastechPayements();
		
		$ccqs = $ccqs->getListOfActiveBDObjects();
		$payements = $payements->getListOfActiveBDObjectsWithWeekIdCCQ($weekId, $ccqBool);
		
		$sql2 = "";
		$comptPayement = 0;
		foreach($payements as $payement){
			foreach($ccqs as $ccq){
				$sql2 .=  "(NULL, '". $payement['id_payement']."', '" . $ccq['name']. "', '0', '1')";
				$comptPayement++;
				if($comptPayement != (sizeOf($payements)*sizeOf($ccqs))){
					$sql2 .= ", ";
				}
			}
		}
		//echo $sql2;
		return $sql2;
	}
	
	function getQueryPrimePayement($weekId, $ccq){
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_prime.php';
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_payements.php';
		
		$primes = new FastechPrime();
		$payements = new FastechPayements();
		
		$primes = $primes->getListOfActiveBDObjects();
		$listPayements = $payements->getListOfActiveBDObjectsWithWeekIdCCQ($weekId, $ccq);
		
		$aPayementList = $payements->getListOfAllDBObjectsWhere(" id_work_week "," = ", $weekId);
		
		$sql2 = "";
		$comptPayement = 0;
		foreach($listPayements as $payement){
			foreach($primes as $prime){
				$comptPayement++;
				if( $payements->verfyPayementForPrimeWorkWeek( $payement['id_work_week'],$prime['name'])){
					$sql2 .=  "(NULL, '". $payement['id_payement']."', '" . $prime['name']. "', '0', '1')";
					if($comptPayement != (sizeOf($listPayements)*sizeOf($primes))){
						$sql2 .= ", ";
					}
				}
				
			}
		}
		//echo $sql2;
		return $sql2;
	}
	
	function getQueryBankHolidayPayement($weekId, $ccq){
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_payements.php';
		
		$payements = new FastechPayements();
		
		$payements = $payements->getListOfActiveBDObjectsWithWeekIdCCQ($weekId, $ccq);
		
		$sql3 = "";
		$comptPayement = 0;
		foreach($payements as $payement){
			if($weekId == $payement['id_work_week']){
				$sql3 .=  "(NULL, '" . $payement['id_payement'] . "', '0', '0', '1')";
				$comptPayement++;
				if($comptPayement != sizeOf($payements)){
					$sql3 .= ", ";
				}
			}
		}
		return $sql3;
	}
	
	function getEmployeCompleteInfo($id_employe, $id_work_week, $id_payement, $ccq) {
		include $_SERVER ["DOCUMENT_ROOT"] . '/database_connect.php';
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_prime.php';
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_projects.php';
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_ccq.php';
		
		$primeQuerry = "";
		$newGroupBy ="";
		//$newGroupByProject ="";
		$compter =1;
		if($ccq == 1){
			$aPrime = new FastechPrime();
			$aPrimeList = $aPrime->getListOfActiveBDObjects();
			if($aPrimeList != null){
				$namePrime = "Prime";
				foreach ($aPrimeList as $anObject){
					$name = $namePrime . $compter;
					$primeQuerry .= " CONCAT(pp" . $name . ".amount, '_', pp" . $name . ".id_prime_payement) as Prime_" . $name . ",";
					$newGroupBy .= "pp" . $name .".id_prime_payement ";
					if($compter<sizeof($aPrimeList)){
					    $newGroupBy .= ",";
					}
					$compter++;
				}
			}
		} else{
		    
			$aCCQ = new FastechCCQ();
			$aCCQList = $aCCQ->getListOfActiveBDObjects();
			if($aCCQList != null){
				$compt = 0;
				$nameCCQ = "CCQ";
				foreach ($aCCQList as $anObject){
					$name = $nameCCQ . $compter;
					$primeQuerry .= " CONCAT(pp" . $name. ".amount, '_', pp" . $name . ".id_prime_payement) as CCQ_" . $name . ",";
					$newGroupBy .= "pp" . $name .".id_prime_payement ";
					
					if($compter<sizeof($aCCQList)){
					    $newGroupBy .= ",";
					}
					$compter++;
				}
			}
		}
		
		
		$sql = "SELECT e.id_employe, CONCAT(e.first_name, ' ', e.family_name) as Nom, SUM(COALESCE(ewh.hours, 0)) as total, p.payed as payed, p.regular as regular, (p.payed -p.regular) as T," .
				$primeQuerry
				. " SUM(bhp.holiday) as Conge, SUM(bhp.bank) as banque
				FROM payements p
				JOIN employees e ON e.order = p.id_employe ";
		
		$compter = 1;
		if($ccq == 1){
			if($aPrimeList != null){
				$namePrime = "Prime";
				foreach ($aPrimeList as $anObject){
					$name = $namePrime . $compter;
					$sql .=" JOIN prime_payement pp" . $name . " ON pp" . $name . ".id_payement = p.id_payement AND  pp" . $name . ".prime = '" . $anObject['name'] . "' ";
					$sql .="JOIN prime pr" . $name . " ON pr" . $name . ".name = pp" . $name . ".prime";
					$compter++;
				}
			}
		} else{
			if($aCCQList != null){
				$compt = 0;
				$nameCCQ = "CCQ";
				foreach ($aCCQList as $anObject){
					$name = $nameCCQ . $compter;
					$sql .=" JOIN ccq_payement pp" . $name . " ON pp" . $name . ".id_payement = p.id_payement AND  pp" . $name . ".ccq = '" . $anObject['name'] . "' ";
					$sql .="JOIN ccq pr" . $name . " ON pr" . $name . ".name = pp" . $name . ".ccq";
					$compter++;
				}
			}
		}
	
	
		
		$sql .=" 
				 JOIN bankholiday_payement bhp ON bhp.id_payement = p.id_payement
				 LEFT JOIN employe_week_hours ewh ON ewh.id_employe = p.id_employe AND ewh.id_employe = '" . $id_employe . "' AND ewh.id_work_week = '" . $id_work_week. "'";
	
		
		$sql .="  WHERE p.id_employe = '" . $id_employe . "' AND p.id_work_week = '" . $id_work_week. "' AND p.id_payement = '" . $id_payement. "'
				 GROUP BY e.id_employe, p.id_payement";
		
		
		if($newGroupBy != ""){
		    $sql .= ", " . $newGroupBy . "";
		}
		
		
				
				
		$sql .= " ORDER BY e.order ";
		
		$result = $conn->query ( $sql );
		//echo $sql . "<br><br><br>";
		
		if (($result = $conn->query($sql)) === false) {
			echo 'error: '.$conn->error;
		} else if ($result->num_rows > 0) {
			$anObject = Array ();
			while ( $row = $result->fetch_assoc () ) {
				foreach ( $row as $aRowName => $aValue ) {
					$anObject [$aRowName] = $aValue;
					$this->$aRowName = $aValue;
				}
			}
			
			$conn->close ();
			return $anObject;
		}
		$conn->close ();
		return null;
	}
	
	/*function getObjectListold($weekId, $ccq) {
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_employees.php';
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_payements.php';
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_projects.php';
		$full_name = "";
		$counter = 0;
		$counter1 = 0;
		
		$name = "";
		
		$totalHours = array ();
		$employePayements = array();
		
		$employe = new FastechEmploye();
		$payements = new FastechPayements();
		
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
						$employePayements = $payements->getPayementFromDB($value, $weekId);
						if ($employePayements == null){
							for($i = 0; $i < 2; $i++) {
								if($i = 0)
									$name = "payed";
								else{
									$name = "regular";
								}
								echo "<td><form table='payements' class='edit' idObj='0'>";
								echo "<input class='editable' name='" . $name . "' value='0'> </form></td>";
							//}
						}
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
	}*/
	
	function getProductionTotal($projectId) {
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_work_weeks.php';
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_departement.php';
		include $_SERVER ["DOCUMENT_ROOT"] . '/database_connect.php';
		
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
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_work_weeks.php';
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_departement.php';
		include $_SERVER ["DOCUMENT_ROOT"] . '/database_connect.php';
		
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
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_work_weeks.php';
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/MVC/Model/fastech_departement.php';
		include $_SERVER ["DOCUMENT_ROOT"] . '/database_connect.php';
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
		include $_SERVER ["DOCUMENT_ROOT"] . '/database_connect.php';
		
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
		include $_SERVER ["DOCUMENT_ROOT"] . '/database_connect.php';
		
		$sql = "SELECT hours FROM `" . $this->table_name . "` WHERE id_employe = " . $id_employe. " AND id_project = " . $id_project . " AND id_work_week = " . $id_work_week;
		$result = $conn->query ( $sql );
		//echo $sql;
		if ($result->num_rows > 0) {
			$hoursTotal = 0;
			while ( $row = $result->fetch_assoc () ) {
				foreach ( $row as $aRowName => $aValue ) {
					$hoursTotal += $aValue;
				}
			}
			
			$conn->close ();
			echo $hoursTotal;
			return $hoursTotal;
		}
		$conn->close ();
		
		return 0;
	}
	function getWeeksAfterDate($date) {
		include $_SERVER ["DOCUMENT_ROOT"] . '/database_connect.php';
		
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
		include $_SERVER ["DOCUMENT_ROOT"] . '/database_connect.php';
		
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


/*$anEmploye = new FastechEmployekWeekHours();
$anEmploye->getProjectHours(12, 4, 1, 1);*/
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