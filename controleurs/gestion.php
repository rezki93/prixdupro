<?php

//On inclut le modèle
include(dirname(__FILE__).'/../modeles/gestion.php');
include(dirname(__FILE__).'/../modeles/supprimer_user.php');
include(dirname(__FILE__).'/../modeles/modifier_mdp.php');

if(isset($_SESSION['con_id'])){
	$annonces = recuperer_toutes_annonces();
	$favoris = recuperer_favoris();
	
	if(!isset($_GET['rub']) || $_GET['rub'] == 'acceuil')
		include(dirname(__FILE__).'/../vues/gestion.php');
	else{
		if($_GET['rub'] == 'supprimer_user' && isset($_GET['mdp']) ){
			supprimer_user();
			include(dirname(__FILE__).'/../modeles/deconnexion.php');
			include(dirname(__FILE__).'/search.php');
		}
		if($_GET['rub'] == 'modif_mdp' && isset($_GET['mdp']) && isset($_GET['mdp2']) ){
			echo modifier_mdp($_GET['mdp'],$_GET['mdp2']);
			
		}
	}
}
else
	include(dirname(__FILE__).'/../controleurs/search.php');
	



?>