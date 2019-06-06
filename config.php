<?php

/*Configuration de PHP*/
ini_set ('upload_max_filesize', '32M');
ini_set ('post_max_size', '32M');
ini_set ('max_input_time', '150');
ini_set ('max_execution_time', '150');

require 'libs/Smarty.class.php';
$smarty = new Smarty;
  
if(isset($_REQUEST['dbg'])){
  // Même chose que error_reporting(E_ALL);
  ini_set('error_reporting', E_ALL);
}

  
/*CONFIGURATION PAR ENVIRONNEMENTS */

/*Serveur Free*/
if($_SERVER['HTTP_HOST'] == 'prixdupro.free.fr'){
  define("SERVER", "prixdupro.sql.free.fr");
  define("USER" , "prixdupro");
  define("NAMEBDD" , "prixdupro");
  define("MDP" , "757875");
  define("RACINE", "/");
}

/*Localhost*/
elseif($_SERVER['HTTP_HOST'] == 'localhost'){
  define("SERVER", "localhost");
  define("USER" , "rezki");
  define("NAMEBDD" , "prixduprobdd");
  define("MDP" , "");
  define("RACINE", "/prixdupro/");
}

/*ServerRK Stage*/
elseif($_SERVER['HTTP_HOST'] == 'stage.prixdupro.fr' || $_SERVER['HTTP_HOST'] == 'prixdupro.rezki-kies.fr'){
  define("SERVER", "localhost:3307");
  define("USER" , "Rezki");
  define("NAMEBDD" , "stage_prixduprobdd");
  define("MDP" , "Rikikaka93'");
  define("RACINE", "/");
}

/*Serveur OVH en ligne*/
else{
  define("SERVER", "mysql51-57.perso");
  define("USER" , "prixduprobdd");
  define("NAMEBDD" , "prixduprobdd");
  define("MDP" , "7HVtkcLW");
  define("RACINE", "/");
}

$smarty->assign('RACINE',RACINE);


$categories = array(1  => 'auto', 2 => 'moto', 3 => 'caravaning',4 => 'utilitaires',5 => 'equipement-auto',6 => 'equipement-moto',7 => 'equipement-caravaning',8 => 'image-son',9 => 'informatique',
					10  => 'consoles-jeux-video', 11  => 'telephonie', 12 => 'immobilier', 13 => 'ameublement',14 => 'electromenager',15 => 'bricolage-jardinage',16 => 'vetements',17 => 'accessoires-bagagerie',18 => 'montres-bijoux',19 => 'equipement-bebe', 
					20  => 'dvd', 21  => 'cd', 22 => 'blueray', 23 => 'livres',24 => 'animaux',25 => 'sports-hobbies',26 => 'collection',27 => 'jeux-jouets',28 => 'vins-gastronomie',29 => 'billeterie',
					30  => 'evenements', 31  => 'services', 32 => 'emplois', 33 => 'cours-particuliers',34 => 'recherche',35 => 'autre'
);
$regions = array(	1  => 'Alsace', 2 => 'Aquitaine', 3 => 'Auvergne',4 => 'Basse-normandie',5 => 'Bourgogne',6 => 'Bretagne',7 => 'Centre',8 => 'Champagne-ardenne',9 => 'Corse',
					10  => 'Franche-comte', 11  => 'Haute-normandie', 12 => 'Ile-de-france', 13 => 'Languedoc-roussillon',14 => 'Limousin',15 => 'Lorraine',16 => 'Midi-pyrenes',17 => 'Nord-pas-de-calais',18 => 'Pays-de-la-loire',19 => 'Picardie', 
					20  => 'Poitou-charentes', 21  => 'Alpes-cote-d-azur', 22 => 'Rhones-alpes', 23 => 'Dom'
);




?>
