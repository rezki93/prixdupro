<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php

      if(isset($_REQUEST['search_categorie']) && is_numeric($_REQUEST['search_categorie']))
        $cat=" ".$categories[$_REQUEST['search_categorie']];          
      else
        $cat= "";
      
      if(isset($_REQUEST['search_region']) && is_numeric($_REQUEST['search_region']))         
        $geo= " en ".$regions[$_REQUEST['search_region']];
      else
        $geo=" en France"; 

 ?>
<html xml:lang="fr-FR">  
  <head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Les petites annonces gratuites g&eacute;olocalis&eacute;es<?php echo $cat.' '.$geo?></title>
    <META NAME="Description" CONTENT="Prixdupro: le site de petites annonces gratuites g&eacute;rolocalis&eacute;res. Faites vos achats et bonnes affaires. Immobilier, voiture occasion, auto et moto d'occasion ">
    <?php include(dirname(__FILE__).'/../vues/head.php'); ?>
    <link type="text/css" href="<?php echo RACINE;?>css/acceuil.css" rel="stylesheet" />  
    
    <script type="text/javascript">
      /* Debut Addthis en asynchrone  */
      function action(){
        addthis.init();        
      }
      setTimeout(action, 1000);
      /* Fin Addthis en asynchrone  */
     </script>
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
        $smarty->display('banniere.tpl');
        $smarty->display('presentation.tpl');
     ?>
        <div id="principal" class="ui-widget-content" style="margin-top:5px;margin-left: auto;margin-right: auto;">
            <div id="entete-annonces" class="blue" style="margin: 15px ">
				<h1 style="font-size:25px;">Les petites annonces gratuites g&eacute;olocalis&eacute;es<?php echo $cat.' '.$geo?> </h1>
				<span style="color:red"><?php echo count($annonces->annonces)?></span> correspondent &agrave; votre recherche.
			</div>
  
		<!-- AddThis Button BEGIN -->
		<!--
		<div class="addthis_toolbox addthis_default_style ">
		<a class="addthis_button_facebook at300b"></a>
		<a class="addthis_button_twitter at300b"></a>
		<a class="addthis_button_email at300b"></a>
		</div>
		<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e521ad67f46d1cf"></script>
		-->
		<!-- AddThis Button END -->

<?php
  $url_paginate="";      
if(isset($_GET['search_mot']) && $_GET['search_mot'] !="") 
  $url_paginate.="&search_mot=".$_GET['search_mot'];
      
if(isset($_REQUEST['search_categorie']) && $_REQUEST['search_categorie'] !="" && $_REQUEST['search_categorie'] !="--") 
  $url_paginate.="&search_categorie=".$_REQUEST['search_categorie'];
      
if(isset($_REQUEST['search_region']) && $_REQUEST['search_region'] !="" && $_REQUEST['search_region'] !="--") 
  $url_paginate.="&search_region=".$_REQUEST['search_region'];
      
if(isset($_REQUEST['search_prixmin']) && $_REQUEST['search_prixmin'] !="" && $_REQUEST['search_prixmin'] !="--") 
  $url_paginate.="&search_prixmin=".$_REQUEST['search_prixmin'];
      
if(isset($_REQUEST['search_prixmax']) && $_REQUEST['search_prixmax'] !="" && $_REQUEST['search_prixmax'] !="--") 
  $url_paginate.="&search_prixmax=".$_REQUEST['search_prixmax'];
      
if(isset($_REQUEST['search_annee_min']) && $_REQUEST['search_annee_min'] !="" && $_REQUEST['search_annee_min'] !="--") 
  $url_paginate.="&search_annee_min=".$_REQUEST['search_annee_min'];
      
if(isset($_REQUEST['search_annee_max']) && $_REQUEST['search_annee_max'] !="" && $_REQUEST['search_annee_max'] !="--") 
  $url_paginate.="&search_annee_max=".$_REQUEST['search_annee_max'];
      
if(isset($_REQUEST['search_km_min']) && $_REQUEST['search_km_min'] !="" && $_REQUEST['search_km_min'] !="--") 
  $url_paginate.="&search_km_min=".$_REQUEST['search_km_min'];
      
if(isset($_REQUEST['search_km_max']) && $_REQUEST['search_km_max'] !="" && $_REQUEST['search_km_max'] !="--") 
  $url_paginate.="&search_km_max=".$_REQUEST['search_km_max'];
      
if(isset($_REQUEST['search_energie']) && $_REQUEST['search_energie'] !="" && $_REQUEST['search_energie'] !="--") 
  $url_paginate.="&search_energie=".$_REQUEST['search_energie'];
      
