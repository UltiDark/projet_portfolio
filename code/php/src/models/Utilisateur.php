<?php

/*-- Ajout d'une class Utilisateur dans l'ORM --*/
class Utilisateur extends SimpleOrm {
	public $id;
	public $identifiant;
	public $mot_de_passe;
	public $email;
}

?>