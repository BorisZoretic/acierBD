<?php
require_once 'fastech_model.php';

class FastechPrimePayement extends FastechModel {
	protected $table_name = 'prime_payement';
	protected $primary_key = "id_prime_payement";
	
	protected $id_prime_payement= 0;
	protected $id_payement= 0;
	protected $prime = 0;
	protected $amount= 0;
	protected $id_state = 1; // 1 equals active by default
	
	function __construct() {
	}


    /**
     * id_prime_payement
     * @return unkown
     */
    public function getId_prime_payement(){
        return $this->id_prime_payement;
    }

    /**
     * id_prime_payement
     * @param unkown $id_prime_payement
     * @return FastechPrime
     */
    public function setId_prime_payement($id_prime_payement){
        $this->id_prime_payement = $id_prime_payement;
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
     * @return FastechPrime
     */
    public function setId_payement($id_payement){
        $this->id_payement = $id_payement;
        return $this;
    }

    /**
     * prime
     * @return unkown
     */
    public function getPrime(){
        return $this->prime;
    }

    /**
     * prime
     * @param unkown $prime
     * @return FastechPrime
     */
    public function setPrime($prime){
        $this->prime = $prime;
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
     * @return FastechPrime
     */
    public function setAmount($amount){
        $this->amount = $amount;
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
    
    public function getPayementPrimeFromDB($prime, $id_payement) {
    	include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
    	
    	$internalAttributes = get_object_vars ( $this );
    	
    	$sql = "SELECT * FROM `" . $this->table_name . "` WHERE prime ='" . $prime . "' AND id_payement = $id_payement";
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
    
    public function getObjectListAsDynamicTableTableForWeek($prime, $id_payement) {
    	require_once 'fastech_prime.php';
    	$anObject = $this->getPayementPrimeFromDB($prime, $id_payement);
    	if ($anObject != null) {
    		/*$localPayed=0;
    		$localRegular = 0;
    		$locaHalf = 0;*/
    		foreach ( $anObject as $key => $value ) {
    			
    			if ($key == "amount") {
    				$id_object = $anObject ["primary_key"];
    				$table_name = $anObject ["table_name"];
    				
    				
    				$aPrime = new FastechPrime();
    				$aPrime->getObjectFromDB($prime);
    				
    				
    				/*echo "<td><form style='display:table;float:left;' table='" . $table_name . "' class='edit col-lg-6' idObj='" . $anObject [$id_object] . " '>";
    				echo "<input class='editable' name='" . $key . "' value='" . $value . "'></form> / <span class='col-lg-6 cursorDefault'>" . $value * $aPrime->getAmount() . " $</span></td>";*/
    				
    				echo "<td><form style='display:table;' table='" . $table_name . "' class='edit col-lg-4' idObj='" . $anObject [$id_object] . " '>";
    				echo "<input class='editable' name='" . $key . "' value='" . $value . "'></form></td><td style='min-width: 100px;' class='cursorDefault'>" . $value * $aPrime->getAmount() . " $</td>";
    			}
    		}
    		
    		
    		
    		/*$locaHalf= $localPayed-$localRegular;
    		echo "<td>$locaHalf</td>";*/
    	} else {
    		include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
    		$aPrimePayement = new FastechPrimePayement();
    		$aPrimePayement->setId_prime_payement(null);
    		$aPrimePayement->setId_payement($id_payement);
    		$aPrimePayement->setAmount('0');
    		$aPrimePayement->setPrime($prime);
    		
    		
    		//print_r($aPayement);
    		//if prime normal
    		
    		$aPrimePayement->addDBObject();
    		
    		$conn->close ();
    		
    		$this->getObjectListAsDynamicTableTableForWeek ( $prime, $id_payement);
    	}
    }

}

/*$payement = new FastechPrimePayement();
$payement->getObjectListAsDynamicTableTableForWeek("Peinture", 1);*/

?>