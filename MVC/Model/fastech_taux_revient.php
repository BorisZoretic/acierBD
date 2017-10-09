<?php
require_once'fastech_model.php';

class FastechTauxRevient extends FastechModel {
	protected $table_name = 'taux_revient';
	protected $primary_key = "taux";
	
	protected $taux =0;
	protected $id_state = 1; // 1 equals active by default
	
	function __construct(){}
	
    /**
     * taux
     * @return DOUBLE
     */
    public function getTaux(){
        return $this->taux;
    }

    /**
     * taux
     * @param DOUBLE $taux
     * @return FastechTauxRevient
     */
    public function setTaux($taux){
        $this->taux = $taux;
        return $this;
    }

    /**
     * id_state
     * @return INT
     */
    public function getId_state(){
        return $this->id_state;
    }

    /**
     * id_state
     * @param INT $id_state
     * @return FastechTauxRevient
     */
    public function setId_state($id_state){
        $this->id_state = $id_state;
        return $this;
    }

}

?>