<?php

//fonction qui supprime une annonces, et les photos liées
function supprimer_annonce()
{
	$link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis php5.3
    $ref = $_GET['ref'];
    $tab = Array();
    $tab2 = Array();
    
    $chaine = "select ANNONCES.id_annonce, ANNONCES.id_user, cat_annonce
    FROM USERS,ANNONCES
    WHERE USERS.id_user = ANNONCES.id_user
    AND ANNONCES.id_annonce = '".$ref."'"
    ;
    
    $req = mysqli_query($link,$chaine);
    while ($data = mysqli_fetch_assoc($req)){
		$tab['infos'] = $data;
	}
    
    // verifie que l'utilisateur est bien celui qui as posté l'annonce
    if($_SESSION['con_id'] == $tab['infos']['id_user']){
		$chaine="DELETE FROM ANNONCES WHERE ANNONCES.id_annonce ='".$ref."'";
		$req = mysqli_query($link,$chaine);
		$cat = $tab['infos']['cat_annonce'];

		// si c'est ds la categorie auto, on supprime les champs de la table cat_auto
		if($cat == 1 ){
			$chaine2="DELETE FROM cat_auto WHERE cat_auto.id_auto ='".$ref."'";
			$req2= mysqli_query($link,$chaine2);
		}
		// s'il ya des photos, on supprime
		$chemin = dirname(__FILE__).'/../upload/'.$ref.'/';
		if(is_dir($chemin))
			sup_repertoire($chemin);
    }
}


   /*Supprime un repertoire et les fichiers qu'il contient */
   function rrmdir($dir) { 
        if (is_dir($dir)) { 
             $objects = scandir($dir); 
             foreach ($objects as $object) { 
               if ($object != "." && $object != "..") { 
                 if (filetype($dir."/".$object) == "dir") 
                     rrmdir($dir."/".$object); 
                 else 
                     unlink($dir."/".$object); 
               } 
             } 
             reset($objects); 
             rmdir($dir); 
        } 
    } 


function sup_repertoire($chemin) {

  // vérifie si le nom du repertoire contient "/" à la fin
  if ($chemin[strlen($chemin)-1] != '/') // place le pointeur en fin d'url
     {
       $chemin .= '/';
     } // rajoute '/'

  if (is_dir($chemin)) {
     $sq = opendir($chemin); // lecture
     while ($f = readdir($sq)) 
     {
          if ($f != '.' && $f != '..')
          {
               $fichier = $chemin.$f; // chemin fichier
               if (is_dir($fichier))
               {
                 sup_repertoire($fichier);
               } // rapel la fonction de manière récursive
               else
               {
                 unlink($fichier);
               } // sup le fichier
          }
      }
      closedir($sq);
      rmdir($chemin); // sup le répertoire
    }
  else 
  {
      unlink($chemin);  // sup le fichier
  }
}

function supprimer_annonce_script($ref)
{
	$link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis php5.3
    $tab = Array();
    $tab2 = Array();
    $chaine = "select ANNONCES.id_annonce, ANNONCES.id_user
    FROM USERS,ANNONCES
    WHERE USERS.id_user = ANNONCES.id_user
    AND ANNONCES.id_annonce = '".$ref."'"
    ;
    $req = mysqli_query($link,$chaine);
    while ($data = mysqli_fetch_assoc($req)){
		$tab['infos'] = $data;
	}
      
    $chaine="DELETE FROM ANNONCES WHERE ANNONCES.id_annonce ='".$ref."'";
    $req = mysqli_query($link,$chaine);
    $cat = $tab['infos']['cat_annonce'];
    
    // si c'est ds la categorie auto, on supprime les champs de la table cat_auto
    if($cat == 1 ){
      $chaine2="DELETE FROM cat_auto WHERE cat_auto.id_auto ='".$ref."'";
      $req2= mysqli_query($link,$chaine2);
    }
    // s'il ya des photos, on supprime
    $chemin = 'upload/'.$ref.'/';
    if(is_dir($chemin)){
      echo 'on supprime le dossier :'.$ref;
      sup_repertoire($chemin);
    }
}


function expirer_annonce_script($ref){
	$link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis php5.3
	$tab = Array();
    $tab2 = Array();
    $chaine = "select ANNONCES.id_annonce, ANNONCES.id_user
    FROM USERS,ANNONCES
    WHERE USERS.id_user = ANNONCES.id_user
    AND ANNONCES.id_annonce = '".$ref."'"
    ;
    $req = mysqli_query($link,$chaine);
    while ($data = mysqli_fetch_assoc($req)) {
		$tab['infos'] = $data;
    }
      
    $chaine="UPDATE ANNONCES set etat_annonce = 'expiree'
	WHERE ANNONCES.id_annonce ='".$ref."'";
    $req = mysqli_query($link,$chaine);

}





