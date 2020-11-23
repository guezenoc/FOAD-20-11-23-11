<?php

//Connexion BDD
require_once "inc/class_singleton.php";
require_once "functions.php";
require_once "inc/class_eleve.php";

$db_connect= Db_connect::getInstance();

/* PHASE LOGIQUE = on traite les données puis on prépare les données pour l'affichage */

if (!empty($_POST)) {
	//création variables
	$eleve = new Eleve();
	
	$eleve->setId("id");
    $eleve->setNom("nom");
	$eleve->setPrenom("prenom");
    $eleve->setDateNaiss($_POST['date_naiss']);
    $eleve->setMoyenne("moyenne");
    $eleve->setAppreciation("appreciation");
	
	if ($_POST['id']) {
		//edition
		$requete = "UPDATE eleve SET nom=:nom, prenom=:prenom, date_naiss=:date_naiss, moyenne=:moyenne, appreciation=:appreciation WHERE ID=:ID";
		$stmt = $db_connect->prepare($requete);
		$stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);
		$stmt->bindParam(':prenom', $this->prenom, PDO::PARAM_STR);
		$stmt->bindParam(':date_naiss', strtotime(date("Y-m-d")), PDO::PARAM_STR);
		$stmt->bindParam(':moyenne', $this->moyenne, PDO::PARAM_STR);
		$stmt->bindParam(':appreciation', $this->appreciation, PDO::PARAM_STR);
		$req_id = $eleve->id;
		$req_nom = $eleve->nom;
		$req_prenom = $eleve->prenom;
		$req_date_naiss = $eleve->getDateFormatSql();
		$req_moyenne= $eleve->moyenne;
		$req_appreciation = $eleve->appreciation;
		$stmt->execute();
		$stmt->close();
	} else {
		//creation
		$req = "INSERT INTO eleve (nom, prenom, date_naiss, moyenne, appreciation) VALUES (:nom, :prenom, :date_naiss, :moyenne, :appreciation)";
		$stmt= $db_connect->prepare($req);

		$stmt->bindParam(':nom', $eleve->nom, PDO::PARAM_STR);
		$stmt->bindParam(':prenom', $eleve->prenom, PDO::PARAM_STR);
		$stmt->bindParam(':date_naiss', '2020-05-01', PDO::PARAM_STR);
		$stmt->bindParam(':moyenne', $eleve->moyenne, PDO::PARAM_STR);
		$stmt->bindParam(':appreciation', $eleve->appreciation, PDO::PARAM_STR);
		

		$stmt->execute();
		$eleve->id = $stmt->insert_id;
		$stmt->close();
	}
	
	header("Location: fiche.php?id=$eleve->id");
}
		
		if (!empty($_GET['id'])) {
			//Récuperer les infos depuis la BDD
			$id = intval($_GET['id']);
			$eleve = Eleve::loadUnEleve($id);
		}
		
/* PHASE RENDU */

//require_once "html_avant.php";
?>
<head>
<script src= jquery/jquery-3.4.1.min.js></script>
<script src= jquery/jquery.validate.min.js></script>
<script>
	$(function(){
		$('#updateform').validate();
	})

</script>
</head>

<form method="POST" id="updateform">
	<a href="index.php">Revenir à la liste des élèves</a>
		<input type="text" name="nom" placeholder="nom" value="<?php if (isset($eleve)) { echo $eleve->nom; } ?>" required/>
		<input type="text" name="prenom" placeholder="prenom" value="<?php if (isset($eleve)) { echo $eleve->prenom; } ?>" required/>
		<input type="date" name="date_naiss" placeholder="Date de naissance" value="<?php if (isset($eleve)) { echo $eleve->getDateFormatSql(); } ?>" required/>
		<input type="number" name="moyenne" placeholder="Note/20" step="0.1" value="<?php if (isset($eleve)) { echo $eleve->moyenne; } ?>" required/>
		<textarea name="appreciation" placeholder="Appréciation..." required ><?php if (isset($eleve)) { echo $eleve->appreciation; } ?></textarea> 
		<input type="hidden" name="id" value="<?php if (isset($eleve)) { echo $eleve->id; } ?>" required/>
		<input type="submit" />
	</form>
<?php
//require_once "html_apres.php";
?>