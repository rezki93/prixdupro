<html xml:lang="fr-FR">
  <head>
    <title>Gestion - Prixdupro</title>
	<?php include(dirname(__FILE__).'/../vues/head.php');	?>
  </head>
 
  <body>
      <?php 
      $smarty->display('templates/banniere.tpl');
      $smarty->display('templates/presentation.tpl');
      ?>
      <div id="principal" class="ui-widget-content" style="margin-top:5px;width:990px;margin-left:auto;margin-right:auto">
 <?php 
if($_SESSION['etat']=='connecte'){
  $reg = array(1 =>"Alsace",2 =>"Aquitaine",3 =>"Auvergne",4 =>"Basse-Normandie",5 =>"Bourgogne",6 =>"Bretagne",7 =>"Centre",8 =>"Champagne-Ardenne",9 =>"Corse",10 =>"Franche-Comté",11 =>"Haute-Normandie",12 =>"Ile-de-France",13 =>"Languedoc-Roussillon",14 =>"Limousin",15 =>"Lorraine",16 =>"Midi-Pyrénés",17 =>"Nord-Pas-De-Calais",18 =>"Pays de la Loire",19 =>"Picardie",20 =>"Poitou-Charentes",21 =>"Alpes-Côte d'Azur",22 =>"Rhône-Alpes",23 =>"Departements d'outre Mer");
  
?>
    <div style="padding:20px;margin-left:30px;float:left;width:250px">
      <div style="">
        <span class="text blue bold" style="">
          <h1>Mon compte</h1>
        </span>
      </div>
      
      <div style="float:left;padding-bottom:50px">
        <div class="text bold" style="margin-top:20px;">Votre prenom : 		<span class="green"><?php echo $_SESSION['con_prenom']?></span></div>
        <div class="text bold" style="margin-top:20px;">Votre nom : 		<span class="green"><?php echo $_SESSION['con_nom']?></span></div>
        <div class="text bold" style="margin-top:20px;">Votre region : 		<span class="green"><?php echo $reg[$_SESSION['con_region']]?></span></div>                                                                                            
        <div class="text bold" style="margin-top:20px;">Votre departement : <span class="green"><?php echo $_SESSION['con_departement']?></span></div>
        <div class="text bold" style="margin-top:20px;">Votre ville : 		<span class="green"><?php echo $_SESSION['con_ville']?></span></div>
        <div class="text bold" style="margin-top:20px;">Votre adresse : 	<span class="green"><?php echo $_SESSION['con_adresse']?></span></div>                                                                                                 
        <div class="text bold" style="margin-top:20px;">Votre telephone : 	<span class="green"><?php echo $_SESSION['con_tel']?></span></div>
        <div class="text bold" style="margin-top:20px;">Votre email : 		<span class="green"><?php echo $_SESSION['con_mail']?></span></div>
      </div>
      
    <div class="blue-button3" onClick=" if(confirm(\'Etes vous sur de vouloir supprimer definitivement votre compte ?\n(Ceci supprimera toutes vos annonces)\')){var mdp=prompt(\'Tapez votre mot de passe pour confirmer la suppression de votre compte\',\'\');if(mdp != null && mdp != \'\')document.location.href=\'./index.php?page=gestion&rub=supprimer_user&mdp=\'+mdp ;}" style="margin-top:40px;float:left">Supprimer votre compte</div>
    
    <div class="blue-button3" onClick="modifier_mdp()" style="margin-top:40px;float:left">Modifier mot de passe</div>
    
    <div id="block-loader-modification_mdp" style="display:none">
      <img src="<?php echo RACINE;?>images/loading.gif" width="100px"/>
    </div>
    
    </div>
    
    <div style="padding:20px;float:left;width:510px">
      <div style="margin-left:100px;margin-bottom:15px;">
        <span class="text blue bold" style="">
          <h1>Mes annonces</h1>
        </span>
      </div>
 <?php

  foreach($annonces as $n)
  {
      echo '
        <a href="./annonce/'.$n['id_annonce'].'">
          <div class="annonceGestion" style="">
              ';
              
              if($n['photos_annonce'] != "")
              {
                $photo = pathinfo(strtok($n['photos_annonce'],";"));
                $photo_mini = RACINE.$photo['dirname'].'/mini_'.$photo['basename'];
                echo '
                  <div style="float :left; width:100px; margin-left:5px;margin-top:3px;">
                    <p align="center">
                      <img src="'.$photo_mini.'" height="40"  border="4" ">
                    </p>
                  </div>
                
                ';
              }else{
                echo '
                  <div style="float :left; width:100px; margin-left:10px;margin-top:5px;">
                    <p align="center">
                       <img src="'.RACINE.'images/no_photo2.png" height="40" width="40" border="4" style="">
                    </p>
                  </div>
                ';
              }
              echo '
                <span class="text bold" style="float:left;margin-left:25px;margin-top:15px;">'.substr($n['titre_annonce'],0,25).'</span>
                
                <!--<a style="float:right" href="'.RACINE.'index.php?page=supprimer_annonce&ref='.$n['id_annonce'].'" style="cursor:pointer">
                  <img style="margin-left: 15px;margin-top: 5px;height:30px;width:30px" src="images/delete.png" onClick="return(confirm(\'Etes vous sur de vouloir supprimer definitivement cette annonce ?\'));" >
                </a>-->
                   
                <a style="float:right" href="'.RACINE.'index.php?page=supprimer_annonce&ref='.$n['id_annonce'].'" style="cursor:pointer">                                                                                         
                    <button type="button" class="btn btn-default btn-sm right" onClick="return(confirm(\'Etes vous sur de vouloir supprimer definitivement cette annonce ?\'));" >
                         <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Supprimer
                    </button>
                </a>
                                                                                         
                <span class="text bold" style="float:right;margin-right:10px;margin-top:15px;">'.$n['prix_annonce'].' &#8364;</span>
          </div>
        </a>
        <div class="clear"></div>
        ';
  }
  
?>
    <div style="padding:20px 0 0 0px;">
      <div style="margin-left:100px;margin-bottom:15px;">
        <span class="text blue bold" style="">
          <h1>Mes favoris</h1>
        </span>
      </div>
      
<?php

  foreach($favoris as $f)
  {
  echo '
    <a href="'.RACINE.'annonce/'.$f['id_annonce'].'">
      <div class="annonce" style="">
          ';
          
          
          
          if($f['photos_annonce'] != "")
          {
            $photo = pathinfo(strtok($f['photos_annonce'],";"));
            $photo_mini = RACINE.$photo['dirname'].'/mini_'.$photo['basename'];
            echo '
              <div style="float :left; width:100px; height:40px;margin-left:10px;margin-top:5px;">
                <p align="center">
                  <img src="'.$photo_mini.'" height="40"  border="4" ">
                </p>
              </div>
            
            ';
          }else{
            echo '
              <div style="float :left; width:100px; height:40px;margin-left:10px;margin-top:5px;">
                <p align="center">
                  <img src="'.RACINE.'images/no_photo2.png" height="30" width="30" border="4" style="">
                </p>
              </div>
            ';
          }
          echo '
            <span class="text bold" style="float:left;margin-left:25px;margin-top:10px;">'.substr($f['titre_annonce'],0,25).'</span>
            
            <!--<a style="float:right" href="'.RACINE.'index.php?page=supprimer_favoris&ref='.$n['id_annonce'].'" style="cursor:pointer">
              <img style="margin-left: 10px;height:30px;width:30px" src="images/delete.png" onClick="return(confirm(\'Etes vous sur de vouloir supprimer definitivement cette annonce favorite ?\'));" >
            </a>-->
            <a style="float:right" href="'.RACINE.'index.php?page=supprimer_favoris&ref='.$n['id_annonce'].'" style="cursor:pointer">                                                                                  
                <button type="button" class="btn btn-default btn-sm right" onClick="return(confirm(\'Etes vous sur de vouloir supprimer definitivement cette annonce favorite ?\'));" >
                     <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Supprimer
                </button>
            </a>
            <span class="text bold" style="float:right;margin-right:10px;margin-top:10px;">'.$f['prix_annonce'].' &#8364;</span>
  
      </div>
    </a>
    <div class="clear"></div>
    ';
  }  
  echo '
    </div>
  ';
}
else{
  echo '
      <div>
        <span class="text blue bold" style="margin-left:20px;margin-top:20px;width:70px">Erreurs de connexion ! Login et/ou mot de passe incorrects</span>
      </div>
    ';
}
?>
  
  </div>
  <div class="clear"></div>
</div>

  
  <!--
<div>

<div style="float:left;margin-left:5px;margin-top:10px;">
  <div id="fb-root"></div><script src="http://connect.facebook.net/fr_FR/all.js#xfbml=1"></script>
  <fb:like-box href="http://www.facebook.com/pages/Prixdupro/242724812419061" width="185" height="290" show_faces="true" border_color="" stream="false" header="false"></fb:like-box>
</div>

<div style="float:left;margin-left:40px;margin-top:10px;">
  <script type="text/javascript" src="http://ads.clicmanager.fr/exe.php?c=23053&s=37465&t=3&q=2373"></script>
</div>

</div>
  -->

     <?php $smarty->display('footer.tpl'); ?>
     </body>
</html>
