<?php
  
if(isset($_REQUEST['mail']) && $_REQUEST['mail'] != "")
  $mail = $_REQUEST['mail'] ;
else
  $mail = "" ;
  
if($mail != ""){
  $tab = Array();
  $chaine = "  select password_user FROM USERS WHERE mail_user = '".$mail."'";
  $link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis PHP 5.3
  $req = mysqli_query($link, $chaine);
  while ($data = mysqli_fetch_assoc($req))
  {
    $tab = $data;
  }

  if( isset($tab['password_user']) && ($tab['password_user'] != null) && ($tab['password_user'] != "") ) 
  {
    require_once 'libs/Swift-4.1.0/lib/swift_required.php';
    $msg ="  Bonjour,<br> Vous avez demand&eacute; le renvoi de vos param&egrave;tres de connexion.<br><br>Votre login : $mail<br>Votre mot de passe : " . $tab['password_user'] . "
        <br><br>Nous vous remercions pour votre fidelit&eacute;.Bonne journ&eacute;e
        <br><br><img src='http://www.prixdupro.fr/images/banniere prixdupro.gif' width='300px' />
        " ;
    $message = Swift_Message::newInstance()
    ->setSubject("Votre mot de passe sur Prixdupro.fr")
    ->setFrom(array('ne-pas-repondre@prixdupro.fr' => 'Prixdupro'))
    ->setTo(array($mail))
    ->setBody($msg, 'text/html');
    $transport = Swift_MailTransport::newInstance();
    $mailer = Swift_Mailer::newInstance($transport);
    
    $mailer->send($message);
    echo utf8_encode("<p style='color:green; border : 2px solid green'>Mot de passe renvoyé à l'adresse " . $mail."</p>");
  }
  else
    echo utf8_encode("<p style='color:red;border : 2px solid red'>Cette email ne correspond à aucun utilisateur</p>");
}
else
  echo utf8_encode("<p style='color:red;border : 2px solid red'>Veuillez entrer une adresse email valide</p>");
  

?>