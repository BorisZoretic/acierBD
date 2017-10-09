<?php
require_once 'fastech_model.php';
class FastechPrixRevient extends FastechModel {
	protected $table_name = 'prix_revient';
	protected $primary_key = "id_prix_revient";
	protected $id_prix_revient = 0;
	protected $id_project = 0;
	protected $suffixe = '';
	protected $start_date = '';
	protected $end_date = '';
	protected $achats_cumul = 0;
	protected $facturation_cumul = 0;
	protected $id_state = 1; // 1 equals active by default
	function __construct() {
	}
	
	/**
	 * id_prix_revient
	 * 
	 * @return int
	 */
	public function getId_prix_revient() {
		return $this->id_prix_revient;
	}
	
	/**
	 * id_prix_revient
	 * 
	 * @param int $id_prix_revient        	
	 * @return FastechPrime
	 */
	public function setId_prix_revient($id_prix_revient) {
		$this->id_prix_revient = $id_prix_revient;
		return $this;
	}
	
	/**
	 * start_date
	 * 
	 * @return date
	 */
	public function getStart_date() {
		return $this->start_date;
	}
	
	/**
	 * start_date
	 * 
	 * @param date $start_date        	
	 * @return FastechPrime
	 */
	public function setStart_date($start_date) {
		$this->start_date = $start_date;
		return $this;
	}
	
	/**
	 * end_date
	 * 
	 * @return date
	 */
	public function getEnd_date() {
		return $this->end_date;
	}
	
	/**
	 * end_date
	 * 
	 * @param date $end_date        	
	 * @return FastechPrime
	 */
	public function setEnd_date($end_date) {
		$this->end_date = $end_date;
		return $this;
	}
	
	/**
	 * achats_cumul
	 * 
	 * @return double
	 */
	public function getAchats_cumul() {
		return $this->achats_cumul;
	}
	
	/**
	 * achats_cumul
	 * 
	 * @param double $achats_cumul        	
	 * @return FastechPrime
	 */
	public function setAchats_cumul($achats_cumul) {
		$this->achats_cumul = $achats_cumul;
		return $this;
	}
	
	/**
	 * facturation_cumul
	 * 
	 * @return double
	 */
	public function getFacturation_cumul() {
		return $this->facturation_cumul;
	}
	
	/**
	 * facturation_cumul
	 * 
	 * @param double $facturation_cumul        	
	 * @return FastechPrime
	 */
	public function setFacturation_cumul($facturation_cumul) {
		$this->facturation_cumul = $facturation_cumul;
		return $this;
	}
	
	/**
	 * id_state
	 * 
	 * @return int
	 */
	public function getId_state() {
		return $this->id_state;
	}
	
	/**
	 * id_state
	 * 
	 * @param int $id_state        	
	 * @return FastechPrime
	 */
	public function setId_state($id_state) {
		$this->id_state = $id_state;
		return $this;
	}
	
	/**
	 * suffixe
	 * 
	 * @return String
	 */
	public function getSuffixe() {
		return $this->suffixe;
	}
	
	/**
	 * suffixe
	 * 
	 * @param String $suffixe        	
	 * @return FastechPrixRevient
	 */
	public function setSuffixe($suffixe) {
		$this->suffixe = $suffixe;
		return $this;
	}
	
	/**
	 * id_project
	 * 
	 * @return int
	 */
	public function getId_project() {
		return $this->id_project;
	}
	