if(isset($_REQUEST['search_boite']) && $_REQUEST['search_boite'] !="" && $_REQUEST['search_boite'] !="--") 
  $url_paginate.="&search_boite=".$_REQUEST['search_boite'];
 
  
if(isset($_GET['tri']))
  $tri = $_GET['tri'];
else
  $tri = 0;

if(isset($_GET['nba']))
  $nba = $_GET['nba'];
else
  $nba = 20;

  
$total = count($annonces->annonces);

/* Declaration des variables */
$epp = $nba; // nombre d'entrées &agrave; afficher par page (entries per page)
$countp = ceil($total/$epp); // calcul du nombre de pages $countp (on arrondit &agrave; l'entier sup?rieur avec la fonction ceil() )


/* Recuperation du numero de la page courante depuis l'URL avec la methode GET */
if(!isset($_GET['p']) || !is_numeric($_GET['p']) ) // si $_GET['p'] n'existe pas OU $_GET['p'] n'est pas un nombre (petite securite supplementaire)
  $current = 1; // la page courante devient 1
else
{
  $page = intval($_GET['p']); // stockage de la valeur enti?re uniquement
  if 
    ($page < 1) $current=1; // cas ou le numero de page est inferieure 1 : on affecte 1 ? la page courante
  elseif 
    ($page > $countp) $current=$countp; //cas ou le numero de page est superieur au nombre total de pages : on affecte le numero de la derniere page a la page courante
  else 
    $current=$page; // sinon la page courante est bien celle indiqu?e dans l'URL
}

echo '
        <div style="">
            <select id="select-nb-annonce" name="nba_select" onchange="document.location.href = \'/index.php?page=search&tri='.$tri.'&nba=\'+this.value" style="">
                <option ';if($nba == 20) echo ' selected ';   echo ' value="20">20 annonces par page</option>
                <option ';if($nba == 50) echo ' selected ';   echo ' value="50">50 annonces par page</option>  
                <option ';if($nba == 100) echo ' selected ';   echo ' value="100">100 annonces par page</option>
            </select>
    ';
      
echo '
            <select id="select-tri" name="tri" onchange="tri(this.value,'.$nba.')" style="">
                <option ';if($tri == 0) echo ' selected ';   echo ' value="0">Du + récent au - récent</option>
                <option ';if($tri == 1) echo ' selected ';   echo ' value="1">Du - récent au + récent</option>  
                <option ';if($tri == 2) echo ' selected ';   echo ' value="2">Du - cher au + cher</option>
                <option ';if($tri == 3) echo ' selected ';   echo ' value="3">Du + cher au - cher</option>
            </select>';
echo "<div id='contener-pagination' >".paginate('/index.php?page=search'.$url_paginate.'&tri='.$tri.'&nba='.$nba, '&p=', $countp, $current)."</div>
  
  
        </div>
        <div class='clear'></div>";

