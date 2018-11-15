<?php
	session_start();
	include("config.php");
     
	/*Connexion à la BDD */
	$link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis PHP 5.3


/* Vérification de la connexion */
if (mysqli_connect_errno()) {
    printf("Echec de la connexion : %s\n", $mysqli->connect_error);
    exit();
}
	
	if( isset($_SESSION['etat']) == false )
		$_SESSION['etat'] = "deconnecte";


	//On inclut le contrôleur s'il existe et s'il est spécifié
	if (!empty($_GET['page']) && is_file('controleurs/'.$_GET['page'].'.php'))
		include 'controleurs/'.$_GET['page'].'.php';
	else
		include 'controleurs/search.php';
    
  
	/*Fermeture de la connexion à la BDD*/
	mysqli_close($link); //depuis PHP 5.3
?>