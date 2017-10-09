<?php
require_once 'fastech_model.php';

class FastechTauxDepartemenRevient extends FastechModel {
	protected $table_name = 'taux_departement_revient';
	protected $primary_key = "id_taux_departement_revient";
	
	protected $id_prix_revient= 0;
	protected $departement= '';
	protected $begin_date = '';
	protected $end_date = '';
	protected $taux = 0;
	protected $id_state = 1; // 1 equals active by default
	
	function __construct() {
	}

    /**
     * id_prix_revient
     * @return int
     */
    public function getId_prix_revient(){
        return $this->id_prix_revient;
    }

    /**
     * id_prix_revient
     * @param int $id_prix_revient
     * @return FastechTauxDepartemenRevient
     */
    public function setId_prix_revient($id_prix_revient){
        $this->id_prix_revient = $id_prix_revient;
        return $this;
    }

    /**
     * departement
     * @return string
     */
    public function getDepartement(){
        return $this->departement;
    }

    /**
     * departement
     * @param string $departement
     * @return FastechTauxDepartemenRevient
     */
    public function setDepartement($departement){
        $this->departement = $departement;
        return $this;
    }

    /**
     * begin_date
     * @return date
     */
    public function getBegin_date(){
        return $this->begin_date;
    }

    /**
     * begin_date
     * @param date $begin_date
     * @return FastechTauxDepartemenRevient
     */
    public function setBegin_date($begin_date){
        $this->begin_date = $begin_date;
        return $this;
    }

    /**
     * end_date
     * @return date
     */
    public function getEnd_date(){
        return $this->end_date;
    }

    /**
     * end_date
     * @param date $end_date
     * @return FastechTauxDepartemenRevient
     */
    public function setEnd_date($end_date){
        $this->end_date = $end_date;
        return $this;
    }

    /**
     * taux
     * @return double
     */
    public function getTaux(){
        return $this->taux;
    }

    /**
     * taux
     * @param double $taux
     * @return FastechTauxDepartemenRevient
     */
    public function setTaux($taux){
        $this->taux = $taux;
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
     * @return FastechTauxDepartemenRevient
     */
    public function setId_state($id_state){
        $this->id_state = $id_state;
        return $this;
    }
    
    
    public function getObjectListAsDynamicTableForRevient($id) {
        $aListOfObjects = $this->getListOfActiveBDObjects ();
        if ($aListOfObjects != null) {
            foreach ( $aListOfObjects as $anObject ) {
                if($anObject['id_prix_revient'] == $id){
                    echo "<tr class='tableHover'>";
                    foreach ( $anObject as $key => $value ) {
                        
                        if ($key != "table_name" && $key != "primary_key" && $key != "id_state" && $key != "id_prix_revient" && $key != "id_taux_departement_revient") {
                            echo "<td>" . $value . "</td>";
                        }
                    }
                    
                    echo "<td class='tdDeleteSpec'><a idItem='" . $anObject['id_taux_departement_revient'] . "' class='cursor clickDeleteSpec underlineBtn' idRevient='" . $anObject['id_prix_revient'] . "' typeName='deleteSpec'>Supprimer</a></td></tr>";
                }
            }
        }
    }
    
    function getListOfActiveBDObjectsWithId($id) {
        include $_SERVER ["DOCUMENT_ROOT"] . '/AcierBD/Acier/database_connect.php';
        
        $internalAttributes = get_object_vars ( $this );
        
        $sql = "SELECT * FROM `" . $this->table_name . "` WHERE id_state = 1 AND id_prix_revient = '" . $id . "'";
        $result = $conn->query ( $sql );
        
        if ($result->num_rows > 0) {
            $fastechObjects = array ();
            while ( $row = $result->fetch_assoc () ) {
                $anObject = Array ();
                $anObject ["primary_key"] = $this->primary_key;
                $anObject ["table_name"] = $this->table_name;
                foreach ( $row as $aRowName => $aValue ) {
                    $anObject [$aRowName] = $aValue;
                }
                
                $fastechObjects [$row [$this->primary_key]] = $anObject;
            }
            
            $conn->close ();
            return $fastechObjects;
        }
        $conn->close ();
        return null;
    }

}

?>