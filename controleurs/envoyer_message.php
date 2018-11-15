<?php

//On inclut le modèle
include(dirname(__FILE__).'/../modeles/envoyer_message.php');
 

$res = envoyer_message();
 
if($res)
  $smarty->display('/../templates/message_envoye.tpl');
else
  $smarty->display('/../templates/message_non_envoye.tpl');
//include(dirname(__FILE__).'/../vues/gestion.php');
?>