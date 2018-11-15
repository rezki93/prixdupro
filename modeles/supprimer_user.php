<?php
include(dirname(__FILE__).'/supprimer_annonce.php');


//fonction qui supprime une annonces, et les photos liées
function supprimer_user()
{
	$link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis php5.3
	$user = $_SESSION['con_id'];
	$mdp = $_GET['mdp'];
	$t = Array();
	
	$c = "select password_user
		FROM USERS		
		WHERE USERS.id_user = '".$user."'"
		;
	$r = mysqli_query($link,$c);
	while ($data = mysqli_fetch_assoc($r)){
		$t[] = $data;
	}
	
		
	if($mdp == $t[0]['password_user']){
		$tab = Array();
		$chaine = "select id_annonce, id_user, cat_annonce
		FROM ANNONCES		
		WHERE ANNONCES.id_user = '".$user."'"
		;
		$req = mysqli_query($link,$chaine);
		while ($data = mysqli_fetch_assoc($req)){
			$tab[] = $data;
		}
		
		foreach($tab as $n){
			
			if($n['cat_annonce'] == 1 ){ //si cat_auto on supprime
				$chaine2="DELETE FROM cat_auto WHERE cat_auto.id_auto ='".$n['id_annonce']."'";
				$req2= mysqli_query($link,$chaine2);
			}
			// on supprime l'annonce
			$chaine3="DELETE FROM ANNONCES WHERE ANNONCES.id_annonce ='".$n['id_annonce']."'";
			$req3 = mysqli_query($link,$chaine3);
			
			$chemin = 'upload/'.$n['id_annonce'].'/';
			if(is_dir($chemin))
				sup_repertoire($chemin);
		}
		
		//puis on supprime l'utilisateur
		$chaine4="DELETE FROM USERS WHERE USERS.id_user ='".$user."'";
		$req4 = mysqli_query($link,$chaine4);
	}
	
}
