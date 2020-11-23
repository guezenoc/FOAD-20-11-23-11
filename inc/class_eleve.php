<?php

require_once "class_singleton.php";

class Eleve {
	//attributs
	public $ID;
	public $nom;
	public $prenom;
	public $date_naiss;
	public $moyenne;
	public $appreciation;
	public static $nombre_eleve;
	public static $total_note;
	public static $moyenne_classe;

	//fonction qui construit un objet eleve
	function __construct() {
		$this->id = 0;
		$this->nom = "";
		$this->prenom = "";
		$this->date_naiss = new DateTime();
		$this->moyenne = 0;
		$this->appreciation = "";
	}
	
	//on modifie la fonction construct de l'objet eleve
	
	
	public static function loadUnEleve($id) {
		$eleve = new Eleve();
		
		//sql
		$requete = "SELECT nom, prenom, date_naiss, moyenne, appreciation FROM eleve WHERE ID=:ID";
		$stmt = $db_connect->connexion->prepare($requete);
		$stmt->bindParam(':ID', $this->ID, PDO::PARAM_INT);
		$stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);
		$stmt->bindParam(':prenom', $this->prenom, PDO::PARAM_STR);
		$stmt->bindParam(':date_naiss', $this->date_naiss->format("Y-m-d H:i:s"), PDO::PARAM_STR);
		$stmt->bindParam(':moyenne', $this->moyenne, PDO::PARAM_INT);
		$stmt->bindParam(':appreciation', $this->appreciation, PDO::PARAM_STR);
		$stmt->execute();
		$resultat = $stmt->fetch(PDO::FETCH_ASSOC);
		$this->id = $id;
		$this->nom = $resultat['nom'];
		$this->prenom = $resultat['prenom'];
		$this->date_naiss = new DateTime($resultat['date_naiss']);
		$this->moyenne = $resultat['moyenne'];
		$this->appreciation = $resultat['appreciation'];
		
		return $eleve;
	} 
	public static function eleve($id) {
		$eleve = new Eleve();

		$requete= "INSERT INTO eleve (nom, prenom, date_naiss, moyenne, appreciation) VALUES (:nom, :prenom, :date_naiss, :moyenne, :appreciation)";
		$stmt = $db_connect->connexion->prepare($requete);
			return $stmt->execute(array(
				":nom"	=>	$this->nom,
				":prenom"	=>	$this->prenom,
				":date_naiss"	=>	$this->date_naiss,
				":moyenne"	=>	$this->moyenne,
				":appreciation" => $this->appreciation
			));
	}
	public function __get($att){
        return $this->$att;
    }
	public function setId($id) {
			$this->id = assainit_entier($id);
	}
	
	public function setnom($nom) {
		$this->nom = assainit_texte($nom);
	}
	public function setprenom($prenom) {
		$this->prenom = assainit_texte($prenom);
	}
	
	
	public function getDateFormatSql() {
		return $this->date_naiss->format("Y-m-d");
	}
	
	public function setDateNaiss($date_naiss) {
			$this->date_naiss = new DateTime(assainit_texte($date_naiss));
	}
	
	public function setMoyenne($moyenne) {
			$this->moyenne = assainit_float($moyenne);
	}
	
	public function setAppreciation($appreciation) {
			$this->appreciation = assainit_texte($appreciation);
	}
	
	
}