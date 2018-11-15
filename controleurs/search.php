<?php
  require 'modeles/annonce.class.php';
  require 'modeles/annonces.class.php';

 
  //On inclut le modèle
  include(dirname(__FILE__).'/../modeles/search.php');
  include(dirname(__FILE__).'/../modeles/pagination.php');

  $categorie = $mot = $prixmin = $prixmax = $debat_annonce =  $annee_min =  $annee_min = $annee_max = $km_min = $km_max = $region = $departement ="";
  $tri = 0;
  $nba = 20;

  if(isset($_REQUEST['tri']))				$tri = $_REQUEST['tri'];
  if(isset($_REQUEST['nba']))				$nba = $_REQUEST['nba'];
  if(isset($_REQUEST['search_categorie']))	$categorie = $_REQUEST['search_categorie'];
  if(isset($_REQUEST['search_mot']))		$mot = $_REQUEST['search_mot'];
  if(isset($_REQUEST['search_prixmin']))	$prixmin = $_REQUEST['search_prixmin'];
  if(isset($_REQUEST['search_prixmax']))	$prixmax = $_REQUEST['search_prixmax'];
  if(isset($_REQUEST['search_debat_annonce']))	$debat_annonce = $_REQUEST['search_debat_annonce'];
  if(isset($_REQUEST['search_annee_min']))	$annee_min = $_REQUEST['search_annee_min'];
  if(isset($_REQUEST['search_annee_max']))	$annee_max = $_REQUEST['search_annee_max'];
  if(isset($_REQUEST['search_km_min']))		$km_min = $_REQUEST['search_km_min'];
  if(isset($_REQUEST['search_km_max']))		$km_max = $_REQUEST['search_km_max'];
  if(isset($_REQUEST['search_region']))		$region = $_REQUEST['search_region'];
  if(isset($_REQUEST['search_departement']))$departement = $_REQUEST['search_departement'];
  
  $annonces = new Annonces();
  $annonces->recuperer_annonces($categorie, $region, $mot, $prixmin, $prixmax, $debat_annonce, $annee_min, $annee_max, $km_min, $km_max, $tri, $nba);
  //Annonce::test();

  //On inclut la vue
  include(dirname(__FILE__).'/../vues/search.php');

?>