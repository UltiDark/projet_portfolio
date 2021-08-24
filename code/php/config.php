<?php

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASSWORD = '';
const DB_NAME = 'portfolio';


const DOSSIER_MODELS = __DIR__ . '/src/models';
const DOSSIER_VIEWS = __DIR__ . '/views';
const DOSSIER_CONTROLLERS = __DIR__ . '/src/controllers';
const DOSSIER_ASSETS = __DIR__ . '/assets';
const DOSSIER_MEDIA = __DIR__ . 'media/';
const DOSSIER_TYPO = __DIR__ . 'typo/';

const BASE_URL = 'http://localhost/site/projet_portfolio/';
const MAX_FILE_SIZE = 5_000_000; // Taille max des fichiers (5 Mo)

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);

if ($conn->connect_error)
	die(sprintf('Unable to connect to the database. %s', $conn->connect_error));

SimpleOrm::useConnection($conn, DB_NAME);

?>