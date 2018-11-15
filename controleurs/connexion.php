<?php 
	require dirname(__FILE__).'/../modeles/connexion.class.php';
	
	$connexion = new Connexion();
	$connexion->connecte_user($_POST['con_login'],$_POST['con_password']);
	header("Location: gestion");  //url rewritte htacess

?>