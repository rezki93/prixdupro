<?php


//On inclut le modèle
//include(dirname(__FILE__).'/../modeles/depot_annonce.php');
require dirname(__FILE__).'/../modeles/annonce.class.php';

$id_user = $_SESSION['con_id'] ;
$titre = $_POST['titre_annonce'];
$prix = $_POST['prix_annonce'];
$desc = nl2br($_POST['desc_annonce']);
$date_annonce = date('Y\-m\-d H:i:s');	
$cat = $_POST['cat_annonce'];
$annee = $km = $energie = $boite = "";

if(isset($_POST['map_annonce']))	$map_annonce = $_POST['map_annonce'];				else	$map = "off";	
if(isset($_POST['debat_annonce']))	$debat_annonce = $_POST['debat_annonce'];			else	$debat = "off";
if(isset($_POST['affiche_tel']))	$affiche_tel = $_POST['affiche_tel'];				else	$affiche_tel = "off";
if(isset($_POST['affiche_adresse']))	$affiche_adresse = $_POST['affiche_adresse'];	else	$affiche_adresse = "off";
if(isset($_POST['annee_annonce']) && $_POST['annee_annonce'] != "" )	$annee = $_POST['annee_annonce'];
if(isset($_POST['km_annonce'])  && $_POST['km_annonce'] != "")		$km = $_POST['km_annonce'];	
if(isset($_POST['energie_annonce'])  && $_POST['energie_annonce'] != "")	$energie = $_POST['energie_annonce'];
if(isset($_POST['boite_annonce'])  && $_POST['boite_annonce'] != "")	$boite = $_POST['boite_annonce'];

$a = new Annonce();
$a->init(null,$titre,$prix,$desc,$date_annonce,$cat,$map,$debat,$affiche_tel,$affiche_adresse,"en attente","",$_SESSION['con_id'],$_SESSION['con_prenom'],$_SESSION['con_adresse'],$_SESSION['con_ville'],$_SESSION['con_departement'],$_SESSION['con_region'],$_SESSION['con_tel'],$_SESSION['con_mail']);
$resultat = $a->deposer_annonce();

//$resultat = deposer_annonce();

if($resultat['reponse'] == 1 ){
/*Prevenir admin */
  require_once 'libs/Swift-4.1.0/lib/swift_required.php';
    
    $mail = "rezki.kies@gmail.com";
    $nom = $_SERVER['HTTP_HOST'];
    $from = 'donotreply@prixdupro.fr';
    $subject = "Une nouvelle annonce sur Prixdupro.fr";

    $msg ="  Une nouvelle annonce a &eacute;t&eacute; cr&eacute;&eacute;e par un utitilisateur sur ".$_SERVER['HTTP_HOST']."
      
      <div style='color:gray;font-size:11px'>
        <br>Voici les informations concernant l'annonce :
        <br> Titre : ". $resultat['titre_annonce'] ."
        <br> Description : ". $resultat['desc_annonce'] ."
        <br> Prix : ". $resultat['prix_annonce'] ."
      </div>
      
      <div style='color:blue'>
        <br><br><b>Gestion :</b>
        <br>Voir cette annonce : ".$_SERVER['HTTP_HOST']."/index.php?page=annonce&ref=" . $resultat['id_annonce'] . "
        <br>Accepter cette annonce : ".$_SERVER['HTTP_HOST']."/index.php?page=dashboard&action=valider_annonce&ref_annonce=".  $resultat['id_annonce'] ."
        <br>Refuser cette annonce : ".$_SERVER['HTTP_HOST']."/index.php?page=dashboard&action=refuser_annonce&ref_annonce=".  $resultat['id_annonce'] ."
        <br><br> <a href='".$_SERVER['HTTP_HOST']."/index.php?page=dashboard'>Acceder au dashboard</a>
      </div>   
      <br><br><br><br>
                                     
      <a href='".$_SERVER['HTTP_HOST']."'>
           <img src='".$_SERVER['HTTP_HOST']."/images/banniere prixdupro.gif' />
      </a>
      " ;
    
    //Create the message
    $message = Swift_Message::newInstance()
    ->setSubject($subject)
    ->setFrom(array($from => $nom))
    ->setTo(array($mail))
    ->setBody($msg, 'text/html')
    ;

    $transport = Swift_MailTransport::newInstance();
    $mailer = Swift_Mailer::newInstance($transport);
    $result = $mailer->send($message);

}

 
//On inclut la vue
include(dirname(__FILE__).'/../vues/depot_annonce.php');
?>