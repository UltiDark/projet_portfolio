<?php

/*-- Pré requis --*/
require __DIR__ . '/functions.php';
require __DIR__ . '/SimpleOrm.class.php';
require __DIR__ . '/config.php';

/*-- Connection BDD et ORM --*/
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);

if ($conn->connect_error)
	die(sprintf('Unable to connect to the database. %s', $conn->connect_error));

SimpleOrm::useConnection($conn, DB_NAME);

/*-- Systeme de route pour dirigé d'une page à l'autre grâce au controller --*/
if (isset($_GET['route'])) {
	$route = $_GET['route'];

	if ($route == "projet")
	{
		require DOSSIER_CONTROLLERS . '/galerie_controller.php';
		projetAll();
	}
	elseif ($route == 'contact')
	{
		require DOSSIER_VIEWS . '/contact.html.php';
	}
	elseif ($route == 'accueil')
	{
		require DOSSIER_CONTROLLERS . '/info_controller.php';
		domaine();
	}
	else
	{
		//Erreur
	}
}
else
{
    redirection('accueil');	
}