	/**
	 * id_project
	 * 
	 * @param int $id_project        	
	 * @return FastechPrixRevient
	 */
	public function setId_project($id_project) {
		$this->id_project = $id_project;
		return $this;
	}
	function getDynamicTable() {
		$aListOfObjects = $this->getListOfActiveBDObjects ();
		if ($aListOfObjects != null) {
			foreach ( $aListOfObjects as $anObject ) {
				
				echo "<tr class='tableHover'>";
				foreach ( $anObject as $key => $value ) {
					
					if ($key != "table_name" && $key != "primary_key" && $key != "id_state") {
						$id_object = $anObject ["primary_key"];
						$table_name = $anObject ["table_name"];
						
						if ($key == "id_prix_revient") {
							echo "<td style='display:none;'><form table='" . $table_name . "' class='edit' idObj='" . $anObject [$id_object] . " '>";
							echo "<input name='" . $key . "' value='" . $value . "'> </form></td>";
						} else if ($key == "id_project") {
							$budget = $this->findProjectBudget ( $value );
							$value = $this->findProjectName ( $value );
							//echo "<td class='cursorDefault'style='min-width:150px;'>" . $value . "</td>";
							echo "<td class='cursorDefault'><form table='" . $table_name . "' class='' idrevient='" . $anObject [$id_object] . " '>";
							echo "<input class='cursorDefault' value='" . $value. "'> </form></td>";
							
							echo "<td style='display:none;'><form table='" . $table_name . "' class='edit' idrevient='" . $anObject [$id_object] . " '>";
							echo "<input value='" . $budget . "'> </form></td>";
						} else {
							echo "<td><form table='" . $table_name . "' class='edit' idObj='" . $anObject [$id_object] . " '>";
							echo "<input  class='editable'  name='" . $key . "' value='" . $value . "'> </form></td>";
						}
					}
				}
				
				echo "</tr>";
			}
		}
	}
	function findProjectName($id_project) {
		include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
		$name = '';
		
		$sql = "SELECT name FROM projects WHERE id_project = " . $id_project;
		$result = $conn->query ( $sql );
		
		if ($result->num_rows > 0) {
			while ( $row = $result->fetch_assoc () ) {
				foreach ( $row as $aRowName => $aValue ) {
					$name = $aValue;
				}
			}
			$conn->close ();
		}
		
		return $name;
	}
	function findProjectBudget($id_project) {
		include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
		$budget = 0;
		
		$sql = "SELECT budget FROM projects WHERE id_project = " . $id_project;
		$result = $conn->query ( $sql );
		
		if ($result->num_rows > 0) {
			while ( $row = $result->fetch_assoc () ) {
				foreach ( $row as $aRowName => $aValue ) {
					$budget = $aValue;
				}
			}
			$conn->close ();
		}
		
		return $budget;
	}
	function getDynamicConsultTable($id_revient) {
		$aPrixRevient = $this->getObjectFromDB ( $id_revient );
		$majoration = 0;
		$travauxEnCours = 0;
		$arrayOfTitles = array (
				1 => "MO HEURES",
				2 => "MO VALEUR",
				3 => "ACHATS CUMUL",
				4 => "",
				5 => "MAJORATION",
				6 => "FACTURATION CUMUL",
				7 => "TRAVAUX EN COURS" 
		);
		$counter = 1;
		
		require_once $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/MVC/Model/fastech_work_weeks.php';
		$aWorkWeek = new FastechWorkWeek();
		
		if ($aPrixRevient != null) {
			for($i = 1; $i < 8; $i ++) {
				echo "<tr class='tableHover'>";
				echo "<td>$arrayOfTitles[$i]</td>";
				$majoration += $aWorkWeek->getPrixRevientAsDynamicTable($aPrixRevient['start_date'], $aPrixRevient['end_date'], $aPrixRevient['id_project'], $aPrixRevient['id_prix_revient'], $i);
				if ($i == 3){
					echo "<td>" . $aPrixRevient['achats_cumul']. "$</td>";
					$majoration += $aPrixRevient['achats_cumul'];
				}
				if ($i == 5){
					echo "<td>" . $majoration . "$</td>";
					echo "<td colspan='3'></td><td></td><td></td>";
				}
				if ($i == 6){
					echo "<td>" . $aPrixRevient['facturation_cumul'] . "$</td>";
					$travauxEnCours = $majoration + $aPrixRevient['facturation_cumul'];
				}
				if ($i == 7){
					echo "<td>" . $travauxEnCours. "$</td>";
				}
				echo "</tr>";
			}
		}
	}
}


/*$aPrix = new FastechPrixRevient();
$aPrix->getDynamicConsultTable(1);
 /* $aPrix->setId_prix_revient(1);
 * $aPrix->setSuffixe("Juin");
 * $aPrix->setId_project(1);
 * $aPrix->setStart_date('2017-06-08');
 * $aPrix->setEnd_date('2017-06-09');
 * $aPrix->setAchats_cumul(20000);
 * $aPrix->setFacturation_cumul(20000);
 * $aPrix->addDBObject();
 */

?>