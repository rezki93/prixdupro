<?php
	//On inclut le modèle
	require dirname(__FILE__).'/../modeles/user.class.php';
	require_once 'libs/Swift-4.1.0/lib/swift_required.php';

	$link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis php5.3
    $prenom = ucfirst(strtolower($_POST['prenom']));
    $nom = ucfirst(strtolower($_POST['nom']));
    $adresse = strtolower($_POST['adresse']);
    $tel = $_POST['tel'];
    $mail = strtolower($_POST['mail']);
    $ville = ucfirst(strtolower($_POST['ville']));
    $region = $_POST['region'];
    $departement = $_POST['departement'];
    $password = $_POST['password'];
	
 
	//On inscrit l'utilisateur
	$u = new user();
	$user = $u->inscrire_user($prenom, $nom, $adresse, $tel, $mail, $ville, $region, $departement, $password);


//si inscription valide alors on envoi un mail
if($user['reponse'] == 1){
    $mail = $user['mail'];
    $nom = 'Prixdupro';
    $from = 'info@prixdupro.fr';
    $subject = "Confirmation d'inscription au site Prixdupro";

    $msg ="  <b>F&eacute;licitation</b> ".$user['prenom']." ".$user['nom'].",<br> votre compte vendeur sur Prixdupro.fr &agrave; &eacute;t&eacute; cr&eacute;&eacute; avec succ&egrave;s
      <br><br>Voici les informations concernant votre compte : 
      <br><br>login : ".$user['mail']."<br>Mot de passe : ".$user['password']."
      <br><br>Bonne journ&eacute;e et bonne chance pour vos ventes.
      <br><br><img src='http://www.prixdupro.fr/images/banniere%20prixdupro.gif' />
	  /images/banniere%20prixdupro.gif
      " ;
    
    //Create the message
    $message = Swift_Message::newInstance()
    ->setSubject(utf8_encode($subject))
    ->setFrom(array($from => $nom))
    ->setTo(array($mail))
    ->setBody(utf8_encode($msg), 'text/html')
    ;

    $transport = Swift_MailTransport::newInstance();
    $mailer = Swift_Mailer::newInstance($transport);
    $result = $mailer->send($message);
}



//On inclut la vue
include(dirname(__FILE__).'/../vues/inscription.php');


?>