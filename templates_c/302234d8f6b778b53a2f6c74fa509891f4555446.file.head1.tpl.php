<?php /* Smarty version Smarty-3.0.6, created on 2018-11-15 00:44:30
         compiled from "./templates/head1.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7462358905becb35e8d9137-62071332%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '302234d8f6b778b53a2f6c74fa509891f4555446' => 
    array (
      0 => './templates/head1.tpl',
      1 => 1478433057,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7462358905becb35e8d9137-62071332',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<META NAME="Keywords" CONTENT="petites annonces, petite annonce,petites annonces géolocalisées, bonnes affaires, bonne affaire, voiture occasion, immobilier, vendre, acheter, pas cher, gratuit, deposer annonce, leboncoin, ebay">
	<meta name="robots" content="all" />
	<meta name="language" content="fr" />
	<meta name="google-site-verification" content="EQXbtEpN9qP8yY9n84VMKcE35nag8FDppzJWAUG6B90" />
        
		
	<!-- Reglage de la plupart des probleme de IE 7 -->
	<!--[if lt IE 9]>
		<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
	<![endif]-->


	<!--jquery -->
	<script type="text/javascript" src="/js/jquery-1.4.2.min.js"></script>
       <!-- <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js" ></script>-->
	<script type="text/javascript" src="/js/jquery.fileinput-2.0.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	
	<link type="text/css" href="/css/gabriel.css" rel="stylesheet" />	
	<link type="text/css" href="/css/pagination.css" rel="stylesheet" />
	<link type="text/css" href="/css/acceuil.css" rel="stylesheet" />
        <link type="text/css" href="/css/banniere.css" rel="stylesheet" />  


	



	
	<!-- Traitement des formulaires -->
	<script type="text/javascript" src="/js/index.js"></script>
	
	<!-- Menu principal -->
	<script type="text/javascript" src="/js/jquery-ui-1.8.2.custom.min.js"></script>
	
	<!-- liste des Themes css dispo : 
	base, black-tie, blitzer, cupertino, dark-hive, dot-luv, eggplant, excite-bike, flick, hot-sneaks, humanity,
	le-frog, mint-choc, overcast, pepper-grinder,	redmond, smoothness, south-street, start, sunny, swanky-purse,
	trontastic, ui-darkness, ui-lightness, et vader
	
	<link type="text/css" href="/css/ui-lightness/jquery-ui-1.8.2.custom.css" rel="stylesheet" />
	-->
	
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/black-tie/jquery-ui.css" rel="stylesheet" type="text/css"/>
	
	
	<!-- affichage ajax departement -->
	<script type="text/javascript" src="/js/dept_xhr.js"></script>
	
	<script type="text/javascript" src="/js/jquery.scrollTo.js"></script>

	<!-- Effet zoom images -->
	<script type="text/javascript" src="/js/top_up-min.js"> </ script>  
	<link href="/css/lytebox.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="/js/lytebox.js"></script> 
	
	<!--Validation des formulaires -->
	<link rel="stylesheet" href="/css/jquery.validation/validationEngine.jquery.css" type="text/css" media="screen" title="no title" />
	<link rel="stylesheet" href="/css/jquery.validation/template.css" type="text/css" media="screen" title="no title"  />
	<script src="/js/jquery.validation/jquery.validationEngine-fr.js" type="text/javascript"></script>  
	<script src="/js/jquery.validation/jquery.validationEngine.js" type="text/javascript"></script>

	<script type="text/javascript" src="/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript">
	tinyMCE.init({
			// General options
			mode : "textareas",
			theme : "advanced",
			plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

			
			force_br_newlines : true,
			force_p_newlines : false,
			forced_root_block : '',
		
			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist,emotions,image,|,forecolor,backcolor,|,code,",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
			

			// Skin options
			skin : "o2k7",
			skin_variant : "silver",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "js/template_list.js",
			external_link_list_url : "js/link_list.js",
			external_image_list_url : "js/image_list.js",
			media_external_list_url : "js/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
					username : "Some User",
					staffid : "991234"
			}
	});
</script>


      <script type="text/javascript" src="/js/google_analytics2.js"></script>

    <script type="text/javascript">
        //script to set meta tag for smaller screen devices
        var nua = navigator.userAgent;
        var is_android = ((nua.indexOf('Mozilla/5.0') > -1 && nua.indexOf('Android ') > -1 && nua.indexOf('AppleWebKit') > -1) && !(nua.indexOf('Chrome') > -1));
        var isMobile = {
            Android: function () {
                return navigator.userAgent.match(/Android/i);
            }
        };
        if (window.screen.width < 730) {
            document.write('<meta name="viewport" content="width=480" />');
        } else {
            document.write('<meta name="viewport" content="width=device-width, initial-scale=1.0" />');
        }

        if (is_android && isMobile.Android()) {
            document.write('<meta name="viewport" content="width=480" />');
        }

    </script>

