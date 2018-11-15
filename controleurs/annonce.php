<?php
  require 'modeles/annonce.class.php';
  require 'modeles/annonces.class.php';
  
  /* Récupération de l'annonce */
  if(isset($_REQUEST['ref']) && is_numeric($_REQUEST['ref'])){
    $annonce = new Annonce();
    $annonce->recuperer_une_annonce($_REQUEST['ref']);
  }

  include(dirname(__FILE__).'/../vues/annonce.php');
?>