<?php
require_once 'fastech_model.php';
class FastechProject extends FastechModel {
	protected $table_name = 'projects';
	protected $primary_key = "id_project";
	
	protected $id_project = 0;
	protected $name = ' ';
	protected $start_date = '';
	protected $budget = 0;
	protected $production_total = 0;
	protected $bool_autre = 1;
	protected $id_state = 1; // 1 equals active by default
	
	function __construct() {
		$this->production_total = "0";
		$this->id_state = 1;
	}
	
	/**
	 * id_project
	 * 
	 * @return unkown
	 */
	public function getId_project() {
		return $this->id_project;
	}
	
	/**
	 * id_project
	 * 
	 * @param unkown $id_project        	
	 * @return FastechProject
	 */
	public function setId_project($id_project) {
		$this->id_project = $id_project;
		return $this;
	}
	
	/**
	 * name
	 * 
	 * @return unkown
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * name
	 * 
	 * @param unkown $name        	
	 * @return FastechProject
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	
	/**
	 * start_date
	 * 
	 * @return unkown
	 */
	public function getStart_date() {
		return $this->start_date;
	}
	
	/**
	 * start_date
	 * 
	 * @param unkown $start_date        	
	 * @return FastechProject
	 */
	public function setStart_date($start_date) {
		$this->start_date = $start_date;
		return $this;
	}
	
	/**
	 * budget
	 * 
	 * @return unkown
	 */
	public function getBudget() {
		return $this->budget;
	}
	
	/**
	 * budget
	 * 
	 * @param unkown $budget        	
	 * @return FastechProject
	 */
	public function setBudget($budget) {
		$this->budget = $budget;
		return $this;
	}
	
	/**
	 * production_total
	 * 
	 * @return unkown
	 */
	public function getProduction_total() {
		return $this->production_total;
	}
	
	/**
	 * production_total
	 * 
	 * @param unkown $production_total        	
	 * @return FastechProject
	 */
	public function setProduction_total($production_total) {
		$this->production_total = $production_total;
		return $this;
	}
	
	/**
	 * bool_autre
	 *
	 * @return Int
	 */
	public function getBool_autre() {
		return $this->bool_production;
	}
	
	/**
	 * bool_autre
	 *
	 * @param Int $bool_autre
	 * @return FastechProject
	 */
	public function setBool_autre($bool_autre) {
		$this->bool_autre= $bool_autre;
		return $this;
	}
	
	/**
	 * id_state
	 * 
	 * @return unkown
	 */
	public function getId_state() {
		return $this->id_state;
	}
	
	/**
	 * id_state
	 * 
	 * @param unkown $id_state        	
	 * @return FastechProject
	 */
	public function setId_state($id_state) {
		$this->id_state = $id_state;
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
							if ($key != "id_project") {
								if ($key == "production_total"){
									require_once 'fastech_employe_week_hours.php';
									$aWeekHour = new FastechEmployekWeekHours();
									$value = $aWeekHour->getProductionTotal($anObject[$id_object]);
									echo $id_object . "<br>";
									$this->production_total = $value;
									$this->updateDBObject();
									echo "<td class='cursorDefault'>$value h</td>";
								} else if($key != "bool_autre"){
									echo "<td><form table='" . $table_name . "' class='edit' idobj='" . $anObject [$id_object] . " '>";
									echo "<input  class='editable'  name='" . $key . "' value='" . $value . "'> </form></td>";
								}
								else{
									echo "<td><form table='" . $table_name . "' class='edit' idobj='" . $anObject [$id_object] . " '>";
									echo "<input ";
									if($value == "2"){
										echo "checked ";
									}
									echo  "type='checkbox' class='editable'  name='" . $key . "' value='" . $value . "'> </form></td>";
								}
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
	
	function getAutreHeader(){
		$aListOfObjects = $this->getListOfActiveBDObjects ();
		if ($aListOfObjects != null) {
			foreach ( $aListOfObjects as $anObject ) {
				foreach ( $anObject as $key => $value ) {
					if($key == "bool_autre" && $value == 2){
						echo "<th   attrval='" . $anObject['name'] . "' class='alignRight'>". $anObject['name']. "</th>";
						//echo "<th>" . $anObject['name'] . "</th>";
					}
				}
			}
		}
	}
	
	public function getObjectListAsStaticTableString() {
		$table = "";
		$aListOfObjects = $this->getListOfActiveBDObjects ();
		
		$table .= "<thead><tr>";
		$table .= "<td>Suffixe</td>";
		$table .= "<td>Date début</td>";
		$table .= "<td>Cumulatif production</td>";
		$table .= "<td>Budget</td>";
		$table .= "</tr></thead>";
		$table .= "<tbody>";
		if ($aListOfObjects != null) {
			foreach ( $aListOfObjects as $anObject ) {
				$compt =0;
				$table .= "<tr class=''>";
				foreach ( $anObject as $key => $value ) {
					if ($key != "table_name" && $key != "primary_key" && $key != "id_state") {
						if($compt>2){
							$table .= "<td>";
							$table .= $value . "</td>";
						}
						
					}
					$compt++;
				}
				
				$table .= "</tr>";
			}
		}
		$table .= "</tbody>";
		
		$table .= "<tfoot><tr>";
		$table .= "<td>Suffixe</td>";
		$table .= "<td>Date début</td>";
		$table .= "<td>Cumulatif production</td>";
		$table .= "<td>Budget </td>";
		$table .= "</tr></tfoot>";
		return $table;
	}
}

/*$employe = new FastechProject();
echo "<table><thead><tr>";
$employe->getAutreHeader();
echo "</tr></thead></table>";*/
?>