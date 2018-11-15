<?php
class Connexion{
	public $link;

	public function __construct(){
		$this->link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis PHP 5.3
	}

	public function connecte_user($a,$b){
		$con_login = strtolower($a);
		$con_password = $b;
		
		$tab = array();
		$tab['reponse'] = 0 ; // 0 = erreur, 1 = OK
		
		$chaine = "select *
		FROM USERS
		WHERE USERS.mail_user = '".$con_login."' and USERS.password_user = '".$con_password."'";

		$req = mysqli_query($this->link,$chaine);
		while ($data = mysqli_fetch_assoc($req)){
			$tab['infos_user'] = $data;
		}
		
		if(mysqli_num_rows($req)==1){
		  $tab['reponse'] = 1;  
		  
		  // On détruit les variables de notre session
		  session_unset ();  
		  
		  $_SESSION['con_id'] = $tab['infos_user']['id_user'];
		  $_SESSION['con_prenom'] = $tab['infos_user']['prenom_user'];
		  $_SESSION['con_nom'] = $tab['infos_user']['nom_user'];
		  $_SESSION['con_adresse'] = $tab['infos_user']['adresse_user'];
		  $_SESSION['con_tel'] = $tab['infos_user']['tel_user'];
		  $_SESSION['con_mail'] = $tab['infos_user']['mail_user'];
		  $_SESSION['con_ville'] = $tab['infos_user']['ville_user'];
		  $_SESSION['con_departement'] = $tab['infos_user']['dep_user'];
		  $_SESSION['con_region'] = $tab['infos_user']['region_user'];
		  $_SESSION['etat'] = "connecte";
		  
		}
		else	$_SESSION['etat'] = "deconnecte";
		
		return $tab;
	}
	
	public function deconnecte_user(){
		session_unset ();  
		session_destroy ();   
		$_SESSION['etat'] = "deconnecte";
	}
	
	
	
}