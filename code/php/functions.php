<?php

// /*-- URL avec route --*/
function url(string $route): string
{
	return BASE_URL . 'code/php/index.php?route=' . $route;
}

// /*-- redirection avec URL --*/
function redirection(string $route)
{
	header('location: ' . url($route));
 	die();
}

function titre(){
	if (!empty($_GET['id'])){
		echo ucfirst($_GET['id']);
	}
	else{
		echo ucfirst($_GET['route']);
	}
}

?>