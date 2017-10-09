<?php
require_once'fastech_model.php';

class FastechBanque extends FastechModel {
	protected $table_name = 'banque';
	protected $primary_key = "id_banque";
	
	protected $id_banque = 0;
	protected $id_employe = 0;
	protected $hours = 0;
	protected $id_state = 1; // 1 equals active by default
	
	function __construct() {
	}
	
    /**
     * id_banque
     * @return int
     */
    public function getId_banque(){
        return $this->id_banque;
    }

    /**
     * id_banque
     * @param int $id_banque
     * @return FastechBanque
     */
    public function setId_banque($id_banque){
        $this->id_banque = $id_banque;
        return $this;
    }

    /**
     * id_employe
     * @return int
     */
    public function getId_employe(){
        return $this->id_employe;
    }

    /**
     * id_employe
     * @param int $id_employe
     * @return FastechBanque
     */
    public function setId_employe($id_employe){
        $this->id_employe = $id_employe;
        return $this;
    }

    /**
     * hours
     * @return double
     */
    public function getHours(){
        return $this->hours;
    }

    /**
     * hours
     * @param double $hours
     * @return FastechBanque
     */
    public function setHours($hours){
        $this->hours = $hours;
        return $this;
    }

    /**
     * id_state
     * @return int
     */
    public function getId_state(){
        return $this->id_state;
    }

    /**
     * id_state
     * @param int $id_state
     * @return FastechBanque
     */
    public function setId_state($id_state){
        $this->id_state = $id_state;
        return $this;
    }

}

?>