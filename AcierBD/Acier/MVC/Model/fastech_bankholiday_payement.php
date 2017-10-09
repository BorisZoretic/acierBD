<?php
require_once 'fastech_model.php';

class FastechBankHolidayPayement extends FastechModel {
	protected $table_name = 'bankholiday_payement';
	protected $primary_key = "id_bankholiday_payement";
	
	protected $id_bankholiday_payement= 0;
	protected $id_payement= 0;
	protected $holiday = '0';
	protected $bank = '0';
	protected $id_state = 1; // 1 equals active by default
	
	function __construct() {
	}


    /**
     * id_bankholiday_payement
     * @return unkown
     */
	public function getId_bankholiday_payement(){
		return $this->id_bankholiday_payement;
    }

    /**
     * id_bankholiday_payement
     * @param unkown $id_bankholiday_payement
     * @return FastechBankHolidayPayement
     */
    public function setId_bankholiday_payement($id_bankholiday_payement){
    	$this->id_bankholiday_payement = $id_bankholiday_payement;
        return $this;
    }

    /**
     * id_payement
     * @return unkown
     */
    public function getId_payement(){
        return $this->id_payement;
    }

    /**
     * id_payement
     * @param unkown $id_payement
     * @return FastechBankHolidayPayement
     */
    public function setId_payement($id_payement){
        $this->id_payement = $id_payement;
        return $this;
    }
    
    /**
     * holiday
     * @return unkown
     */
    public function getHoliday(){
    	return $this->holiday;
    }
    
    /**
     * holiday
     * @param unkown $holiday
     * @return FastechBankHolidayPayement
     */
    public function setHoliday($holiday){
    	$this->holiday= $holiday;
    	return $this;
    }

    /**
     * bank
     * @return unkown
     */
    public function getBank(){
        return $this->amount;
    }

    /**
     * bank
     * @param unkown $bank
     * @return FastechBankHolidayPayement
     */
    public function setBank($bank){
    	$this->bank = $bank;
        return $this;
    }

    /**
     * id_state
     * @return unkown
     */
    public function getId_state(){
        return $this->id_state;
    }

