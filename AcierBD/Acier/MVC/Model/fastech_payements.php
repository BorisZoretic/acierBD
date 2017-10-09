<?php
require_once 'fastech_model.php';
class FastechPayements extends FastechModel {
	protected $table_name = 'payements';
	protected $primary_key = "id_payement";
	protected $id_payement = 0;
	protected $payed = 0;
	protected $regular = 0;
	protected $id_work_week = 0;
	protected $id_employe = 0;
	protected $id_state =1;
	function __construct() {
		$this->payed ='0.0';
		$this->regular ='0.0';
	}
	
	function getId_state() {
		return $this->id_state;
	}
	
	function setId_state($id_state) {
		$this->id_state = $id_state;
	}
	
	/**
	 * id_payement
	 *
	 * @return unkown
	 */
	public function getId_payement() {
		return $this->id_payement;
	}
	
	/**
	 * id_payement
	 *
	 * @param unkown $id_payement        	
	 * @return FastechPayements
	 */
	public function setId_payement($id_payement) {
		$this->id_payement = $id_payement;
		return $this;
	}
	
	/**
	 * payed
	 *
	 * @return unkown
	 */
	public function getPayed() {
		return $this->payed;
	}
	
	/**
	 * payed
	 *
	 * @param unkown $payed        	
	 * @return FastechPayements
	 */
	public function setPayed($payed) {
		$this->payed = $payed;
		return $this;
	}
	
	/**
	 * regular
	 *
	 * @return unkown
	 */
	public function getRegular() {
		return $this->regular;
	}
	
	/**
	 * regular
	 *
	 * @param unkown $regular        	
	 * @return FastechPayements
	 */
	public function setRegular($regular) {
		$this->regular = $regular;
		return $this;
	}
	
	/**
	 * id_work_week
	 *
	 * @return unkown
	 */
	public function getId_work_week() {
		return $this->id_work_week;
	}
	
	/**
	 * id_work_week
	 *
	 * @param unkown $id_work_week        	
	 * @return FastechPayements
	 */
	public function setId_work_week($id_work_week) {
		$this->id_work_week = $id_work_week;
		return $this;
	}
	
	/**
	 * id_employe
	 *
	 * @return unkown
	 */
	public function getId_employe() {
		return $this->id_employe;
	}
	
	/**
	 * id_employe
	 *
	 * @param unkown $id_employe        	
	 * @return FastechPayements
	 */
	public function setId_employe($id_employe) {
		$this->id_employe = $id_employe;
		return $this;
	}
	public function getPayementFromDB($id_employe, $id_work_week) {
		include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
		
		$internalAttributes = get_object_vars ( $this );
		
		$sql = "SELECT * FROM `" . $this->table_name . "`  WHERE id_employe = $id_employe  AND id_work_week = $id_work_week ";
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
	public function getObjectListAsDynamicTableTableForWeek($id_employe, $id_work_week) {
		$anObject = $this->getPayementFromDB($id_employe, $id_work_week);
		if ($anObject != null) {
			$localPayed=0;
			$localRegular = 0;
			$locaHalf = 0;
			foreach ( $anObject as $key => $value ) {
				
				if ($key == "payed" || $key == "regular") {
					$id_object = $anObject ["primary_key"];
					$table_name = $anObject ["table_name"];
					
					if($key == "payed"){
						$localPayed = $value;
					}
					else{
						$localRegular = $value;
					}
					
					echo "<td><form table='" . $table_name . "' class='edit' idObj='" . $anObject [$id_object] . " '>";
					echo "<input class='editable' name='" . $key . "' value='" . $value . "'> </form></td>";
				}
			}
			
			
			
			$locaHalf= $localPayed-$localRegular;
			echo "<td class='cursorDefault'>$locaHalf</td>";
		} else {
			include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
			$aPayement = new FastechPayements();
			$aPayement->setId_payement(null);
			$aPayement->id_employe = $id_employe;
			$aPayement->id_work_week = $id_work_week;
			$aPayement->payed = '0';
			$aPayement->regular = '0';
			
			
			//print_r($aPayement);
			$aPayement->addDBObject ();
			
			$conn->close ();
			
			$this->getObjectListAsDynamicTableTableForWeek ( $id_employe, $id_work_week );
		}
	}
}
/*
$payement = new FastechPayements();
$payement->getObjectListAsDynamicTableTableForWeek(1, 1);
*/
?>