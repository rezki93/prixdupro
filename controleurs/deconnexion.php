<?php
	require dirname(__FILE__).'/../modeles/connexion.class.php';
	$connexion = new Connexion();
	$connexion->deconnecte_user();
	header("Location: recherche");  //url rewritte htacess
?>