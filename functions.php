<?php

/** Fonction qui assainit les données depuis le POST
**/
function assainit_texte($cle) {
	if (isset($_POST[$cle])) {
		return htmlspecialchars(trim(strip_tags($_POST[$cle])));
	}
}

function assainit_entier($cle) {
	if (isset($_POST[$cle])) {
		return intval($_POST[$cle]);
	}
	return 0;
}

function assainit_float($cle) {
	if (isset($_POST[$cle])) {
		return floatval($_POST[$cle]);
	}
	return 0;
}