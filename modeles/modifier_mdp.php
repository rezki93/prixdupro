<?php

//fonction qui supprime une annonces, et les photos liées
function modifier_mdp($mdp, $mdp2)
{
	$link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis php5.3
	$id_user = $_SESSION['con_id'];
	$mdp = $_GET['mdp'];
	
	$tab = Array();
	$chaine = "	select password_user FROM USERS WHERE id_user = '".$id_user."'";
	$req = mysqli_query($link,$chaine);
	while ($data = mysqli_fetch_assoc($req)){
		$tab = $data;
	}
	
	if( $mdp == $tab['password_user'] )
	{
		$chaine="UPDATE USERS SET password_user = '" . $mdp2 . "' WHERE id_user = '" . $id_user . "'";  
		$req2 = mysqli_query($link,$chaine);
	}
	else
		return "Le mot de passe actuel est incorrect";
	
	if($req2){
		require_once 'libs/Swift-4.1.0/lib/swift_required.php';
		$msg ="	Bonjour ".$_SESSION['con_prenom']." ".$_SESSION['con_nom'].",<br> Voici votre nouveau mot de passe :" . $_GET['mdp2'] . "
				<br><br>Bonne journ&eacute;e
				<br><br><img src='http://www.prixdupro.fr/images/banniere%20prixdupro.gif' />
				" ;
		$message = Swift_Message::newInstance()
		->setSubject("Reinitialisation de mot de passe sur Prixdupro")
		->setFrom(array('ne-pas-repondre@prixdupro.fr' => 'Prixdupro'))
		->setTo(array($_SESSION['con_mail']))
		->setBody($msg, 'text/html');
		$transport = Swift_MailTransport::newInstance();
		$mailer = Swift_Mailer::newInstance($transport);
		
		$mailer->send($message);
		return true;
	}
	else
		return "La modification n'a pas ete prise en compte";
	
	
	
}
