<?php
require_once "class_eleve.php";
require_once "class_singleton.php";

class Classe {
    
    
    public static function getClasse() {
        $db_connect= Db_connect::getInstance();


        $requete = "SELECT id, nom, prenom, date_naiss, moyenne, appreciation FROM eleve";
        $stmt = $db_connect->query($requete);

        return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Eleve');
		
	}
}