    /**
     * id_state
     * @param unkown $id_state
     * @return FastechPrime
     */
    public function setId_state($id_state){
        $this->id_state = $id_state;
        return $this;
    }
    
    
    public function getPayementBankHolidayFromDB($id_payement) {
    	include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
    	
    	$internalAttributes = get_object_vars ( $this );
    	
    	$sql = "SELECT * FROM `" . $this->table_name . "` WHERE id_payement = $id_payement";
    	//echo $sql . "<br>";
    	$result = $conn->query ( $sql );
    	
    	if ($result->num_rows > 0) {
    		$anObject = Array ();
    		while ( $row = $result->fetch_assoc () ) {
    			$anObject ["primary_key"] = $this->primary_key;
    			$anObject ["table_name"] = $this->table_name;
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
    
    
    public function getObjectListAsDynamicTableTableForWeek($id_payement) {
    	require_once 'fastech_employe_week_hours.php';
    	
    	$anObject = $this->getPayementBankHolidayFromDB($id_payement);
    	$anEmployeWeekHours = new FastechEmployekWeekHours();
    	if ($anObject != null) {
    		foreach ( $anObject as $key => $value ) {
    			
    			if ($key == "holiday") {
    				$id_object = $anObject ["primary_key"];
    				$table_name = $anObject ["table_name"];
    				
    				
    				echo "<td class='cursorDefault'>$value $</td>";
    			} else if ($key == "bank"){
    				$id_object = $anObject ["primary_key"];
    				$table_name = $anObject ["table_name"];
    				
    				$anEmployePayement = $this->getPayedWeek($id_payement);
    				$anEmployeHours = $anEmployeWeekHours->getEmployeHours($anEmployePayement['id_employe'], $anEmployePayement['id_work_week']);
    				
    				$bank = $anEmployeHours - $anEmployePayement['payed'];
    				
    				echo "<td class='cursorDefault'>$bank</td>";
    				//$this->setBank($bank);
    				//$this->updateDBObject();
    				$this->updateObjectDynamically('bank', $bank, $this->getPrimaryKeyFromDB($id_payement));
    			}
    		}
    		
    		
    		
    		/*$locaHalf= $localPayed-$localRegular;
    		echo "<td>$locaHalf</td>";*/
    	} else {
    		include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
    		
    		$aBankHolidayPayement = new FastechBankHolidayPayement();
    		$aBankHolidayPayement->setId_bankholiday_payement(null);
    		$aBankHolidayPayement->setId_payement($id_payement);
    		
    		$aBankHolidayPayement->setBank('0');
    		$aBankHolidayPayement->setHoliday('0');
    		
    		
    		//print_r($aPayement);
    		$aBankHolidayPayement->addDBObject ();
    		
    		$conn->close ();
    		
    		$this->getObjectListAsDynamicTableTableForWeek ($id_payement);
    	}
    }
    
    function getPayedWeek($id_payement){
    	include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
    	require_once 'fastech_prime_payement.php';
    	$aPrimePayement = new FastechPrimePayement();
    	
    	$internalAttributes = get_object_vars ( $aPrimePayement );
    	
    	$sql = "SELECT payed, id_work_week, id_employe FROM payements WHERE id_payement = $id_payement";
    	//echo $sql . "<br>";
    	$result = $conn->query ( $sql );
    	
    	if ($result->num_rows > 0) {
    		$anObject = Array ();
    		while ( $row = $result->fetch_assoc () ) {
    			foreach ( $row as $aRowName => $aValue ) {
    				$anObject [$aRowName] = $aValue;
    				$aPrimePayement->$aRowName = $aValue;
    			}
    		}
    		$conn->close ();
    		return $anObject;
    	}
    	$conn->close ();
    	return null;
    }
    
    function getPrimaryKeyFromDB($id_payement){
    	include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
    	
    	$internalAttributes = get_object_vars ( $this );
    	
    	$sql = "SELECT id_bankholiday_payement FROM `" . $this->table_name . "` WHERE id_payement = $id_payement";
    	//echo $sql . "<br>";
    	$result = $conn->query ( $sql );
    	
    	if ($result->num_rows > 0) {
    		while ( $row = $result->fetch_assoc () ) {
    			foreach ( $row as $aRowName => $aValue ) {
    				$key = $aValue;
    			}
    		}
    		$conn->close ();
    		return $key;
    	}
    	$conn->close ();
    	return null;
    }
    
    function getBankAsDynamicTable(){
    	include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
    	$compt=0;
    	$sql = "SELECT * FROM `banqueHeures`";

    	$result = $conn->query ( $sql );
    	
    	if ($result->num_rows > 0) {
    		$anObject = Array ();
    		while ( $row = $result->fetch_assoc () ) {
    			echo "<tr class='tableHover'>";
    			foreach ( $row as $aRowName => $aValue ) {
    				if($aRowName == "heures"){
    					echo "<td class='cursorDefault' style='text-align:center'>$aValue</td>";
    				} else if ($aRowName == "isCCQ" && $aValue==2 && $compt==0){ 
    					echo "</tr><tr class='cursorDefault'><th colspan='3' style='text-align:center'>CCQ</th></tr>";
    					$compt++;
    				}else if ($aRowName != "isCCQ"){
    					echo "<td class='cursorDefault'>$aValue</td>";
    				}
    				//echo $aRowName . " " . $aValue . "<br>";
    			}
    			echo "</tr>";
    		}
    		$conn->close ();
    		return $anObject;
    	}
    	$conn->close ();
    	return null;
    }
    
    function updateHoliday($id_payement, $id_week, $id_employe){
    	require_once 'fastech_employe_week_hours.php';
    	
    	$lastMonthId = $this->getPastWeeks($id_week);
    	$employeHours = new FastechEmployekWeekHours();
    	$totalHoursPastMonth = 0;
    	$montantConge = 0;
    	
    	foreach ($lastMonthId as $id){
    		//echo $id . "<br>";
    		$totalHoursPastMonth += $employeHours->getEmployeHours($id_employe, $id);
    	}
    	$hour_rate = $this->getEmployeHourRate($id_employe);
    	
    	$montantConge = 0.05*$totalHoursPastMonth*$hour_rate;
    	
    	$id_bankholiday_payement = $this->getPrimaryKeyFromDB($id_payement);
    	$this->updateObjectDynamically("holiday", $montantConge, $id_bankholiday_payement);
    }
    
    function getPastWeeks($id_week){
    	include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
    	$counter = 0;
    	
    	$sql = "SELECT id_work_week FROM `work_weeks` WHERE id_work_week < " . $id_week . " ORDER BY id_work_week DESC";
    	$result = $conn->query ( $sql );
    	
    	if ($result->num_rows > 0) {
    		$lastMonthId = Array ();
    		while ( $row = $result->fetch_assoc () ) {
    			foreach ( $row as $aRowName => $aValue ) {
    				if ($counter != 4){
    					$lastMonthId[$counter] = $aValue;
    					$counter++;
    				}
    			}
    		}
    		return $lastMonthId;
    		$conn->close ();
    	}
    	$conn->close ();
    	return null;
    }
    
    function getEmployeHourRate($id_employe){
    	include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
    	$sql = "SELECT hour_rate FROM `employees` WHERE id_employe = " . $id_employe;
    	$result = $conn->query ( $sql );
    	
    	if ($result->num_rows > 0) {
    		$hourRate = 0;
    		while ( $row = $result->fetch_assoc () ) {
    			foreach ( $row as $aRowName => $aValue ) {
    				$hourRate = $aValue;
    			}
    		}
    		return $hourRate;
    		$conn->close ();
    	}
    	$conn->close ();
    	return null;
    }
    
    public function  getObjectListAsStaticTableString() {
    	include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
    	$html ="";
    	$sql = "SELECT * FROM `banqueheures`";
    	$result = $conn->query ( $sql );
    	$table = "";
		$html .="<thead><tr ><th>Code</th><th>Nom</th><th >Heures en banques</th></tr></thead>";
		$table  .="<thead><tr ><th>Code</th><th>Nom</th><th >Heures en banques</th></tr></thead>";
    	if ($result->num_rows > 0) {
    		$anObject = Array ();
    		while ( $row = $result->fetch_assoc () ) {
    			$html .= "<tr >";
    			$table .= "<tr >";
    			foreach ( $row as $aRowName => $aValue ) {
    				if($aRowName != "isCCQ"){
    					if($aRowName == "heures"){
    						$html .= "<td >$aValue</td>";
    						$table.= "<td>$aValue</td>";
    					} else {
    						$html .= "<td>$aValue</td>";
    						$table.= "<td>$aValue</td>";
    					}
    				}
    				
    				
    			}
    			$html .= "</tr>";
    			$table.= "<tr >";
    		}
    	
    	}
    	
    	$html .="<tfoot><tr ><th>Code</th><th>Nom</th><th >Heures en banques</th></tr></tfoot>";
    	$table.="<tfoot><tr ><th>Code</th><th>Nom</th><th >Heures en banques</th></tr></tfoot>";
    	$_SESSION['tblPDF'] = $table;
    	$conn->close ();
    	return $html;
    }

}

?>