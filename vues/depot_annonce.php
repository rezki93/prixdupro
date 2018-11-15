<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xml:lang="fr-FR">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Depot d'annonce - Prixdupro</title>
		<meta name="robots" content="noindex, nofollow" />
		<meta name="Description" content=""  />
		
		<?php include(dirname(__FILE__).'/../vues/head.php');	?>
		<link type="text/css" href="<?php echo RACINE; ?>css/annonce.css" rel="stylesheet" />  
	</head>
  
	<body>
		<!-- Google Tag Manager -->
		<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-M39RRF"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-M39RRF');</script>
		<!-- End Google Tag Manager -->
<?php
		$smarty->display('templates/banniere.tpl');
		//$smarty->display('inscription.tpl');
?>
		<div id="principal-annonce" class="ui-widget-content" style="">
<?php
if($resultat['reponse'] == 1 ){
  echo '
      <div>
        <div style="float:left;margin-left:40px;">
          <span class="text blue bold" style="float:left;margin-top:20px;">
            <h1>
              Votre annonce a été créée avec succes !
            </h1>
          </span>

          <span class="text blue bold" style="margin-top:20px;">
            <h3>
              Les informations liées à votre annonce sont :
            </h3>
          </span>
        </div>
        <div class="clear"></div>
        <div style="margin-left:40px;margin-bottom: 20px;">
          <div class="text bold" style="margin-top:20px;">Titre : <span class="green">'.$resultat['titre_annonce'].'</span></div>
          <div class="text bold" style="margin-top:20px;">Categorie : <span class="green">'.$resultat['cat_annonce'].'</span></div>
          <div class="text bold" style="margin-top:20px;">Description : <span class="green">'.$resultat['desc_annonce'].'</span></div>
          <div class="text bold" style="margin-top:20px;">Prix : <span class="green">'.$resultat['prix_annonce'].'</span></div>
          <div class="text bold" style="margin-top:20px;">Prix à débattre : <span class="green">';
          if($resultat['debat_annonce'] == "on") echo 'oui';
          else echo 'non';
          echo '
          </span></div>
          <div class="text bold" style="margin-top:20px;">Date : <span class="green">'.$resultat['date_annonce'].'</span></div>
          <div class="text bold" style="margin-top:20px;">Google map vers votre adresse : <span class="green">'.$resultat['map_annonce'].'</span></div>
          
        </div>
        
        ';
        
        if($resultat['cat_annonce']==1){
          echo '  
            <div style="margin-left:40px">
              <div class="text bold" style="margin-top:20px;">Annee : <span class="green">'.$resultat['annee_annonce'].'</span></div>
              <div class="text bold" style="margin-top:20px;">Kilometrage : <span class="green">'.$resultat['km_annonce'].'</span></div>
              <div class="text bold" style="margin-top:20px;">Energie : <span class="green">'.$resultat['energie_annonce'].'</span></div>
              <div class="text bold" style="margin-top:20px;">Boite : <span class="green">'.$resultat['boite_annonce'].'</span></div>
            </div>
          ';
        }
        
        
        
        if($resultat['photos_annonce'] != ""){
          $tok = strtok($resultat['photos_annonce'],";"); 
          $i = 0;
          $photos = Array();
          while ($tok !== false) { 
            $i = $i + 1;
            $photos[$i] = $tok;
            $tok = strtok(";"); 
          } 
		  ?>
			<div style="margin-top:40px;margin-left:40px">
				<ul class="jcarousel-skin-tango">
			  <?php
              foreach($photos as $p) {  
                $chemin_photo = pathinfo($p);
                echo '
                  <li style="float:left; margin-right:10px;">
                    <a href="'.RACINE.$chemin_photo['dirname'].'/'.$chemin_photo['basename'].'" rel="lyteshow" title="">
                      <img src="'.RACINE.$chemin_photo['dirname'].'/mini_'.$chemin_photo['basename'].'" alt="" />
                    </a>
                  </li>
                  ';
              }
			?>          
				</ul>
			</div>
          
          <?php 
        }
        
  echo '
      </div>
  ';
}

else if($resultat['reponse'] == 2 || $resultat['reponse'] == 3 || $resultat['reponse'] == 4){
?>
    <div style="float:left">
        <div style="float:left;margin-left:40px;">
            <h1 class="text blue bold" style="float:left;margin-top:20px;">Désolé l'ajout d'annonce a échoué !</h1>
		</div>

		<div style="margin-left:40px;">	
		<?php
		if($resultat['reponse'] == 2 || $resultat['reponse'] == 3){
		?>
			<span class="text bold" style="float:left;margin-top:20px;">
				<br>Verifiez les données de votre photos
				<br>Taille maximum : 2mo
				<br>Formats acceptés : jpg, png, jpeg, gif
			</span
		<?php
		}  
		if($resultat['reponse'] == 4){
		?>
			<span class="text bold" style="float:left;margin-top:20px;">
				<br>Votre annonce a déjà été ajoutée.
				<br>Vous ne pouvez ajouter deux fois la même annonce
			</span>
      <?php
    }      
    ?>
   
        </div>
	</div>
    <?php

  
}
else
{
?>
			<div style="float:left;margin-left:40px;">
				<h1 class="text blue bold" style="float:left;margin-top:20px;">Désolé l'ajout d'annonce a échoué !	</h1>
			</div>
	
<?php
}
?>
			<div class="clear"></div>
		</div>';
		<?php $smarty->display('footer.tpl'); ?>
	</body>

</html>
