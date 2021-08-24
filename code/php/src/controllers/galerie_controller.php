<?php
    require DOSSIER_MODELS . '/Projet.php';

function projetAll(){
    $projetListe = Projet::all();
    if (isset($_GET['id'])) {
		if ($_GET['id']=="game"){
            include DOSSIER_VIEWS . '/game.html.php';
        }
        elseif ($_GET['id']=="web"){
            include DOSSIER_VIEWS . '/game.html.php';
        }
        elseif ($_GET['id']=="sprite"){
            $tri = $_GET['id'];
            include DOSSIER_VIEWS . '/modelisation.html.php';
        }
        elseif ($_GET['id']=="modelisation"){
            $tri = $_GET['id'];
            include DOSSIER_VIEWS . '/modelisation.html.php';
        }

	} else {
		// include  DOSSIER_VIEWS . '/errors/404.html.php';
	}
}



?>