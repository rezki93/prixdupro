<?php
/* On r�cup�re l'identifiant de la r�gion choisie. */
$idr = isset($_GET['idr']) ? $_GET['idr'] : false;

/* On r�cup�re l'identifiant de la r�gion choisie. */
$idd = isset($_GET['idd']) ? $_GET['idd'] : false;

/* On r�cup�re l'identifiant de la r�gion choisie. */
$section = isset($_GET['section']) ? $_GET['section'] : false;

/* Si on a une r�gion, on proc�de � la requ�te */
if(false !== $idr && $idr !="" && $idr != "--")
{
    /* C�ration de la requ�te pour avoir les d�partements de cette r�gion */
    $sql2 = "SELECT `id_departement`, `departement`".
            " FROM `departement`".
            " WHERE `id_region` = ". $idr ."".
            " ORDER BY `id_departement`;";
    $rech_dept = mysqli_query($link,$sql2);

  
    /* Un petit compteur pour les d�partements */
    $nd = 0;
  
    /* On cr�e deux tableaux pour les num�ros et les noms des d�partements */
    $code_dept = array();
    $nom_dept = array();
  
    /* On va mettre les num�ros et noms des d�partements dans les deux tableaux */
    while(false != ($ligne_dept = mysqli_fetch_assoc($rech_dept)))
    {
        $code_dept[] = $ligne_dept['id_departement'];
        $nom_dept[]  = $ligne_dept['departement'];
        $nd++;
    }
    
  
    /* Maintenant on peut construire la liste d�roulante */
    $liste = '';
  
  if($section == "search" )
    $liste .= '<select name="search_departement" class="zone-saisie" id="search_departement" style="width:150px">'."\n";
  if($section == "depot" )
    $liste .= '<select name="departement" class="zone-saisie" id="departement" style="width:150px">'."\n";
  
  $liste .= '<OPTION VALUE="--">--</OPTION>';
    for($d = 0; $d < $nd; $d++)
    {
        $liste .= '  <option';
    if( $idd != null && $idd !="" && $idd!="--" && $idd != false && $idd != "undefined" && $idd == $code_dept[$d] ){
      $liste .= ' selected ';
    }
    $liste .= ' value="'. $code_dept[$d] .'">'. htmlentities($nom_dept[$d]) .' ('. $code_dept[$d] .')</option>'."\n";
  }
    $liste .= '</select>'."\n";
  
    /* Un petit coup de balai */
    mysqli_free_result($rech_dept);
  
    /* Affichage de la liste d�roulante */
    echo($liste);
}


?>