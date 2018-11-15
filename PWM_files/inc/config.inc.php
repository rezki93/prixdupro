<?php

///////////////////////////////////// GPL //////////////////////////////////////
/*

  This file is part of PHP Web Manager.
  Copyright (c) 2010-2011 SimpleGeek. All rights reserved.
  http://www.simplegeek.fr/

  PHP Web Manager is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  PHP Web Manager is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
  
*/
/////////////////////////////////////////////////////////////////////////////////

/*
  PHP Web Manager: Reloaded
  Fichier: config.inc.php
  Dernière modification: 10/06/2010
  Copyright (C) SimpleGeek 2010-2011
*/

#######################
##   CONFIGURATION   ##
##  MODIFICATION OK  ##
#######################

// Votre mot de passe. Si il n'y en a pas ou qu'il est NULL, le script ne fonctionnera pas
// N'oubliez pas d'encadrer votre mot de passe avec des guillemets si il contient des caracères non-héxadécimaux
  $password = '757875';
  
// Choisissez votre langue (FR ou EN)
  $langue = "FR";
  
// Si TRUE, le script ne calcuera pas la taille des dossier.
  $fast_display = TRUE;
  
// Première ligne: Indiquez TRUE (recommandé) pour modifier les fichiers de script en ligne avec un éditeur de texte à coloration syntaxique.
// Deuxième ligne: Si la taille du fichier est supérieur au nombre indiqué, la coloration syntaxique ne sera pas effective, plus pour de rapidité.
  $syntax_highlighting = TRUE;
  $size_syntax_highlighting = 50000; // Défault: 50000 (Octets)
  
// Indiquez TRUE pour écraser les anciens fichiers lors de l'apparition de nouveaux ayant le même nom.
// Ce paramètre s'applique aux nouveaux fichiers uploadés par le PWM.
  $overwrite_files = TRUE;
  
// Si TRUE, il est possible de faire certaines actions en pressant certaines touches.
  $binding = TRUE;
  
// Si TRUE, votre site sera répertorié sur le site www.simplegeek.fr comme utilisateur du PWM
// Si vous n'avez pas confiance, remplacez TRUE par FALSE, ou mettez // devant $ping
// Aucune donnée confidentielle ne sera prélevée, si ce n'est que l'adresse de votre site et la version du PWM.
  $ping = TRUE;
  
//Tri des fichiers sous la forme de [chiffre][a-d], le chiffre étant le numéro de la colone, "a"scending ou "d"escending
  $default_sort = '0a';
  
// Adresse de vérification de mise à jour, vous pouvez rajouter // devant la ligne si vous n'avez pas confiance
  $update = 'http://www.simplegeek.fr/version.db';
  
// Les fichiers que vous ne voulez pas lister
  $arr_notdisp = array('.','..','PWM_files');
  
// Toutes les types de fichiers supportés par le PWM (liste très exhaustive)
  $classType = array('php'   => 1
            ,'html'   => 2
            ,'htm'   => 3
            ,'js'   => 4
            ,'css'   => 5
            ,'xml'   => 6
            ,'txt'   => 7
            ,'bat'   => 8
            ,'cmd'   => 9
            ,'cfg'  => 10
            ,'nfo'   => 11
            ,'ini'   => 12
            ,'log'   => 13
            ,'reg'   => 14            
            ,'db'   => 15          
          // Fichiers non lisible par un simple éditeur
            ,'png'   => 16
            ,'gif'   => 17
            ,'jpg'   => 18
            ,'jpeg'   => 19
            ,'bmp'   => 20
            ,'zip'  => 21
            ,'7z'   => 22
            ,'gz'   => 23
            ,'tar'   => 24
            ,'rar'   => 25
            ,'exe'   => 26
            ,'pdf'   => 27
            ,'wma'   => 28
            ,'mp3'   => 29
            ,'wav'   => 30
            ,'mov'   => 31
            ,'avi'   => 32
            ,'mpeg'  => 33
          // Document MS office
            ,'doc'   => 34
            ,'docx'   => 35
            ,'xls'  => 36
            ,'xlsx'   => 37
            ,'pps'   => 38
            ,'ppsx'  => 39
            ,'ppt'   => 40
            ,'pptx'   => 41);
            
  $classType2 = $classType;
              
  
#######################
##     VARIABLES     ##
##  NE PAS MODIFIER  ##
#######################

// Version du PHP Web Manager: Reloaded
  $version = "2.5";
  
// Nom de l'auteur, merci de ne pas supprimer/modifier
  $author = "SimpleGeek";
  
// Importation du dossier du script (images, css, JS...)
// Si vous renommez le dossier, il risque d'y avoir des erreurs
  $PWM_FILES = "./PWM_files/";
  
// Création de tableaux pour le listing + compte
  $ftp = $multisort = $arr_dirs = $arr_files = array();
  $X = $dirs_nb = $files_nb = 0;

// Chemin de l'HOST
  $HOST = $_SERVER['HTTP_HOST'];
  
// Raccourcit de l'action
  $TYPE = (isset($_GET['type'])) ? $_GET['type'] : '';
  
// HTTP sécurisé ou pas
  $PROTOCOL = getenv("HTTPS") == "on" ? 'https://' : 'http://';
  
// Le dernier root
  $lastRoot = (isset($_COOKIE['pwm_lrt'])) ? $_COOKIE['pwm_lrt'] : '';
  
// On vérifie si c'est Windows
  $win = strtolower(substr(PHP_OS,0,3)) == 'win';
  
  
#######################
##   MODIFICATIONS   ##
## DU FICHIER CONFIG ##
#######################

  @ini_set('allow_url_fopen',1);
  @ini_set('magic_quotes_gpc',0);
  @ini_set('allow_url_include',1);
  @ini_set('max_execution_time',0);

  @ignore_user_abort(1);
  @error_reporting(5);
  
?>