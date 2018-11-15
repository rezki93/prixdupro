<?php

//On inclut le modèle
include(dirname(__FILE__).'/../modeles/supprimer_annonce.php');
require 'modeles/annonce.class.php';


$ref = $_GET['ref'];

if(is_numeric($ref) && ($ref != "")){
	$a = new Annonce();
	$a->recuperer_une_annonce($ref);
	if($_SESSION['con_id'] == $a->id_user)
		$a->supprimer_annonce();
		
}

// supprimer_annonce($ref);
header("Location: gestion");  //url rewritte htacess

?>