<?php
require_once 'fastech_model.php';

class FastechDepartement extends FastechModel {
	protected $table_name = 'departement';
	protected $primary_key = "order";
	
	protected $order =0;
	protected $name = '';
	protected $amount = 0;
	protected $bool_production = 1;
	protected $id_state = 1; // 1 equals active by default
	
	function __construct() {
	}

    /**
     * name
     * @return unkown
     */
    public function getName(){
        return $this->name;
    }

    /**
     * name
     * @param unkown $name
     * @return FastechDepartement
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }

    /**
     * amount
     * @return unkown
     */
    public function getAmount(){
        return $this->amount;
    }

    /**
     * amount
     * @param unkown $amount
     * @return FastechDepartement
     */
    public function setAmount($amount){
        $this->amount = $amount;
        return $this;
    }
    
    /**
     * bool_production
     *
     * @return Int
     */
    public function getBool_production() {
    	return $this->bool_production;
    }
    
    /**
     * bool_production
     *
     * @param Int $bool_production
     * @return FastechEmploye
     */
    public function setBool_production($bool_production) {
    	$this->bool_production= $bool_production;
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
     * @return FastechDepartement
     */
    public function setId_state($id_state){
        $this->id_state = $id_state;
        return $this;
    }
    
    
    /**
     * order
     * @return unkown
     */
    public function getOrder(){
    	return $this->order;
    }
    
    /**
     * order
     * @param unkown $order
     * @return FastechDepartement
     */
    public function setOrder($order){
    	$this->order = $order;
    	return $this;
    }
    
    function getObjectListAsDynamicTable($showPrimaryKey = true) {
    	$aListOfObjects = $this->getListOfActiveBDObjects ();
    	if ($aListOfObjects != null) {
    		foreach ( $aListOfObjects as $anObject ) {
    			
    			echo "<tr class='tableHover'>";
    			foreach ( $anObject as $key => $value ) {
    				
    				if ($key != "table_name" && $key != "primary_key" && $key != "id_state") {
    					$id_object = $anObject ["primary_key"];
    					$table_name = $anObject ["table_name"];
    					if ($key != "bool_production") {
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
    				}
    			}
    			
    			echo "</tr>";
    		}
    	}
    }
    
    public function  getObjectListAsStaticTableString() {
    	$table ="";
    	$aListOfObjects = $this->getListOfActiveBDObjects ();
    	
    	$table  .= "<thead><tr>";
    	$table  .= "<td>Nom</td>";
    	$table  .= "<td>Taux ($/h)</td>";
    	$table  .= "</tr></thead>";
    	$table  .= "<tbody>";
    	if ($aListOfObjects != null) {
    		foreach ( $aListOfObjects as $anObject ) {
    			
    			$table  .= "<tr class=''>";
    			foreach ( $anObject as $key => $value ) {
    				if ($key != "table_name" && $key != "primary_key" 
    						&& $key != "id_state" && $key != "order" 
    						&& $key != "bool_production") {
    					
    					$table  .= "<td>";
    					$table .= $value . "</td>";
    				}
    			}
    			
    			$table  .= "</tr>";
    		}
    	}
    	$table  .= "</tbody>";
    	
    	$table  .= "<tfoot><tr>";
    	$table  .= "<td>Nom</td>";
    	$table  .= "<td>Taux ($/h)</td>";
    	$table  .= "</tr></tfoot>";
    	return $table;
    }
    
    function getObjectListAsDynamicHeader($showPrimaryKey = true, $idrevient) {
    	$aListOfObjects = $this->getListOfActiveBDObjects();
    	$onlyOnce = 0;
    	if ($aListOfObjects != null) {
    		foreach ( $aListOfObjects as $anObject ) {
    			foreach ( $anObject as $key => $value ) {
    				if($key == "table_name" && $value == "departement" && $onlyOnce == 0){
    					echo "<th class='borderThick'>" . $this->findSuffixe($idrevient) . "</th>";
    					$onlyOnce++;
    				}
    				if ($key != "table_name" && $key != "primary_key" && $key != "id_state") {
    					if($showPrimaryKey == true){
    						if(!is_numeric($value))
    							
    							if($this->table_name == "prime"){
    								echo "<th attrval='$value' typeHeader='" . $this->table_name . "' class='alignRight'  colspan='2'>". $value ." " .$anObject["amount"].  "$/h</th>";
    						}else{
    							echo "<th  attrval='$value' typeHeader='" . $this->table_name . "' class='alignRight' >". $value . "</th>";
    						}
    						
    					} else {
    						if(is_numeric($value) && $key == "amount")
    							
    							if($this->table_name == "prime"){
    								echo "<th  attrval='$value' typeHeader='" . $this->table_name . "' class='alignRight' colspan='2'>". $value ." " .$anObject["amount"].  "$/h</th>";
    						}else{
    							echo "<th   attrval='$value' class='alignRight'>". $value . " $/h</th>";
    						}
    					}
    				}
    			}
    			
    		}
    		echo "<th></th><th>total</th>";
    	}
    }
    
    function findSuffixe($idrevient){
    	include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
    	$name = '';
    	
    	$sql = "SELECT suffixe FROM prix_revient WHERE id_prix_revient = " . $idrevient;
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

 

}

?>