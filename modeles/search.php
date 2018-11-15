<?php
function recuperer_annonces()
{
	$link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis php5.3
    if(isset($_REQUEST['tri']))
      $tri = $_REQUEST['tri'];
    else
      $tri = 0;
  
    if(isset($_REQUEST['nba']))
      $nba = $_REQUEST['nba'];
    else
      $nba = 20;
      
    $annonces = array();
    $tables = "";
    
    /* Definition des tables où chercher */
    if(isset($_REQUEST['search_categorie'])){
      $categorie = $_REQUEST['search_categorie'];
      if($categorie == "1")
        $tables = $tables.",cat_auto";  
    }

    $chaine="SELECT distinct *
    FROM ANNONCES,USERS".$tables."
    where ANNONCES.id_user=USERS.id_user";
    
    /* Definitions des conditions where ... */
    if(isset($_REQUEST['search_mot'])){
      $mot = $_REQUEST['search_mot'];
      if($mot != "Entrez votre recherche" && $mot != "")
        $chaine = $chaine." and (ANNONCES.titre_annonce LIKE '%".$mot."%' or ANNONCES.desc_annonce LIKE '%".$mot."%')
        ";
    }
    
    if(isset($_REQUEST['search_prixmin'])){
      $prixmin = $_REQUEST['search_prixmin'];
      if($prixmin != "--" && $prixmin != "")
        $chaine = $chaine." and ANNONCES.prix_annonce >= ".$prixmin;
    }
    
    if(isset($_REQUEST['search_prixmax'])){
      $prixmax = $_REQUEST['search_prixmax'];
      if($prixmax != "--" && $prixmax != "")
        $chaine = $chaine." and ANNONCES.prix_annonce <= ".$prixmax;
    }

    if(isset($_REQUEST['search_debat_annonce'])){
      $debat_annonce = $_REQUEST['search_debat_annonce'];
      if($debat_annonce == "on")
        $chaine = $chaine." and ANNONCES.debat_annonce = '".$debat_annonce."'";
    }

    if(isset($_REQUEST['search_categorie'])){
      $categorie = $_REQUEST['search_categorie'];  
      
      if($categorie != "--" && $categorie != "")
        $chaine = $chaine." and ANNONCES.cat_annonce = ".$categorie;
      
      if($categorie == "1"){
        
        if(isset($_REQUEST['search_annee_min'])){
          $annee_min = $_REQUEST['search_annee_min'];
          $chaine = $chaine." and ANNONCES.id_annonce=cat_auto.id_auto";
          if($annee_min != "--" && $annee_min != "")
            $chaine = $chaine." and cat_auto.annee_annonce >= ".$annee_min;
        }
        
        if(isset($_REQUEST['search_annee_max'])){
          $annee_max = $_REQUEST['search_annee_max'];
          $chaine = $chaine." and ANNONCES.id_annonce=cat_auto.id_auto";
          if($annee_max != "--" && $annee_max != "")
            $chaine = $chaine." and cat_auto.annee_annonce <= ".$annee_max;
        }
        
        if(isset($_REQUEST['search_km_min'])){
          $km_min = $_REQUEST['search_km_min'];
          $chaine = $chaine." and ANNONCES.id_annonce=cat_auto.id_auto";
          if($km_min != "--" && $km_min != "")
            $chaine = $chaine." and cat_auto.km_annonce >= ".$km_min;
        }
        
        if(isset($_REQUEST['search_km_max'])){
          $km_max = $_REQUEST['search_km_max'];
          $chaine = $chaine." and ANNONCES.id_annonce=cat_auto.id_auto";
          if($km_max != "--" && $km_max != "")
            $chaine = $chaine." and cat_auto.km_annonce <= ".$km_max;
        }
    
      }
    }
    
    if(isset($_REQUEST['search_region'])){
      $region = $_REQUEST['search_region'];
      if($region != "--" && $region != "")
        $chaine = $chaine." and USERS.region_user = ".$region;
        
      if(isset($_REQUEST['search_departement'])){
        $departement = $_REQUEST['search_departement'];
        if($departement != "--" && $departement != "")
          $chaine = $chaine." and USERS.dep_user = ".$departement;
      }
        
    }
    $chaine = $chaine . " and ANNONCES.etat_annonce = 'validee' ";
    
    if($tri == 0)
      $chaine = $chaine." ORDER BY ANNONCES.date_annonce DESC";
    if($tri == 1)
      $chaine = $chaine." ORDER BY ANNONCES.date_annonce ASC";    
    if($tri == 2)
      $chaine = $chaine." ORDER BY ANNONCES.prix_annonce ASC";
    if($tri == 3)
      $chaine = $chaine." ORDER BY ANNONCES.prix_annonce DESC";
    

    $req = mysqli_query($link,$chaine);
    
        while ($data = mysqli_fetch_assoc($req)) {
            $annonces[] = $data;
        }
 
        return $annonces;
}