for ($i = (($current - 1) * $epp); $i < ( (($current - 1) * $epp) + $epp) && $i < $total; $i++) 
{
    $n = new Annonce();
    $n->copierAnnonce($annonces->annonces[$i]);
    
    $ojd = date('m\-d');
    $hier = date('m\-d',strtotime('-1 day'));
    $jour_annonce = substr($n->date,5,5);
    $heure_annonce = substr($n->date,11,5);
      
    if($ojd == $jour_annonce)
      $jour = "Aujourd'hui";
    else if($hier == $jour_annonce)
      $jour = "Hier";
    else if($jour_annonce == date('m\-d',strtotime('-2 day')))
      $jour = "Il y a 2 jours";
    else if($jour_annonce == date('m\-d',strtotime('-3 day')))
      $jour = "Il y a 3 jours";
    else if($jour_annonce == date('m\-d',strtotime('-4 day')))
      $jour = "Il y a 4 jours";
    else if($jour_annonce == date('m\-d',strtotime('-5 day')))
      $jour = "Il y a 5 jours";
    else if($jour_annonce == date('m\-d',strtotime('-6 day')))
      $jour = "Il y a 6 jours";
    else if($jour_annonce == date('m\-d',strtotime('-7 day')))
      $jour = "Il y a une semaine";
 
    else{
      $h = explode("-", $jour_annonce);
      $moi = $h[0];
      $jou = $h[1];
      $jour = 'le '.$jou.'/'.$moi;
    }
     
        echo '
        <a href="'.RACINE.'annonce/'.$n->id.'">
            <div class="bandeau-annonce" >
                <div class = "annonceAcceuil"  style="margin-top:2px">
            ';
              
            if($n->photos != "")
            {
              $photo = pathinfo(strtok($n->photos,";"));
              $photo_mini = RACINE.$photo['dirname'].'/mini_'.$photo['basename'];
              echo '  
                    <div class="bloc-images-annonce">
                        <img src="'.$photo_mini.'" border="4"  alt="petite annonce" style="max-width: 150px;max-height: 80px;">
                    </div>
              ';
            }else{
              ?>
                    <div class="bloc-images-annonce">
                      <img src="<?php echo RACINE;?>images/no_photo2.png" alt="pas de photo" height="75" width="75" border="4">
                    </div>
                
            <?php
            }
            ?>
  
                    <div class="blocTitre" style="">
                        <div class="titre-annonce-acceuil " ><span><?php echo $n->titre ?></span></div> 
                        <div class="clear"></div>              
                        <div class="desc-annonce-acceuil text ">
                           <?php echo substr(strip_tags($n->desc),0,40);
                            if (strlen($n->desc) > 40 ) 
                                echo '...';
                            ?>
                        </div>                                                           
                        <div class="clear"></div>
                        <div class="date-annonce-acceuil" style="float:left;width:140px;margin-top:5px"><?php echo $jour." &agrave; ".$heure_annonce ;?></div>
                    </div>
  
                    <div class="blocGeo" style="">
                        <div class="text bold" style="float:right;"><?php echo '('.$n->dep_user.')';?></div>
                      <div class="text bold" style="float:right;margin-top:5px;clear:both"><?php echo substr($n->ville_user,0,30);?></div> 
                        <div class="clear"></div>
                     <?
                          if($n->map == "on"){
                     ?>
                        <div class="map" style="">  
                            <img  src="<?php echo RACINE; ?>images/localisation.png" height="25" width="25" border="4" alt="localisation" />
                            <span><b> Localisation du vendeur sur la carte<br/> Itin&eacute;raire vers vendeur</b></span>
                        </div>
                     <?php
                       }     
                      ?>
                  </div>
      
                  <div class="blocPrix" style="">
                    <div>
                      <?php echo $n->prix.' &#8364;';
                          if($n->debat == 'on')
                      ?> 
                          <span style="font-size:12px">(&agrave; d&eacute;battre)</span>
                      </div>
                  </div>      
      
              </div>
              <div class="clear"></div>   
            </div>
            <div class="clear"></div>           
        </a>
        <div class="clear"></div>
                  
<?php
}
?>
        <div style="margin-top: 10px;">
            <?php echo paginate('/index.php?page=search'.$url_paginate.'&tri='.$tri.'&nba='.$nba, '&p=', $countp, $current);  ?>    
        </div>
        <div class="clear"></div>
    </div>
      
    <?php $smarty->display('footer.tpl'); ?>

    <div itemscope itemtype="http://data-vocabulary.org/Review-aggregate" style="display:block">
        <span itemprop="itemreviewed">Prixdupro</span>
        <span itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">
            <span itemprop="average">9.2</span>
            <span itemprop="best">10</span>
        </span>
        <span itemprop="votes">308</span>
        <span itemprop="count">308</span>
    </div> 

    
    </body>
  
    <!-- Google Tag Manager -->
    <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-M39RRF"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-M39RRF');</script>
    <!-- End Google Tag Manager -->
  
  
      <!-- AddThis Smart Layers BEGIN -->
      <!-- Go to http://www.addthis.com/get/smart-layers to customize -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#async=1"></script>
    <script type="text/javascript">
        var addthis_config = addthis_config||{};
        addthis_config.pubid = 'ra-530330b3451ac849';
        
        addthis.layers({
          'theme' : 'transparent',
          'share' : {
            'position' : 'left',
            'services' : 'facebook,twitter,google_plusone_share,email,more',
            //'numPreferredServices' : 5,
            'postShareTitle' : 'Merci d\'avoir partag? ^^',
            'postShareFollowMsg' : 'Suivez-moi ?'
          }, 
          'follow' : {
            'services' : [
              {'service': 'twitter', 'id': 'Rezki93'},
              {'service': 'google_follow', 'id': 'u/0/108228945793274709693/about'}
            ]
          },  
          'whatsnext' : {'title': 'On vous recommande cette page:'}
          
        });
        
        //Chargement asynchrone de addthis
        addthis.init()
          
    </script> 
  
</html>
      
