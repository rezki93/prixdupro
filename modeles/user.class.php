<?php
class User{
	public $user_id, $user_prenom, $user_nom, $user_region, $user_dep, $user_ville, $user_cp, $user_adresse, $user_email, $user_tel, $user_annonces;
	public $link;
	public function __construct(){
		$this->link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis PHP 5.3
	}
	
	public function recupérer_infos($id){
		
	}
		
	public function inscrire_user($prenom, $nom, $adresse, $tel, $mail, $ville, $region, $departement, $password){	
		$prenom = ucfirst(strtolower($prenom));
		$nom = ucfirst(strtolower($nom));
		$adresse = strtolower($adresse);
		$tel = $tel;
		$mail = strtolower($mail);
		$ville = ucfirst(strtolower($ville));
		$region = $region;
		$departement = $departement;
		$password = $password;
		
		$date = date('Y\-m\-d');

		$tab = array();
		$tab['reponse'] = 0 ; // 0 = erreur, 1 = OK, 2 = email deja prit
		  
		$chaine2 = "select mail_user FROM USERS WHERE USERS.mail_user = '".$mail."'";  
		$req_mail = mysqli_query($this->link,$chaine2);
		$num_mail = mysqli_num_rows($req_mail);
	  
		//L'adresse email est deja prise
		if($num_mail > 0){
		  $tab['reponse'] = 2;
		  return $tab;
		}
		
		//L'adresse mail est libre
		else if($num_mail == 0){
		  $chaine = "INSERT INTO `USERS` (`id_user`, `prenom_user`, `nom_user`, `tel_user`, `mail_user`, `adresse_user`, `ville_user`, `dep_user`,`region_user`, `password_user`, `date_inscription_user`, `ip_user`)
		  VALUES (NULL, '".$prenom."', '".$nom."', '".$tel."', '".$mail."', '".$adresse."', '".$ville."', '".$departement."', '".$region."', '".$password."', '".$date."', '".$_SERVER['REMOTE_ADDR']."');";
		  $req = mysqli_query($this->link,$chaine);
		  
		  
		  if($req == true){
			$tab['prenom'] = $prenom;
			$tab['nom'] = $nom;
			$tab['adresse'] = $adresse;
			$tab['tel'] = $tel;
			$tab['mail'] = $mail;
			$tab['ville'] = $ville;
			$tab['region'] = $region;
			$tab['departement'] = $departement;
			$tab['password'] = $password;
			$tab['reponse'] = 1;
			
			$chaine2 = "SELECT id_user FROM USERS WHERE USERS.mail_user = '".$mail."'";
			$req2 = mysqli_query($this->link,$chaine2);
			$res = Array();
			while ($data = mysqli_fetch_assoc($req2)){
				$res['user'] = $data;
			}

			// On détruit les variables de notre session
			session_unset ();  
			$_SESSION['etat'] = "connecte";
			$_SESSION['con_id'] = $res['user']['id_user'];
			$_SESSION['con_prenom'] = $tab['prenom'];
			$_SESSION['con_nom'] = $tab['nom'];
			$_SESSION['con_adresse'] = $tab['adresse'];
			$_SESSION['con_tel'] = $tab['tel'];
			$_SESSION['con_mail'] = $tab['mail'];
			$_SESSION['con_ville'] = $tab['ville'];
			$_SESSION['con_region'] = $tab['region'];
			$_SESSION['con_departement'] =  $tab['departement'] = $departement;
			
		  }
		  else
			$tab['reponse'] = 0;
		}
		  
			return $tab;
	}
	
}
?>