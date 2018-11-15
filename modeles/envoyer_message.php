<?php
require_once 'libs/Swift-4.1.0/lib/swift_required.php';

function envoyer_message()
{
	$valid = false; 
	
	if( isset($_POST['sender_name']) && isset($_POST['sender_email']) && isset($_POST['sender_msg']) && isset($_POST['destinataire_msg'])    ){
		$sender_name = $_POST['sender_name'];
		$sender_email= $_POST['sender_email'];
		$sender_msg = $_POST['sender_msg'];
		$dest = $_POST['destinataire_msg'];
		$ref = $_POST['ref_annonce'];
		$url = 'http://'.$_SERVER['SERVER_NAME'].'/index.php?page=annonce&ref='.$ref;
		
		$msg = "Nom de l'emeteur :\t$sender_name<br/>";
		$msg .= "Email de l'emeteur :\t$sender_email<br/>";
		if( isset($_POST['sender_tel'])){
			$sender_tel = $_POST['sender_tel'];
			$msg .= "Telephone de l'emeteur :\t$sender_tel<br/>";
		}
		$msg .= "Votre annonce:\t$url<br/>";
		$msg .= "<br/>Message:\t$sender_msg<br/><br/>";
		
		$subject = "Votre annonce sur Prixdupro";
		$nom = "$sender_name via prixdupro.fr";
		$from = "$sender_email" ;
		

		$message = Swift_Message::newInstance()
		->setSubject($subject)
		->setFrom(array($from => $nom))
		->setTo(array($dest))
		->setBody($msg, 'text/html')
		;

		$transport = Swift_MailTransport::newInstance();
		$mailer = Swift_Mailer::newInstance($transport);
		
		$valid = $mailer->send($message);
		
	}
	else
		$valid = false;
	
	return $valid;
}





?>