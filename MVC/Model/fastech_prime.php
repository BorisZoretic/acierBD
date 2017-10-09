<?php
require_once'fastech_model.php';

class FastechPrime extends FastechModel {
	protected $table_name = 'prime';
	protected $primary_key = "order";
	
	protected $order =0;
	protected $name = '';
	protected $amount = 0;
	protected $id_state = 1; // 1 equals active by default
	
	function __construct() {
	}
	function getName() {
		return $this->name;
	}
	function getAmount() {
		return $this->amount;
	}
	function getid_state() {
		return $this->id_state;
	}
	function setName($aName) {
		$this->name = $aName;
	}
	function setAmount($anAmount) {
		$this->amount= $anAmount;
	}
	function setid_state($id_state) {
		$this->id_state = $id_state;
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
					if ($key != "table_name" && $key != "primary_key" && $key != "id_state" && $key != "order") {
						
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
	
}

?>