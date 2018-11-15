<?php
	include("../config.php");
	require '../modeles/annonce.class.php';
	require '../modeles/annonces.class.php';
	
	$annonces = new Annonces();
	//$annonces->nettoyer_annonces_anciennes() //Nettoie les annonces trop anciennes
	$annonces->creerSitemap(); //Cree le sitemap
	
	
	

?>