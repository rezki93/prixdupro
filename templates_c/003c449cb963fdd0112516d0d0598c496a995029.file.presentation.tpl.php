<?php /* Smarty version Smarty-3.0.6, created on 2018-11-15 00:21:33
         compiled from "templates/presentation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8782324605becadfdb9c0e0-81211358%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '003c449cb963fdd0112516d0d0598c496a995029' => 
    array (
      0 => 'templates/presentation.tpl',
      1 => 1478433056,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8782324605becadfdb9c0e0-81211358',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<! -- Mise en forme des boutons -->    
<script type="text/javascript">
       $(function() {
         $( "#map_annonce" ).button();  
         $( "#affiche_adresse" ).button();     
         $( "#affiche_tel" ).button();  
         $( "#debat_annonce" ).button();
       });
     </script>

<!-- Tabs -->

<div id="tabs"  style="margin-left:auto;margin-right:auto;min-height:100px ">
	<ul>
		<li><a href="#tabs-1">Rechercher</a></li>
		<li><a href="#tabs-2">D&eacute;poser une annonce</a></li>
		<li><a href="#tabs-3">Cr&eacute;ation de compte</a></li>
		<a href="deposer-annonce" style="float: right;background-color: white;width: 300px;text-align: center;color: orange;margin-top: 0px;padding: 6px;border-radius: 10px;">Page D&eacute;pot d'annonce</a>
	</ul>
	
	<div id="tabs-1" style="">
		<form method="get" name="rechercher" action="http://www.prixdupro.fr/index.php?page=search">
			<div class="blocInputRecherche" style="margin:0">
				<div style="float:left;margin: 3px;">Mots clés :</div>
				<input type="text" class="zone-saisie" style="width:140px;float:right" id="search_mot" name="search_mot" onclick="if (this.value == 'Entrez votre recherche') this.value='';" value="<?php if (isset($_REQUEST['search_mot'])){?><?php echo $_REQUEST['search_mot'];?>
<?php }?>"/>
			</div>
			
			<div class="blocInputRecherche">
				<div style="float:left;margin: 3px;">Categorie :</div>
				<input id="search_categorie_hidden" type="hidden" value="<?php if (isset($_REQUEST['search_categorie'])){?><?php echo $_REQUEST['search_categorie'];?>
<?php }?>"/>
				
				<SELECT style="float:right;width:140px;" id="search_categorie" name="search_categorie" >
					<OPTION  VALUE="--">Toutes</OPTION>
					<optgroup label="Vehicules">
						<OPTION id="osc1" VALUE="1">Auto</OPTION>
						<OPTION id="osc2" VALUE="2">Moto</OPTION>
						<OPTION id="osc3" VALUE="3">Caravaning</OPTION>
						<OPTION id="osc4" VALUE="4">Utilitaires</OPTION>
						<OPTION id="osc5" VALUE="5">Equipement Auto</OPTION>
						<OPTION id="osc6" VALUE="6">Equipement Moto</OPTION>
						<OPTION id="osc7" VALUE="7">Equipement Caravaning</OPTION>
					</optgroup>
					

					<optgroup label="Hi-Tech">
						<OPTION id="osc8" VALUE="8">Image/Son</OPTION>
						<OPTION id="osc9" VALUE="9">Informatique</OPTION>
						<OPTION id="osc10" VALUE="10">Consoles/Jeux video</OPTION>
						<OPTION id="osc11" VALUE="11">Téléphonie</OPTION>
					</optgroup>
					
					<optgroup label="Maison">
						<OPTION id="osc12" VALUE="12">Immobilier</OPTION>
						<OPTION id="osc13" VALUE="13">Ameublement</OPTION>
						<OPTION id="osc14" VALUE="14">Electromenager</OPTION>
						<OPTION id="osc15" VALUE="15">Bricolage/Jardinage</OPTION>
						<OPTION id="osc16" VALUE="16">Vêtements</OPTION>
						<OPTION id="osc17" VALUE="17">Accessoire/Bagagerie</OPTION>
						<OPTION id="osc18" VALUE="18">Montres/Bijoux</OPTION>
						<OPTION id="osc19" VALUE="19">Equipement Bebe</OPTION>
					</optgroup>
					
					<optgroup label="Loisirs">
						<OPTION id="osc20" VALUE="20">DVD</OPTION>
						<OPTION id="osc21" VALUE="21">CD</OPTION>
						<OPTION id="osc22" VALUE="22">Bluray</OPTION>
						<OPTION id="osc23" VALUE="23">Livres</OPTION>
						<OPTION id="osc24" VALUE="24">Animaux</OPTION>
						<OPTION id="osc25" VALUE="25">Sports/Hobbies</OPTION>
						<OPTION id="osc26" VALUE="26">Collection</OPTION>
						<OPTION id="osc27" VALUE="27">Jeux/Jouets</OPTION>
						<OPTION id="osc28" VALUE="28">Vins/Gastronomie</OPTION>
					</optgroup>
					
					<optgroup label="Emplois & services">
						<OPTION id="osc29" VALUE="29">Billeterie</OPTION>
						<OPTION id="osc30" VALUE="30">Evenements</OPTION>
						<OPTION id="osc31" VALUE="31">Services</OPTION>
						<OPTION id="osc32" VALUE="32">Emplois</OPTION>
						<OPTION id="osc33" VALUE="33">Cours Particuliers</OPTION>
					</optgroup>
                                        <OPTION id="osc34" VALUE="34">Recherche</OPTION>
					<OPTION id="osc35" VALUE="35">Autre</OPTION>
					
				</SELECT>
				<script type="text/javascript">var a = $("#search_categorie_hidden").val();if(a != null && a != "" && a != "--" )document.getElementById('search_categorie').selectedIndex=a;</script>
			</div>

			
			<div class="blocInputRecherche">
				<div style="float:left;margin: 3px;">Region :</div>
				<input id="search_region_hidden" type="hidden" value="<?php if (isset($_REQUEST['search_region'])){?><?php echo $_REQUEST['search_region'];?>
<?php }?>"/>
				

			<div style="float:left">
				<img id="icone-france" src="images/carte-france.gif" alt ="carte de france" style="cursor:pointer" onclick="if($('#carte-france').is(':hidden')) $('#carte-france').css('display','block'); else $('#carte-france').css('display','none'); ">
				
				<div id="carte-france">
					<div class="blue" style="float:left">Cliquez sur votre region</div>
					<div class="" style="float:right;cursor:pointer" onclick="javascript:region_search(0);">Fermer</div>
					<div class="clear"></div>
					<img src="/images/carte_regions.png" alt="carte régions" USEMAP="#m_carte_regions">
					<map id="m_carte_regions" name="m_carte_regions">
						<area class="region-area" href="javascript:region_search(15);"value="54,55,57,88" title="Lorraine-Luxembourg" href="javascript:;" coords="207,51,207,48,204,48,201,49,196,47,194,48,189,42,187,42,185,41,180,42,176,39,172,40,170,39,169,40,166,39,163,47,162,52,164,53,163,58,161,58,162,61,164,62,170,67,170,70,174,71,174,74,173,76,177,79,182,78,182,80,186,79,188,82,189,80,193,83,197,76,198,73,200,70,199,69,198,66,201,62,203,59,201,58,198,59,196,56,198,52,202,55,206,54,207,51,207,51,207,51" shape="poly" id="lorraine">
						<area class="region-area" href="javascript:region_search(20);"value="16,17,79,86" title="Poitou-Charentes" href="javascript:;" coords="60,139,63,139,65,140,65,143,68,144,70,146,72,145,73,143,77,141,77,138,80,138,82,133,85,131,90,126,87,121,92,117,96,115,93,108,93,104,91,104,87,98,83,99,83,95,79,94,76,95,67,95,65,97,57,94,61,98,62,101,66,104,65,106,65,111,66,113,63,114,62,113,56,113,54,115,58,120,56,120,57,123,55,126,53,127,51,125,47,123,47,125,51,128,52,130,52,130,53,130,55,132,58,135,60,139" shape="poly" id="poitou">
						<area class="region-area" href="javascript:region_search(13);"value="11,30,34,48,66" title="Languedoc-Roussillon-Espagne" href="javascript:;" coords="113,193,116,191,114,188,117,186,119,188,122,186,123,186,125,182,127,182,130,181,130,179,132,177,129,176,130,173,126,172,126,165,124,162,126,156,130,154,132,155,133,158,134,158,135,155,136,155,136,157,140,158,142,167,144,168,144,170,147,171,148,169,151,170,150,171,156,170,155,173,157,177,158,180,153,182,153,186,150,187,150,189,147,189,146,191,144,191,143,189,137,191,135,194,131,196,126,197,123,200,122,203,122,206,122,212,123,213,125,216,124,217,122,216,117,216,115,218,113,217,111,219,108,217,106,215,101,218,98,214,105,209,104,208,102,208,99,206,102,204,102,200,98,196,98,193,100,193,100,191,103,192,105,191,108,192,108,191,113,193,113,193" shape="poly" id="languedoc">    
						<area class="region-area" href="javascript:region_search(16);"value="09,12,31,32,46,65,81,82" title="Midi-Pyrénées-Espagne" href="javascript:;" coords="122,186,119,188,117,186,114,188,116,191,113,193,108,191,108,192,105,191,103,192,100,191,100,193,98,193,98,196,102,200,102,204,99,206,102,208,104,208,105,209,98,214,96,213,97,211,95,210,91,210,90,207,87,207,82,204,78,203,78,207,75,206,73,206,71,207,69,206,65,206,61,203,62,198,64,198,64,196,68,192,68,189,67,188,67,184,62,185,64,183,64,177,68,175,69,176,71,174,74,174,77,173,81,174,82,173,82,172,86,172,87,168,85,167,85,166,88,166,88,163,90,161,90,160,93,159,93,157,96,152,100,152,108,152,107,156,109,157,109,160,110,161,115,161,120,154,122,158,124,158,124,162,126,165,126,172,130,173,129,176,132,177,130,179,130,181,127,182,125,182,123,186,122,186" shape="poly" id="midi">    
						<area class="region-area" href="javascript:region_search(9);"value="2A,2B,20" title="Corse" href="javascript:;" coords="224,193,223,199,221,198,219,200,215,201,212,206,212,208,211,209,211,212,214,212,211,215,214,215,212,218,216,219,214,221,215,223,215,224,218,224,221,227,223,224,224,216,224,214,227,211,227,204,226,199,226,193,224,192,224,193" shape="poly" id="corse">
						<area class="region-area" href="javascript:region_search(21);"value="04,05,06,13,83,84,98" title="Provence-Cote d'Azur-Italie" href="javascript:;" coords="172,199,166,199,165,198,166,196,164,194,160,195,159,193,156,193,156,195,152,194,150,192,146,191,147,189,150,189,150,187,153,186,153,182,158,180,157,177,155,173,156,170,159,172,164,170,162,174,165,172,169,175,170,174,172,174,173,173,171,170,169,170,168,168,169,167,172,167,173,165,171,164,172,163,174,163,176,159,178,159,179,158,182,157,185,158,186,155,182,154,183,151,186,153,190,150,195,157,197,158,198,162,196,162,195,163,194,166,196,168,194,170,196,172,200,174,205,176,210,175,211,178,208,180,206,186,202,186,198,190,196,190,194,194,191,194,189,197,192,197,189,200,186,199,185,201,181,200,181,202,176,201,177,203,173,202,172,199" shape="poly" id="provence">    
						<area class="region-area" href="javascript:region_search(2);"value="24,33,40,47,64" title="Aquitaine-Espagne" href="javascript:;" coords="90,160,90,161,88,163,88,166,85,166,85,167,87,168,86,172,82,172,82,173,81,174,77,173,74,174,71,174,69,176,68,175,64,177,64,183,62,185,67,184,67,188,68,189,68,192,64,196,64,198,62,198,61,203,55,202,53,199,45,195,44,194,42,195,40,195,41,190,40,188,38,190,37,188,35,188,34,186,37,186,40,184,43,180,46,173,48,158,49,156,53,156,51,153,50,154,52,146,53,134,54,133,55,135,58,139,60,147,60,139,63,139,65,140,65,143,68,144,70,146,72,145,73,143,77,141,77,138,80,138,82,133,85,131,89,134,93,139,95,138,95,141,93,144,96,147,96,152,93,157,93,159,90,160,90,160" shape="poly" id="aquitaine">    
						<area class="region-area" href="javascript:region_search(22);"value="01,07,26,38,42,69,73,74" title="Rhône-Alpes-Italie" href="javascript:;" coords="157,122,158,120,159,115,166,115,167,116,165,118,168,121,171,120,173,122,181,116,183,121,179,124,180,125,180,125,185,123,185,120,188,118,195,118,196,122,193,123,195,125,198,128,198,131,194,132,194,135,197,138,198,141,200,143,199,145,199,148,197,148,195,150,190,150,186,153,183,151,182,154,186,155,185,158,182,157,179,158,178,159,176,159,174,163,172,163,171,164,173,165,172,167,169,167,168,168,169,170,171,170,173,173,172,174,170,174,169,175,165,172,162,174,164,170,159,172,156,170,150,171,151,170,148,169,147,171,144,170,144,168,142,167,140,158,147,155,147,153,148,153,149,151,151,151,151,148,149,145,148,145,147,143,142,144,142,140,139,134,139,132,138,129,140,127,141,121,142,121,144,123,149,123,153,119,157,122" shape="poly" id="rhone">    
						<area class="region-area" href="javascript:region_search(3);"value="03,15,43,63" title="Auvergne" href="javascript:;" coords="119,124,114,119,113,115,119,113,119,109,128,106,128,108,134,110,138,108,141,113,144,115,144,118,142,121,141,121,140,127,138,129,139,132,139,134,142,140,142,144,147,143,148,145,149,145,151,148,151,151,149,151,148,153,147,153,147,155,140,158,136,157,136,155,135,155,134,158,133,158,132,155,130,154,126,156,124,162,124,158,122,158,120,154,115,161,110,161,109,160,109,157,107,156,108,152,110,150,110,148,112,146,113,143,117,142,117,141,117,138,118,136,116,134,117,132,115,130,119,128,119,124" shape="poly" id="auvergne">   
						<area class="region-area" href="javascript:region_search(14);"value="19,23,87" title="Limousin" href="javascript:;" coords="95,138,93,139,89,134,85,131,90,126,87,121,92,117,96,115,100,115,104,115,111,115,113,115,114,119,119,124,119,128,115,130,117,132,116,134,118,136,117,138,117,142,113,143,112,146,110,148,110,150,108,152,100,152,96,152,96,147,93,144,95,141,95,138" shape="poly" id="limousin">
						<area class="region-area" href="javascript:region_search(5);"value="21,58,71,89" title="Bourgogne" href="javascript:;" coords="128,87,126,83,129,79,128,74,126,73,130,68,135,68,138,70,138,72,140,73,143,79,148,78,149,80,157,76,162,82,162,85,164,87,169,87,171,89,169,92,170,94,170,97,164,104,167,107,164,108,167,111,166,115,159,115,158,120,157,122,153,119,149,123,144,123,142,121,144,118,144,115,141,113,138,108,134,110,128,108,128,106,128,104,127,101,127,94,126,91,126,88,128,87" shape="poly" id="bourgogne">    
						<area class="region-area" href="javascript:region_search(10);"value="25,39,70,90" title="Franche-Comté-Suisse" href="javascript:;" coords="193,83,196,85,197,87,199,89,198,91,196,92,194,93,198,94,198,95,188,104,187,107,182,110,182,110,183,113,181,116,173,122,171,120,168,121,165,118,167,116,166,115,167,111,164,108,167,107,164,104,170,97,170,94,169,92,171,89,169,88,171,85,172,86,174,85,174,83,177,79,182,78,182,80,186,79,188,82,189,80,193,83" shape="poly" id="franchecomte">    
						<area class="region-area" href="javascript:region_search(7);"value="18,28,36,37,41,45" title="Centre" href="javascript:;" coords="111,115,104,115,100,115,96,115,93,108,93,104,91,104,87,98,83,99,83,95,79,94,78,91,81,89,82,82,89,82,90,79,93,76,93,72,96,72,93,68,93,65,96,64,96,61,95,60,96,57,103,54,105,56,105,60,109,63,112,68,118,68,120,72,128,74,129,79,126,83,128,87,126,88,126,91,127,94,127,101,128,104,128,105,128,106,119,109,119,113,113,115,111,115" shape="poly" id="centre">    
						<area class="region-area" href="javascript:region_search(18);"value="44,49,53,72,85" title="Pays de la Loire" href="javascript:;" coords="80,63,86,62,87,63,87,65,90,67,93,68,96,72,93,72,93,77,90,79,89,82,82,83,81,89,78,91,79,94,76,95,67,95,65,97,57,94,61,98,62,101,66,104,65,106,65,111,66,113,63,114,62,113,56,113,53,112,49,108,47,107,45,102,41,98,43,97,43,95,45,94,45,93,42,91,44,88,50,88,43,87,41,88,36,86,38,86,37,84,40,82,43,81,44,77,48,77,50,76,53,76,55,74,58,76,61,73,61,71,64,71,64,69,62,65,64,63,64,57,67,58,69,60,77,58,79,60,80,63,80,63" shape="poly" id="paysloire">    
						<area class="region-area" href="javascript:region_search(1);"value="67,68" title="Alsace-Allemagne" href="javascript:;" coords="200,70,199,69,198,66,201,62,203,59,201,58,198,59,196,56,198,52,202,55,206,54,207,51,209,51,218,53,217,57,214,59,208,76,208,78,206,84,207,87,204,91,202,92,201,93,199,90,199,89,197,87,196,85,193,83,197,76,198,73,200,70" shape="poly" id="alsace">    
						<area class="region-area" href="javascript:region_search(8);"value="08,10,51,52" title="Champagne-Ardennes" href="javascript:;" coords="157,76,157,76,152,78,149,80,148,79,143,79,140,73,138,72,138,70,135,68,136,63,138,62,137,55,140,54,140,48,142,49,141,44,148,43,148,41,149,37,152,32,152,28,156,28,162,24,162,33,164,33,170,39,169,40,166,39,163,47,162,52,164,53,163,58,161,58,162,61,164,62,170,67,170,70,174,71,174,74,173,76,177,79,174,83,174,85,172,86,171,85,169,88,164,87,162,85,162,82,157,76,157,76" shape="poly" id="champagne">    
						<area class="region-area" href="javascript:region_search(6);"value="22,29,35,56" title="Bretagne" href="javascript:;" coords="44,77,43,81,40,82,34,82,31,79,34,79,34,78,30,78,28,79,28,82,27,81,27,78,27,76,24,75,23,75,20,72,15,71,14,69,11,69,11,72,7,70,6,67,4,65,1,63,7,63,10,62,7,60,6,61,5,59,4,58,6,57,7,58,11,58,9,56,10,55,7,56,3,56,1,53,3,53,3,51,9,49,11,50,16,49,18,51,20,49,21,51,26,47,29,47,33,45,33,48,35,50,38,55,42,53,46,52,46,55,48,54,49,55,50,55,50,53,53,53,52,54,53,55,56,55,56,58,59,59,61,57,64,57,64,63,62,65,64,69,64,71,61,71,61,73,58,76,55,74,53,76,50,76,48,77,44,77,44,77" shape="poly" id="bretagne">
						<area class="region-area" href="javascript:region_search(12);" value="75,77,78,91,92,93,94,95" title="Ile de France" href="javascript:;" coords="126,73,120,72,118,68,112,68,109,63,105,60,105,56,103,54,104,49,108,47,114,46,116,48,119,47,122,50,132,51,132,49,137,55,138,62,136,63,135,68,130,68,126,73" shape="poly" id="idf">
						<area class="region-area" href="javascript:region_search(4);"value="14,50,61" title="Basse Normandie" href="javascript:;" coords="92,51,96,57,95,60,96,61,96,64,93,65,93,68,90,67,87,65,87,63,86,62,80,63,79,60,77,58,69,60,67,58,61,57,59,59,56,58,56,55,59,55,57,52,58,41,55,33,56,30,54,29,55,28,57,29,61,29,64,29,66,29,65,31,64,33,66,37,68,37,81,40,85,38,87,38,89,43,89,50,92,51" shape="poly" id="bassenormandie">
						<area class="region-area" href="javascript:region_search(11);"value="27,76" title="Haute Normandie" href="javascript:;" coords="108,42,108,47,104,49,103,54,96,57,93,53,92,51,89,50,89,43,87,38,90,37,93,37,89,36,88,36,85,35,87,32,90,30,95,28,102,26,105,24,107,22,107,26,109,29,110,33,108,38,110,39,108,42" shape="poly" id="hautenormandie">
						<area class="region-area" href="javascript:region_search(19);"value="02,60,80" title="Picardie" href="javascript:;" coords="132,49,132,51,122,50,119,47,116,48,114,46,108,47,108,42,109,39,108,38,110,33,109,29,107,26,107,19,109,17,111,18,115,19,118,22,124,22,123,24,134,26,136,29,140,27,143,28,147,27,149,30,152,28,152,32,149,37,148,43,141,44,142,49,140,48,140,54,137,55,132,49" shape="poly" id="picardie">
						<area class="region-area" href="javascript:region_search(17);"value="59,62" title="Nord-Pas de Calais" href="javascript:;" coords="134,26,123,24,124,22,118,22,115,19,111,18,109,17,111,5,113,3,119,2,126,1,128,7,130,10,136,8,138,15,142,15,143,20,151,20,152,28,149,30,147,27,143,28,140,27,136,29,134,26" shape="poly" id="nord">
					</map>
					
					<script type="text/javascript">
						function region_search(a){
							$("#carte-france").css("display","none");
							if(a != 0)
								document.getElementById('search_region').selectedIndex=a;
						}
					</script>
					
				</div>
			</div>

				<SELECT style="float:right;width:140px;" id="search_region" name="search_region">
					<OPTION id="osr--" VALUE="--">Toutes</OPTION>
					<OPTION id="osr1" VALUE="1">Alsace</OPTION>
					<OPTION id="osr2" VALUE="2">Aquitaine</OPTION>
					<OPTION id="osr3" VALUE="3">Auvergne</OPTION>
					<OPTION id="osr4" VALUE="4">Basse-Normandie</OPTION>
					<OPTION id="osr5" VALUE="5">Bourgogne</OPTION>
					<OPTION id="osr6" VALUE="6">Bretagne</OPTION>
					<OPTION id="osr7" VALUE="7">Centre</OPTION>
					<OPTION id="osr8" VALUE="8">Champagne-Ardenne</OPTION>
					<OPTION id="osr9" VALUE="9">Corse</OPTION>
					<OPTION id="osr10" VALUE="10">Franche-Comté</OPTION>
					<OPTION id="osr11" VALUE="11">Haute-Normandie</OPTION>
					<OPTION id="osr12" VALUE="12">Ile-de-France</OPTION>
					<OPTION id="osr13" VALUE="13">Languedoc-Roussillon</OPTION>
					<OPTION id="osr14" VALUE="14">Limousin</OPTION>
					<OPTION id="osr15" VALUE="15">Lorraine</OPTION>
					<OPTION id="osr16" VALUE="16">Midi-Pyrénés</OPTION>
					<OPTION id="osr17" VALUE="17">Nord-Pas-De-Calais</OPTION>
					<OPTION id="osr18" VALUE="18">Pays de la Loire</OPTION>
					<OPTION id="osr19" VALUE="19">Picardie</OPTION>
					<OPTION id="osr20" VALUE="20">Poitou-Charentes</OPTION>
					<OPTION id="osr21" VALUE="21">Alpes-Côte d'Azur</OPTION>
					<OPTION id="osr22" VALUE="22">Rhône-Alpes</OPTION>
					<OPTION id="osr23" VALUE="23">Departements d'outre Mer</OPTION>

				</SELECT>
				<script type="text/javascript">var a = $("#search_region_hidden").val();if(a != null && a != "" && a != "--" ){ document.getElementById('search_region').selectedIndex=a;}</script>
			
			</div>


			
			
			
			<div class="clear"></div>
			
			<div id="bloc_prix" class="blocInputRecherche" style="margin:0">
				<div style="">
					<div style="float:left;margin: 3px;">Prix min :</div>
					<div style="float:right">
						<input id="search_prixmin_hidden" type="hidden" value="<?php if (isset($_REQUEST['search_prixmin'])){?><?php echo $_REQUEST['search_prixmin'];?>
<?php }?>"/>
						<SELECT style="float:left;width:80px;" name="search_prixmin" id="search_prixmin">
							<OPTION VALUE="--">--</OPTION>
							<OPTION id="opmin0000" VALUE="0000">0 &euro;</OPTION>
							<OPTION id="opmin0050" VALUE="0050">50 &euro;</OPTION>
							<OPTION id="opmin0100" VALUE="0100">100 &euro;</OPTION>
							<OPTION id="opmin0200" VALUE="0200">200 &euro;</OPTION>
							<OPTION id="opmin0300" VALUE="0300">300 &euro;</OPTION>
							<OPTION id="opmin0500" VALUE="0500">500 &euro;</OPTION>
							<OPTION id="opmin1000" VALUE="1000">1000 &euro;</OPTION>
							<OPTION id="opmin2000" VALUE="2000">2000 &euro;</OPTION>
							<OPTION id="opmin3000" VALUE="3000">3000 &euro;</OPTION>
							<OPTION id="opmin4000" VALUE="4000">4000 &euro;</OPTION>
							<OPTION id="opmin5000" VALUE="5000">5000 &euro;</OPTION>
							<OPTION id="opmin6000" VALUE="6000">6000 &euro;</OPTION>
							<OPTION id="opmin7000" VALUE="7000">7000 &euro;</OPTION>
							<OPTION id="opmin8000" VALUE="8000">8000 &euro;</OPTION>
						</SELECT>
						<script type="text/javascript">var a = $("#search_prixmin_hidden").val();if(a != null && a != "" && a != "--" )document.getElementById('opmin'+a).setAttribute('selected','true');</script>
			
					</div>
				</div>
			
				<div style="clear:both">
					<div style="float:left;margin: 3px;">Prix max :</div>
					<div style="float:right;">
						<input id="search_prixmax_hidden" type="hidden" value="<?php if (isset($_REQUEST['search_prixmax'])){?><?php echo $_REQUEST['search_prixmax'];?>
<?php }?>"/>
						<SELECT style="float:left;width:80px;" name="search_prixmax" id="search_prixmax">
							<OPTION  VALUE="--">--</OPTION>
							<OPTION id="opmax0000" VALUE="0000">0 &euro;</OPTION>
							<OPTION id="opmax0050" VALUE="0050">50 &euro;</OPTION>
							<OPTION id="opmax0100" VALUE="0100">100 &euro;</OPTION>
							<OPTION id="opmax0200" VALUE="0200">200 &euro;</OPTION>
							<OPTION id="opmax0300" VALUE="0300">300 &euro;</OPTION>
							<OPTION id="opmax0500" VALUE="0500">500 &euro;</OPTION>
							<OPTION id="opmax1000" VALUE="1000">1000 &euro;</OPTION>
							<OPTION id="opmax2000" VALUE="2000">2000 &euro;</OPTION>
							<OPTION id="opmax3000" VALUE="3000">3000 &euro;</OPTION>
							<OPTION id="opmax4000" VALUE="4000">4000 &euro;</OPTION>
							<OPTION id="opmax5000" VALUE="5000">5000 &euro;</OPTION>
							<OPTION id="opmax6000" VALUE="6000">6000 &euro;</OPTION>
							<OPTION id="opmax7000" VALUE="7000">7000 &euro;</OPTION>
							<OPTION id="opmax8000" VALUE="8000">8000 &euro;</OPTION>
						</SELECT>
						<script type="text/javascript">var a = $("#search_prixmax_hidden").val();if(a != null && a != "" && a != "--" )document.getElementById('opmax'+a).setAttribute('selected','true');</script>
			
					</div>
				</div>
				
				<div style="clear:both">
					<div style="float:left;margin-left: 3px;">Prix à debattre:</div>
					<input id="search_debat_annonce_hidden" type="hidden" value="<?php if (isset($_REQUEST['search_debat_annonce'])){?><?php echo $_REQUEST['search_debat_annonce'];?>
<?php }?>"/>
					<input type="checkbox" class="zone-saisie" style="float:right" id="search_debat_annonce" name="search_debat_annonce"  />
					<script type="text/javascript">var a = $("#search_debat_annonce_hidden").val();if(a == "on" )document.getElementById('search_debat_annonce').setAttribute('checked','checked');</script>
			
				</div>
			</div>	
	
			
			<div id="bloc_annee" class="blocInputRecherche" style="display:none">
				<div style="">
					<div style="float:left;margin: 3px;">Annee min:</div>
					<div style="float:right;">
						<input id="search_annee_min_hidden" type="hidden" value="<?php if (isset($_REQUEST['search_annee_min'])){?><?php echo $_REQUEST['search_annee_min'];?>
<?php }?>"/>
						<SELECT style="width:80px;" name="search_annee_min">
							<OPTION VALUE="--">--</OPTION>
							<OPTION id="osamin2015" VALUE="2015">2015</OPTION>
							<OPTION id="osamin2014" VALUE="2014">2014</OPTION>
							<OPTION id="osamin2013" VALUE="2013">2013</OPTION>
							<OPTION id="osamin2012" VALUE="2012">2012</OPTION>
							<OPTION id="osamin2011" VALUE="2011">2011</OPTION>
							<OPTION id="osamin2010" VALUE="2010">2010</OPTION>
							<OPTION id="osamin2009" VALUE="2009">2009</OPTION>
							<OPTION id="osamin2008" VALUE="2008">2008</OPTION>
							<OPTION id="osamin2007" VALUE="2007">2007</OPTION>
							<OPTION id="osamin2006" VALUE="2006">2006</OPTION>
							<OPTION id="osamin2005" VALUE="2005">2005</OPTION>
							<OPTION id="osamin2004" VALUE="2004">2004</OPTION>
							<OPTION id="osamin2003" VALUE="2003">2003</OPTION>
							<OPTION id="osamin2002" VALUE="2002">2002</OPTION>
							<OPTION id="osamin2001" VALUE="2001">2001</OPTION>
							<OPTION id="osamin2000" VALUE="2000">2000</OPTION>
							<OPTION id="osamin1999" VALUE="1999">1999</OPTION>
							<OPTION id="osamin1998" VALUE="1998">1998</OPTION>
							<OPTION id="osamin1997" VALUE="1997">1997</OPTION>
							<OPTION id="osamin1996" VALUE="1996">1996</OPTION>
							<OPTION id="osamin1995" VALUE="1995">1995</OPTION>
							<OPTION id="osamin1994" VALUE="1994">1994</OPTION>
							<OPTION id="osamin1993" VALUE="1993">1993</OPTION>
							<OPTION id="osamin1992" VALUE="1992">1992</OPTION>
							<OPTION id="osamin1991" VALUE="1991">1991</OPTION>
							<OPTION id="osamin1990" VALUE="1990">1990</OPTION>
							<OPTION id="osamin1989" VALUE="1989">1989</OPTION>
						</SELECT>
						<script type="text/javascript">var a = $("#search_annee_min_hidden").val();if(a != null && a != "" && a != "--" )document.getElementById('osamin'+a).setAttribute('selected','true');</script>
			
					</div>
				</div>
				
				<div style="clear:both">
					<div style="float:left;margin: 3px;">Annee max:</div>
					<div style="float:right">
						<input id="search_annee_max_hidden" type="hidden" value="<?php if (isset($_REQUEST['search_annee_max'])){?><?php echo $_REQUEST['search_annee_max'];?>
<?php }?>"/>
						<SELECT style="width:80px;" name="search_annee_max">
							<OPTION VALUE="--">--</OPTION>
							<OPTION id="osamax2015" VALUE="2015">2015</OPTION>
							<OPTION id="osamax2014" VALUE="2014">2014</OPTION>
							<OPTION id="osamax2013" VALUE="2013">2013</OPTION>
							<OPTION id="osamax2012" VALUE="2012">2012</OPTION>
							<OPTION id="osamax2011" VALUE="2011">2011</OPTION>
							<OPTION id="osamax2010" VALUE="2010">2010</OPTION>
							<OPTION id="osamax2009" VALUE="2009">2009</OPTION>
							<OPTION id="osamax2008" VALUE="2008">2008</OPTION>
							<OPTION id="osamax2007" VALUE="2007">2007</OPTION>
							<OPTION id="osamax2006" VALUE="2006">2006</OPTION>
							<OPTION id="osamax2005" VALUE="2005">2005</OPTION>
							<OPTION id="osamax2004" VALUE="2004">2004</OPTION>
							<OPTION id="osamax2003" VALUE="2003">2003</OPTION>
							<OPTION id="osamax2002" VALUE="2002">2002</OPTION>
							<OPTION id="osamax2001" VALUE="2001">2001</OPTION>
							<OPTION id="osamax2000" VALUE="2000">2000</OPTION>
							<OPTION id="osamax1999" VALUE="1999">1999</OPTION>
							<OPTION id="osamax1998" VALUE="1998">1998</OPTION>
							<OPTION id="osamax1997" VALUE="1997">1997</OPTION>
							<OPTION id="osamax1996" VALUE="1996">1996</OPTION>
							<OPTION id="osamax1995" VALUE="1995">1995</OPTION>
							<OPTION id="osamax1994" VALUE="1994">1994</OPTION>
							<OPTION id="osamax1993" VALUE="1993">1993</OPTION>
							<OPTION id="osamax1992" VALUE="1992">1992</OPTION>
							<OPTION id="osamax1991" VALUE="1991">1991</OPTION>
							<OPTION id="osamax1990" VALUE="1990">1990</OPTION>
							<OPTION id="osamax1989" VALUE="1989">1989</OPTION>
						</SELECT>
						<script type="text/javascript">var a = $("#search_annee_max_hidden").val();if(a != null && a != "" && a != "--" )document.getElementById('osamax'+a).setAttribute('selected','true');</script>
			
					</div>
				</div>
			</div>
			
			
			<div id="bloc_km" class="blocInputRecherche" style="display:none">
				<div style="">
					<div style="float:left;margin: 3px;">Km min:</div>
					<div style="float:right">
						<input id="search_km_min_hidden" type="hidden" value="<?php if (isset($_REQUEST['search_km_min'])){?><?php echo $_REQUEST['search_km_min'];?>
<?php }?>"/>
						<SELECT style="width:80px;" name="search_km_min">
							<OPTION VALUE="--">--</OPTION>
							<OPTION id="okmin25000" VALUE="25000">25000</OPTION>
							<OPTION id="okmin50000" VALUE="50000">50000</OPTION>
							<OPTION id="okmin75000" VALUE="75000">75000</OPTION>
							<OPTION id="okmin100000" VALUE="100000">100000</OPTION>
							<OPTION id="okmin125000" VALUE="125000">125000</OPTION>
							<OPTION id="okmin150000" VALUE="150000">150000</OPTION>
							<OPTION id="okmin175000" VALUE="175000">175000</OPTION>
							<OPTION id="okmin200000" VALUE="200000">200000</OPTION>
							<OPTION id="okmin225000" VALUE="225000">225000</OPTION>
							<OPTION id="okmin250000" VALUE="250000">250000</OPTION>
	
						</SELECT>
						<script type="text/javascript">var a = $("#search_km_min_hidden").val();if(a != null && a != "" && a != "--" )document.getElementById('okmin'+a).setAttribute('selected','true');</script>
			
					</div>
				</div>
				
				<div style="clear:both">
					<div style="float:left;margin: 3px;">Km max:</div>
					<div style="float:right">
						<input id="search_km_max_hidden" type="hidden" value="<?php if (isset($_REQUEST['search_km_max'])){?><?php echo $_REQUEST['search_km_max'];?>
<?php }?>"/>
						<SELECT style="width:80px;" name="search_km_max">
							<OPTION VALUE="--">--</OPTION>
							<OPTION id="okmax25000" VALUE="25000">25000</OPTION>
							<OPTION id="okmax50000" VALUE="50000">50000</OPTION>
							<OPTION id="okmax75000" VALUE="75000">75000</OPTION>
							<OPTION id="okmax100000" VALUE="100000">100000</OPTION>
							<OPTION id="okmax125000" VALUE="125000">125000</OPTION>
							<OPTION id="okmax150000" VALUE="150000">150000</OPTION>
							<OPTION id="okmax175000" VALUE="175000">175000</OPTION>
							<OPTION id="okmax200000" VALUE="200000">200000</OPTION>
							<OPTION id="okmax225000" VALUE="225000">225000</OPTION>
							<OPTION id="okmax250000" VALUE="250000">250000</OPTION>
						</SELECT>
					</div>
					<script type="text/javascript">var a = $("#search_km_max_hidden").val();if(a != null && a != "" && a != "--" )document.getElementById('okmax'+a).setAttribute('selected','true');</script>
			
				</div>
			</div>
			
			<div id="bloc_energie_boite" class="blocInputRecherche" style="display:none">
				<div style="">
					<div style="float:left;margin: 3px;">Energie :</div>
					<div style="float:right">
						<input id="search_energie_hidden" type="hidden" value="<?php if (isset($_REQUEST['search_energie'])){?><?php echo $_REQUEST['search_energie'];?>
<?php }?>"/>
						<SELECT style="width:50px;" id="search_energie" name="search_energie" >
							<OPTION id="" VALUE="--">--</OPTION>
							<OPTION id="osDiesel" VALUE="Diesel">Diesel</OPTION>
							<OPTION id="osEssence" VALUE="Essence">Essence</OPTION>
							<OPTION id="osElectrique" VALUE="Electrique">Electrique</OPTION>
							<OPTION id="osGPL" VALUE="GPL">GPL</OPTION>
						</SELECT>
						<script type="text/javascript">var a = $("#search_energie_hidden").val();if(a != null && a != "" && a != "--" )document.getElementById('os'+a).setAttribute('selected','true');</script>
			
					</div>
				</div>
				
				<div style="clear:both">
					<div style="float:left;margin: 3px;">Boite :</div>
					<div style="float:right">
						<input id="search_boite_hidden" type="hidden" value="<?php if (isset($_REQUEST['search_boite'])){?><?php echo $_REQUEST['search_boite'];?>
<?php }?>"/>
						<SELECT style="width:50px;" id="search_boite" name="search_boite" >
							<OPTION id="" VALUE="--">--</OPTION>
							<OPTION id="obAutomatique" VALUE="Automatique">Automatique</OPTION>
							<OPTION id="obManuelle" VALUE="Manuelle">Manuelle</OPTION>
						</SELECT>
						<script type="text/javascript">var a = $("#search_boite_hidden").val();if(a != null && a != "" && a != "--" )document.getElementById('ob'+a).setAttribute('selected','true');</script>
			
					</div>
				</div>
			</div>
			
			<script type="text/javascript">var a = $("#search_categorie").val();if(a == 1 || a == 2 || a ==3 ){ $("#bloc_annee").css("display","block");$("#bloc_km").css("display","block");$("#bloc_energie_boite").css("display","block"); }</script>
			
			
			
			<input type="hidden" name="page" value="search">
			
			<div class="blue-button2" id="valider_recherche" style="margin-right:0px;margin-top:0px;">Rechercher</div>
			
			
		</form>
                <div class="clear"></div>
	</div>
	
	<div id="tabs-2" style="">
		<?php if ($_SESSION['etat']=='connecte'){?>
		<form method="POST" name="depot_annonce" enctype="multipart/form-data" action="./index.php?page=depot_annonce">
			<div style="float:left">
			
				<div id="loader" style="position:absolute; margin-left:300px;display:none">
					<img src="images/loading.gif" >
				</div>
				
				<div style="float:left;margin-left:10px">
					<div style="float:left;margin: 3px;width:30px;">Titre</div>
					<input type="text" class="zone-saisie" style="width:140px;" maxlength="40" id="titre_annonce" name="titre_annonce"  value="" />
				</div>
				
				<div style="float:left;margin-left:10px">
					<div style="float:left;margin: 3px;width:30px;text-align: right;">Prix</div>
					<input type="text" class="zone-saisie" style="width:50px;" id="prix_annonce" name="prix_annonce" onclick="" value="" />
				</div>
				
				<div style="float:left;margin-left:10px">
					<div style="float:left;margin: 3px;width:60px;text-align: right;">Categorie</div>
					<SELECT style="width:110px;" id="cat_annonce" name="cat_annonce"  value="">
						<OPTION  VALUE="--">Toutes</OPTION>
						<optgroup label="Vehicules">
							<OPTION VALUE="1">Auto</OPTION>
							<OPTION VALUE="2">Moto</OPTION>
							<OPTION VALUE="3">Caravaning</OPTION>
							<OPTION VALUE="4">Utilitaires</OPTION>
							<OPTION VALUE="5">Equipement Auto</OPTION>
							<OPTION VALUE="6">Equipement Moto</OPTION>
							<OPTION VALUE="7">Equipement Caravaning</OPTION>
						</optgroup>
						

						<optgroup label="Hi-Tech">
							<OPTION VALUE="8">Image/Son</OPTION>
							<OPTION VALUE="9">Informatique</OPTION>
							<OPTION VALUE="10">Consoles/Jeux video</OPTION>
							<OPTION VALUE="11">Telephonie</OPTION>
						</optgroup>
						
						<optgroup label="Maison">
							<OPTION VALUE="12">Immobilier</OPTION>
							<OPTION VALUE="13">Ameublement</OPTION>
							<OPTION VALUE="14">Electromenager</OPTION>
							<OPTION VALUE="15">Bricolage/Jardinage</OPTION>
							<OPTION VALUE="16">Vetements</OPTION>
							<OPTION VALUE="17">Accessoire/Bagagerie</OPTION>
							<OPTION VALUE="18">Montres/Bijoux</OPTION>
							<OPTION VALUE="19">Equipement Bebe</OPTION>
						</optgroup>
						
						<optgroup label="Loisirs">
							<OPTION VALUE="20">DVD</OPTION>
							<OPTION VALUE="21">CD</OPTION>
							<OPTION VALUE="22">Bluray</OPTION>
							<OPTION VALUE="23">Livres</OPTION>
							<OPTION VALUE="24">Animaux</OPTION>
							<OPTION VALUE="25">Sports/Hobbies</OPTION>
							<OPTION VALUE="26">Collection</OPTION>
							<OPTION VALUE="27">Jeux/Jouets</OPTION>
							<OPTION VALUE="28">Vins/Gastronomie</OPTION>
						</optgroup>
						
						<optgroup label="Emplois & services">
							<OPTION VALUE="29">Billeterie</OPTION>
							<OPTION VALUE="30">Evenements</OPTION>
							<OPTION VALUE="31">Services</OPTION>
							<OPTION VALUE="32">Emplois</OPTION>
							<OPTION VALUE="33">Cours Particuliers</OPTION>
						</optgroup>
						<OPTION VALUE="34">Recherche</OPTION>
						<OPTION VALUE="35">Autre</OPTION>
						
					</SELECT>
				</div>
				
				<div id="bloc_auto" style="float:left;">
					<div id="bloc_depot_annee" style="float:left;margin-left:10px;display:none">
						<div style="float:left;margin: 3px;width:40px;text-align: right;">Annee</div>
						<input type="text" class="zone-saisie" style="width:50px;" id="annee_annonce" name="annee_annonce" onclick="" value="" />
					</div>
					
					<div id="bloc_depot_km" style="float:left;margin-left:10px;display:none">
						<div style="float:left;margin: 3px;width:25px;text-align: right;">Km</div>
						<input type="text" class="zone-saisie" style="width:50px;" id="km_annonce" name="km_annonce" onclick="" value="" />
					</div>
					
					<div id="bloc_depot_energie" style="float:left;margin-left:10px;display:none">
						<div style="float:left;margin: 3px;width:45px;text-align: right;">Energie</div>
						<SELECT style="width:50px;" id="energie_annonce" name="energie_annonce" >
							<OPTION id="" VALUE="--">--</OPTION>
							<OPTION id="" VALUE="Diesel">Diesel</OPTION>
							<OPTION id="" VALUE="Essence">Essence</OPTION>
							<OPTION id="" VALUE="Electrique">Electrique</OPTION>
							<OPTION id="" VALUE="GPL">GPL</OPTION>
						</SELECT>
					</div>
					
					<div id="bloc_depot_boite" style="float:left;margin-left:10px;display:none">
						<div style="float:left;margin: 3px;width:35px;text-align: right;">Boite</div>
						<SELECT style="width:50px;" id="boite_annonce" name="boite_annonce" >
							<OPTION id="" VALUE="--">--</OPTION>
							<OPTION id="" VALUE="Automatique">Automatique</OPTION>
							<OPTION id="" VALUE="Manuelle">Manuelle</OPTION>
						</SELECT>
					</div>
					
				</div>
			</div>
			
			<div class="clear"></div>
			
			<div id="bloc_description" style="margin-left:10px">
				<div style="float:left">
					<div style="margin: 3px;width:80px">Description</div>
					<div style="">
						<TEXTAREA width="170px" id="desc_annonce" name="desc_annonce" onkeyup="this.value = this.value.substr(0,2000);" >
						</TEXTAREA>
					</div>
				</div>
			
			</div>
			
			<div id="bloc_photos" style="">
			
				<div id="bloc_photo1" style="">
					<div style="margin: 3px;width:80px">Photo 1</div>
					<input type="file" name="photo1" id="photo1" />
					<input type="hidden" name="MAX_FILE_SIZE" value="10097152" />	
				</div>
				
				<div id="bloc_photo2" style="display:none">
					<div style="margin: 3px;width:80px">Photo 2</div>
					<input type="file" name="photo2" id="photo2" />
					<input type="hidden" name="MAX_FILE_SIZE" value="10097152" />	
				</div>
				
				<div id="bloc_photo3" style="display:none">
					<div style="margin: 3px;width:80px">Photo 3</div>
					<input type="file" name="photo3" id="photo3" style="170px" />
					<input type="hidden" name="MAX_FILE_SIZE" value="10097152" />	
				</div>
			
				<div>
					<div style="margin: 3px;width:230px">Les photos ne doivent pas depasser 2mo</div>
				</div>
				
				
				<div>
					<!--<div style="float:left">Afficher votre telephone :</div>-->
					<input style="" type="checkbox" id="affiche_tel" name="affiche_tel" checked="checked" />
                                        <label for="affiche_tel" style="width:250px;">Afficher votre téléphone</label>
				</div>

				<div>
					<!--<div style="float:left">Prix à débattre:</div>-->
					<input style="" type="checkbox" id="debat_annonce" name="debat_annonce"  />
                                        <label for="debat_annonce" style="width:250px;">Prix à débattre</label>
				</div>
				
				
				<div>
					<!--<div style="float:left;">Localisation Google Map :</div>-->
					<input style="" type="checkbox" id="map_annonce" name="map_annonce" />
                                        <label for="map_annonce" style="width:250px;">Localisation Google Map de votre ville</label>
				</div>
				
				<div>
					<!--<div style="float:left">Localisation avec votre adresse exact:</div>-->
					<input style="" type="checkbox" id="affiche_adresse" name="affiche_adresse" />
                                        <label for="affiche_adresse" style="width:250px;">Utilisation de votre adresse dans google map</label>
				</div>
				
				
			</div>

	
			<div id="indication_erreurs2" style="float:right;color:#CA0036;display:none;width: 120px;">
				<div><b>v&eacute;rifier que :</b></div>
				<div>- Les champs soient remplis</div>
				<div>- La cat&eacute;gorie soit selectionn&eacute;e</div>
				<div>- Le prix soit un chiffre (sans le &#x20AC;)</div>
			</div>
			
			
			<div style="width:100%;float:left;">
				<div class="blue-button2" id="deposer_annonce" style="margin-right:0px;margin-bottom: 10px;">Deposer</div>
			</div>
		</form>
		
			<?php }elseif($_SESSION['etat']=='deconnecte'){?>
			<div style="float:left">
				<div style=" margin-bottom: 10px;">
					<span style="margin-bottom:10px;">Pour déposer une annonce, il faut vous identifier.</span>
				</div>
				
				<form method="POST" style="color: #EB8F00;" name="connexion_user2" action="./index.php?page=connexion">
					<div style="float:left">
						<div style="margin-left:10px;width:270px">
							<div class="text bold inputlogin">Login/email :</div>
							<input type="text" class="zone-saisie" style="width:140px;font-size: 1em;float:right" id="con_login2" name="con_login" />
						</div>
					</div>

					<div style="float:left">
						<div style="margin-left:10px;width:270px">
							<div class="text bold inputlogin" >Mot de passe :</div>
							<input type="password" class="zone-saisie" style="width:140px;font-size: 1em;float:right" id="con_password2" name="con_password" />
						</div>
					</div>
					
					<input type="submit" id="connexion_button2" value="Connexion"/>
				</form>
				
			</div>
		<?php }?>
		<div class="clear"></div>
	</div>
	

	<div id="tabs-3" style="">
		<form method="POST" name="creation_compte" action="./index.php?page=inscription">
			<div style="float:left">
				<div>
					<div style="float:left;margin: 3px;width:60px">Prenom:</div>
					<input type="text" class="zone-saisie" style="width:140px;" maxlength="40" id="prenom" name="prenom"  value="" />
				</div>
				
				<div>
					<div style="float:left;margin: 3px;width:60px">Nom:</div>
					<input type="text" class="zone-saisie" style="width:140px;" maxlength="40" id="nom" name="nom"  value="" />
				</div>
				
				<div>
					<div style="float:left;margin: 3px;width:60px">Tel :</div>
					<input type="text" class="zone-saisie" style="width:140px;" id="tel" name="tel" value="" />
				</div>
				
				<div>
					<div style="float:left;margin: 3px;width:60px">Adresse:</div>
					<input type="text" class="zone-saisie" style="width:140px;" maxlength="50" id="adresse" name="adresse"  value="" />
				</div>
			</div>
			
			<div style="float:left;margin-left:15px">
				<div>
					<div style="float:left;margin: 3px;width:80px">Ville:</div>
					<input type="text" class="zone-saisie" style="width:140px;" maxlength="50" id="ville" name="ville"  value="" />
				</div>
				
				<div>
					<div style="float:left;margin: 3px;width:80px">Region:</div>
					<SELECT style="float:left;width:140px;" id="region" name="region" onchange="getDepartements(this.value,'','bloc_depot_departements');">
						<OPTION  VALUE="--">--</OPTION>
						<OPTION  VALUE="1">Alsace</OPTION>
						<OPTION  VALUE="2">Aquitaine</OPTION>
						<OPTION  VALUE="3">Auvergne</OPTION>
						<OPTION  VALUE="4">Basse-Normandie</OPTION>
						<OPTION  VALUE="5">Bourgogne</OPTION>
						<OPTION  VALUE="6">Bretagne</OPTION>
						<OPTION  VALUE="7">Centre</OPTION>
						<OPTION  VALUE="8">Champagne-Ardenne</OPTION>
						<OPTION  VALUE="9">Corse</OPTION>
						<OPTION  VALUE="10">Franche-Comté</OPTION>
						<OPTION  VALUE="11">Haute-Normandie</OPTION>
						<OPTION  VALUE="12">Ile-de-France</OPTION>
						<OPTION  VALUE="13">Languedoc-Roussillon</OPTION>
						<OPTION  VALUE="14">Limousin</OPTION>
						<OPTION  VALUE="15">Lorraine</OPTION>
						<OPTION  VALUE="16">Midi-Pyrénés</OPTION>
						<OPTION  VALUE="17">Nord-Pas-De-Calais</OPTION>
						<OPTION  VALUE="18">Pays de la Loire</OPTION>
						<OPTION  VALUE="19">Picardie</OPTION>
						<OPTION  VALUE="20">Poitou-Charentes</OPTION>
						<OPTION  VALUE="21">Alpes-Côte d'Azur</OPTION>
						<OPTION  VALUE="22">Rhône-Alpes</OPTION>
						<OPTION  VALUE="23">Departements d'outre Mer</OPTION>		
						
					</SELECT>
				</div>	
					
				<div>
					<div style="float:left;margin: 3px;width:80px">Departement:</div>
					<span id="bloc_depot_departements">
                        <input type="text" class="zone-saisie" style="width:140px;" maxlength="50" id="departement" name="departement"  value="" />
                    </span>
				</div>
				
				<div>
					<div style="float:left;margin: 3px;width:80px">E-mail:</div>
					<input type="text" class="zone-saisie" style="width:140px;" id="mail" name="mail"  value="" />
				</div>
				
				<div>
					<div style="float:left;margin: 3px;width:80px">Mot de passe:</div>
					<input type="password" class="zone-saisie" style="width:140px;" id="password" name="password" />
				</div>
			</div>
			
			<div id="indication_erreurs" style="float:left;margin-left:20px;color:#CA0036;width:255px;display:none">
				<div><b>Veuillez verifier que :</b></div>
				<div>- les champs soient remplis</div>
				<div>- le numero de telephone possède 10 chiffres</div>
				<div>- l'adresse mail soit valide</div>
				<div>- le mot de passe possède au moins 6 caractères</div>
			</div>
			
			
			<div class="blue-button2" id="inscription" style="margin-right:0px;margin-top:0px;">S'inscrire</div>
		</form>
        <div class="clear"></div>
	</div>
	

</div>
<div class="clear"></div>