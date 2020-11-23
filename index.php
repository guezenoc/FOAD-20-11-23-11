<?php

//Connexion BDD
require_once "inc/class_singleton.php";
require_once "functions.php";
require_once "inc/class_eleve.php";
require_once "inc/class_classe.php";


$eleve = Classe::getClasse();


/* PHASE RENDU */

require_once "html_avant.php";
?>
<head>
	<link rel="stylesheet/less" type="text/css" href="css/style.less" />
	<script src="//cdn.jsdelivr.net/npm/less" ></script>
</head>
<body>
	
<a href="fiche.php">Ajouter un eleve</a>

<table id="eleve">
	<thead>
		<tr>
			<th>nom</th>
			<th>prenom</th>
			<th>Date de naissance</th>
			<th>moyenne</th>
			<th>appréciation</th>
		</tr>
	</thead>
	<tbody>
		
<?php for ($i=0; $i<count($eleve); $i++) { ?>
		<tr>
			<td><a href="fiche.php?id=<?= $eleve[$i]->ID ?>"><?= $eleve[$i]->nom ?></a></td>
			<td><?= $eleve[$i]->prenom ?></td>
			<td><?= $eleve[$i]->date_naiss ?></td>
			<td><?= $eleve[$i]->moyenne ?></td>
			<td><?= $eleve[$i]->appreciation ?></td>
		</tr>
<?php } ?>
<tfoot>
Il y a <strong><?= Eleve::$nombre_eleve?></strong> éleves. La moyenne de la classe est <strong><?= Eleve::$moyenne_classe ?></strong></tfoot>
</table>
<?php
require_once "html_apres.php";
?>
</body>

	
	
	
