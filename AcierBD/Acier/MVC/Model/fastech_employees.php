<?php
include 'fastech_departement.php';
class FastechEmploye extends FastechModel {
	protected $table_name = 'employees';
	protected $primary_key = "id_employe";
	protected $id_employe = null;
	protected $first_name = "";
	protected $family_name = "";
	protected $hour_rate = 0;
	protected $departement = "";
	protected $bool_ccq = 1;
	protected $id_state = 1;
	function __construct() {
		// Do nothing
	}
	
	/**
	 * first_name
	 * 
	 * @return String
	 */
	public function getFirst_name() {
		return $this->first_name;
	}
	
	/**
	 * first_name
	 * 
	 * @param String $first_name        	
	 * @return FastechEmploye
	 */
	public function setFirst_name($first_name) {
		$this->first_name = $first_name;
		return $this;
	}
	
	/**
	 * family_name
	 * 
	 * @return String
	 */
	public function getFamily_name() {
		return $this->family_name;
	}
	
	/**
	 * family_name
	 * 
	 * @param String $family_name        	
	 * @return FastechEmploye
	 */
	public function setFamily_name($family_name) {
		$this->family_name = $family_name;
		return $this;
	}
	
	/**
	 * hour_rate
	 * 
	 * @return Double
	 */
	public function getHour_rate() {
		return $this->hour_rate;
	}
	
	/**
	 * hour_rate
	 * 
	 * @param Double $hour_rate        	
	 * @return FastechEmploye
	 */
	public function setHour_rate($hour_rate) {
		$this->hour_rate = $hour_rate;
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
	 * @return FastechEmploye
	 */
	public function setDepartement($departement) {
		$this->departement = $departement;
		return $this;
	}
	
	/**
	 * bool_ccq
	 *
	 * @return Int
	 */
	public function getBool_ccq() {
		return $this->bool_ccq;
	}
	
	/**
	 * bool_ccq
	 *
	 * @param Int $bool_ccq
	 * @return FastechEmploye
	 */
	public function setBool_ccq($bool_ccq) {
		$this->bool_ccq= $bool_ccq;
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
	 * @return FastechEmploye
	 */
	public function setId_state($id_state) {
		$this->id_state = $id_state;
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
	 * @return FastechEmploye
	 */
	public function setId_employe($id_employe) {
		$this->id_employe = $id_employe;
		return $this;
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
						if($key != "departement"){
							if ($key != "bool_ccq") {
								echo "<td><form table='" . $table_name . "' class='edit' idobj='" . $anObject [$id_object] . " '>";
								echo "<input  class='editable'  name='" . $key . "' value='" . $value . "'> </form></td>";
							} else{
								echo "<td><form table='" . $table_name . "' class='edit' idobj='" . $anObject [$id_object] . " '>";
								echo "<input ";
								if($value == "2"){
									echo "checked ";
								}
								echo  "type='checkbox' class='editable'  name='" . $key . "' value='" . $value . "'> </form></td>";
							}
						}else{
							$aDepartement = new FastechDepartement();
							
							echo "<td><form table='" . $table_name . "' class='edit' idobj='" . $anObject [$id_object] . " '>";
							echo "<select class='editable' name='" . $key . "'>";
							$aDepartementName = $anObject ["departement"];
							$aListOfDepartements = $aDepartement->getActiveObjectsAsSelect($aDepartementName);
							echo "</select></form></td>";
						}
						
					}
				}
				
				echo "</tr>";
			}
		}
	}
	
	//merged in fastech_employe_week_hours (see getObjectList($weekId))
	/*function getEmployeListAsDynamicTable(){
		$full_name = "";
		$counter = 0;
		$aListOfObjects = $this->getListOfActiveBDObjects ();
		if ($aListOfObjects != null) {
			foreach ( $aListOfObjects as $anObject ) {
				echo "<tr class='tableHover cursorDefault'>";
				foreach ( $anObject as $key => $value ) {
					//kinda ghetto
					if ($key != "table_name" && $key != "primary_key" && $key != "id_state") {
						if($key == "id_employe"){
							echo "<td>" . $value. "</td>";
						}
						if($key == "first_name" || $key == "family_name"){
							$full_name .= $value . " ";
							$counter++;
						}
						if($counter == 2){
							echo "<td>" . $full_name. "</td>";
							$full_name = "";
							$counter = 0;
						}
						
					}
				}
				echo "</tr>";
			}
		}
	}*/
	
	public function getActiveObjectsAsSelect($selected = null) {
		$aListOfObjects = $this->getListOfActiveBDObjects ();
		if ($selected == null) {
			echo "<option value='Choisissez un $this->table_name'>Choisissez un $this->table_name</option>";
		}
		if ($aListOfObjects != null) {
			foreach ( $aListOfObjects as $anObject ) {
				
				echo "<option ";
				
				if (preg_replace ( '/\s+/', '', $selected ) == preg_replace ( '/\s+/', '', $anObject [$this->primary_key] )) {
					echo " selected='selected' ";
				}
				echo " class='editable' value=" . $anObject [$this->primary_key] . ">" . $anObject ["first_name"] . " " . $anObject ["family_name"] . "</option>";
			}
		}
	}
	
	
	
	public function  getObjectListAsStaticTableString() {
		$table ="";
		$aListOfObjects = $this->getListOfActiveBDObjects ();
		
		$table  .= "<thead><tr>";
		$table  .= "<td>Code</td>";
		$table  .= "<td>Prénom</td>";
		$table  .= "<td>Nom</td>";
		$table  .= "<td>Taux horaire</td>";
		$table  .= "<td>Département</td>";
		$table  .= "<td>Role</td>";
		$table  .= "</tr></thead>";
		$table  .= "<tbody>";
		if ($aListOfObjects != null) {
			foreach ( $aListOfObjects as $anObject ) {
				
				$table  .= "<tr class=''>";
				foreach ( $anObject as $key => $value ) {
					if ($key != "table_name" && $key != "primary_key" && $key != "id_state") {
						
						$table  .= "<td>";
						if($key =="bool_ccq"){
							if($value == 1 || $value =="1"){
								$table .=  "</td>";
							}
							else{
								$table .=  " CCQ </td>";
							}
						}else{
							$table .= $value . "</td>";
						}
						
					}
				}
				
				$table  .= "</tr>";
			}
		}
		$table  .= "</tbody>";
		
		$table  .= "<tfoot><tr>";
		$table  .= "<td>Code</td>";
		$table  .= "<td>Prénom</td>";
		$table  .= "<td>Nom</td>";
		$table  .= "<td>Taux horaire</td>";
		$table  .= "<td>Département</td>";
		$table  .= "<td>Role</td>";
		$table  .= "</tr></tfoot>";
		return $table;
	}
}

/*
 for($i=0;$i<5;++$i){
 $anEmploye = new FastechEmploye();
 $anEmploye->setFirst_name("This is name $i");
 $anEmploye->setFamily_name("This is family name $i");
 $anEmploye->setDepartement("Usine");
 $anEmploye->setHour_rate(15);
 $anEmploye->addDBObject();
 }
 $employe = new FastechEmploye();
 $employe->getObjectFromDB(1);
 print_r($employe);
 $employes = $employe->getObjectListAsDynamicTable(true);
 echo "<pre>";
 print_r($employes);
 echo "</pre>";
*/
 

?>