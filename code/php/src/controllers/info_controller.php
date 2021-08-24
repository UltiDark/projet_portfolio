<?php
    require DOSSIER_MODELS . '/Domaine.php';
    require DOSSIER_MODELS . '/Frise.php';

function domaine(){
    $domainesListe = Domaine::all();
    $frisesListe = Frise::all();
	include DOSSIER_VIEWS . '/home.html.php';
}

?>