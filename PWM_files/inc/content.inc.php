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
  Fichier: content.inc.php
  Dernière modification: 10/06/2010
  Copyright (C) SimpleGeek 2010-2011
*/

#######################
##     SECURITE      ##
#######################

  if(!$logged)
	exit;
	
// On récupère le chemin du root
  if((!isset($_GET['root'])) or (!@is_dir($_GET['root'])))
  {
    $root = dirname($_SERVER['SCRIPT_FILENAME']);
  }

  else
  {
    $root = $_GET['root'];
  }

// Simple variable
  $ROOT = getroot();

// On définit le $_GET par défaut
  if(!isset($_GET['type']) || empty($_GET['type']))
  { 
    $_GET['type'] = 'list';
  }
  
// Le tri par défaut
  $sort = (isset($_COOKIE['pwm_sort'])) ? $_COOKIE['pwm_sort'] : $default_sort ;
  
// Erreur d'accès
$e401 = <<<EOS
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
   <head>
      <title>Error 401 - Unauthorized</title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta http-equiv="cache-control" content="no-cache" />
   </head>
   <body style="font-family:arial;">
   		<h1 style="color:#0a328c;font-size:1.0em;">Error 401 - Unauthorized</h1>

		<p style="font-size:0.8em;">L'acc&#232;s au fichier requiert une autorisation.</p>
   </body>
  </html>
EOS;
  
// Accès d'un fichier sous root
	if(isset($_GET['to']))
	{
		$link = base64_decode($_GET['to']);
		if(is_file($link) && is_readable($link))
		{
			header('Content-type: '.getmime($link));
			header('Content-Disposition: filename="'.basename($link).'";');
			header('Content-length: '.@filesize($link));
			header('Pragma: no-cache');
			header('Cache-Control: no-store, no-cache, must-revalidate');
			exit(@file_get_contents($link));
		}
		else
		{
			exit($e401);
		}
	}
	
// PCLZip POWA !
	if($TYPE == 'zip4select' || $TYPE == 'extract' || $TYPE == 'listzip')
	{
		include_once ($PWM_FILES."inc/pclzip.lib.php");
	}
  
// On définit les différentes actions possibles
  switch ($TYPE) 
  {
  
  //////////////////
  // - NEW FILE
  
    case 'newfile' : 
    {
      $src = format(basename($_GET['name']));
      if(@file_exists($root.'/'.$src))
      {
        $x = 2;
        if(ereg('\.',$src))
        {
          $new_name = substr($src,0,strrpos($src,'.'));
        }
        
        else
        {
          $new_name = $src;
        }

        while(@file_exists($root.'/'.$new_name.' (' .$x. ')'.strrchr($src,'.')))
        {
          $x++;
        }

        $new_name .= ' (' .$x. ')' .strrchr($src,'.');
        $src = $root.'/'.$new_name;
        
      }

      else
      {
        $src = $root.'/'.$src;
      }

      if($_GET['wt'] == 0)
        @mkdir($src,0777) or setcookie('pwm_error','Impossible de créer le dossier');

      elseif( $_GET['wt'] == 1 )
        if($foo = @fopen($src,'x')) { chmod($src, 0744); @fclose($foo); }
        else setcookie('pwm_error','Impossible de créer le fichier');
        redirect('?type=list&root='.$root);
        break;
    }
    
      
  //////////////////
  // - RENAME
  
    case 'rename' :
    {
      $_GET['newname'] = format(basename($_GET['newname']));
      @rename($_GET['fp'],dirname($_GET['fp']).'/'.$_GET['newname']) or setcookie('pwm_error','Impossible de renommer ce fichier');
      if(isset($lastRoot) && !EMPTY($lastRoot))
        redirect('?type='.$lastRoot);
      else
        redirect('?type=list&root='.dirname($_GET['fp']));
      break;
    }
    
      
  //////////////////
  // - FTP
  
    case 'ftp' :
    {
	// Création du WebFTP - Pas encore opérationnel
      @include_once ($PWM_FILES."inc/ftp.inc.php");
      break;
    }
    
      
  //////////////////
  // - UNLINK
  
    case 'unlink' : 
    {
      $bool = @is_dir($_GET['fp']) ? @fs_rmdir($_GET['fp']) : @unlink($_GET['fp']);
      if(!$bool)
      {
        @chmod($_GET['fp'], 0777); // On chmod si le dossier est pas accessible
        $bool = @is_dir($_GET['fp']) ? @fs_rmdir($_GET['fp']) : @unlink($_GET['fp']);
      }
      if(isset($lastRoot) && !EMPTY($lastRoot))
        redirect('?type='.$lastRoot);
      else
        redirect('?type=list&root='.dirname($_GET['fp']));
      break;
    }
    
    
  //////////////////
  // - DOWNLOAD

    case 'download' :
    {
      $src = $_GET['src'];

      if(!@is_file($src) || !@is_readable($src))
        exit("<h2>Impossible remote loading</h2>\n" .$_SERVER['SERVER_SIGNATURE']);

      @ob_end_clean();

      header('Pragma: public');
      header('Last-Modified: ' .gmdate('D, d M Y H:i:s'). ' GMT');
      header('Cache-Control: must-revalidate, pre-check=0, post-check=0, max-age=0');
      header('Content-Transfer-Encoding: none');
      header('Content-Type: application/octetstream; name="'.$src.'"');
      header('Content-Disposition: attachment; filename="'.basename($src).'"');
      header('Content-length: '.@filesize($src));

      if($hash = @file_get_contents($src))
      {
        exit($hash);
      }

      else
      {
        exit("<h2>Impossible remote loading</h2>\n" .$_SERVER['SERVER_SIGNATURE']);
      }

      break;
    }
    
  //////////////////
  // - PHPINFO  
  
    case 'phpinfo' : 
    {
      include_once ($PWM_FILES."inc/phpinfo.win.php");
      break;
    }
      
  //////////////////
  // - NEWCONFIG  
  
    case 'newconfig' :
    {
      if(!empty($_POST))
      {
        $pwm = file_get_contents($PWM_FILES."inc/config.inc.php");
        $_POST['newpass'] = addslashes($_POST['newpass']);

        $patern = $replace = Array();
        if(isset($_POST['newpass']) && !empty($_POST['newpass'])) //remplacement du mdp
        {
          $patern[] = '/\$password\s*?=.*?\s*?;/';
          $replace[] = ($_POST['newpass'] == 'null') ? '$password = "null";' : '$password = \''.$_POST['newpass'].'\';';
          setcookie('pwm', md5(stripslashes($_POST['newpass'])), $timestamp_expire, '/');
        }

        // Remplacement de l'affichage rapide
          $patern[] = '/\$fast_display\s*?=.*?\s*?;/';
          $replace[] = isset($_POST['fast']) ? '$fast_display = TRUE;' : '$fast_display = FALSE;';

        // Remplacement de GeSHi
          $patern[] = '/\$syntax_highlighting\s*?=.*?\s*?;/';
          $replace[] = isset($_POST['sh']) ? '$syntax_highlighting = TRUE;' : '$syntax_highlighting = FALSE;' ;

        // Remplacement de l'écrasement
          $patern[] = '/\$overwrite_files\s*?=.*?\s*?;/';
          $replace[] = isset($_POST['erase']) ? '$overwrite_files = TRUE;' : '$overwrite_files = FALSE;' ;

        // Remplacement de l'écrasement
          $patern[] = '/\$ping\s*?=.*?\s*?;/';
          $replace[] = isset($_POST['ping']) ? '$ping = TRUE;' : '$ping = FALSE;' ;

        // Remplacement de l'écrasement
          $patern[] = '/\$binding\s*?=.*?\s*?;/';
          $replace[] = isset($_POST['bind']) ? '$binding = TRUE;' : '$binding = FALSE;' ;

        // Remplacement du tri par défaut
          $new = $_POST['sort'].$_POST['sorts'];

          $patern[] = '/\$default_sort\s*?=.*?\s*?;/';
          $replace[] = '$default_sort = \''.$new.'\';' ;

        setcookie('pwm_sort', $new, $timestamp_expire, '/');

        $pwm = preg_replace($patern, $replace, $pwm, 1); //remplacement des chaines

        // Ecriture
        
        $foo = @fopen($PWM_FILES."inc/config.inc.php",'w+');
        @fwrite($foo,$pwm);
        @fclose($foo);
        redirect('?type=newconfig&s');
        exit;
      }
        
      include_once ($PWM_FILES."inc/newconfig.win.php");
    }
    break;
    
  //////////////////
  // - UPLOAD  
      
    case 'upload' : 
    {
      if(!empty($_FILES) || !empty($_POST))
      {
        if(!empty($_FILES))
        {
          $error = false;
          foreach($_FILES['userfile']['tmp_name'] as $key => $value) 
          {
            //On vérifie que les fichiers sont intacts.
            if ($_FILES['userfile']['tmp_name'][$key] !== 4 && is_uploaded_file($value))
            {
              $file_uploaded = stripslashes($root.'/'.$_FILES['userfile']['name'][$key]);
              //On renomme les fichiers montants si ils existent déjà.
              if(!$overwrite_files)
              {
                if(file_exists($file_uploaded))
                {
                  // On lance la fonction qui établi quel suffixe appliquer.
                  $x = 2;
                  $new_name = substr($file_uploaded,0,strrpos($file_uploaded,'.'));

                  //Par exemple, si le "fichier(1).extension" existe déjà, on passe le nouveau nom à "fichier(2).extension"
                  while(file_exists($new_name . ' (' .$x. ')' .strrchr($file_uploaded,'.'))) { $x ++; }
                  $new_name .= ' (' .$x. ')' .strrchr($file_uploaded,'.');
                  if(!move_uploaded_file($value, $new_name))
                    $error = true;
                }
                
                else
                {
                  if(!move_uploaded_file($value, $file_uploaded))
                    $error = true;
                }
              }

              else //Ecrasement des fichiers existants.
              {
                if(!move_uploaded_file($value, $file_uploaded))
                  $error = true;
              }
            }
          }
         //Fin du foreach
        }

      if(!empty($_POST))
        {
        if(preg_match('`^(http:\/\/)(\w*\.\w*)*`', $_POST['url']))
          $foo = @file_get_contents($_POST['url']) or exit('Problème de récuperation HTTP à distance');

        else $foo = null;

        if(!empty($foo))
          {
          
          if($_POST['nameOf'] !== 'Nom du fichier à télécharger ?')
              {
              $nameOf = empty($_POST['nameOf']) ? (strstr('.', basename($_POST['url'])) !== false) ? basename($_POST['url']) : basename($_POST['url']) . '.html' : $_POST['nameOf'] ;
              $nameOf = urldecode(format($nameOf));
            
              if( $bar = fopen($root.'/'.$nameOf ,'w+' ) )
                {
                fwrite($bar,$foo);
                fclose($bar);
                }
              }
          }
        }
        if(!$error)redirect('?type=upload&root='.$root.'&ok');
        else redirect('?type=upload&root='.$root.'&error');

      }
    include_once ($PWM_FILES."inc/upload.win.php");
    break;
  }
      
  //////////////////
  // - EDIT    
      
    case 'edit' : 
    {
      if(!empty($_POST))
      {
	  
	  	#######################
		##    ANTI-SLASHES   ##
		#######################

		if( function_exists( 'get_magic_quotes_gpc' ) )
		{ 
		  if(@get_magic_quotes_gpc())
		  { 
			$_GET = array_map ('stripslashes' , $_GET);
			$_POST = array_map ('stripslashes' , $_POST);
			$_COOKIE =  array_map ('stripslashes' , $_COOKIE);
		  }
		}
		
        if(@is_writable($_GET['fp']))
        {
			$code = $_POST['code'];
			//anti bug JS
			$code = preg_replace('/%%amp/','&',$code);
			$code = preg_replace('/%%plus/','+',$code);

			//Anti bug Ajax
			if (function_exists(mb_detect_encoding))
			{
				if(mb_detect_encoding(utf8_decode(@file_get_contents($_GET['fp']))) == "UTF-8") // C'est de l'UTF8
					$code = $code; // Ouais je sais, ça sert à rien, mais bon...
				else
					$code = utf8_decode($code);
			}
			else
				$code = utf8_decode($code);
          
          //Ecriture
          $foo = fopen($_GET['fp'],'w+');
          fwrite($foo,$code);
          fclose($foo);
          echo(1);
        }
        else
        {
			echo(0);        
        }
        exit;
      }

      $http_path = (preg_match("`^$ROOT/`",$_GET['fp']))  ? $PROTOCOL . getdir($_GET['fp']) : '?to='.base64_encode($_GET['fp']);
      include_once ($PWM_FILES."inc/edit.win.php");
      break;
    }
    
  //////////////////
  // - LE TRI
  
    case 'sort' :
    {
      $new = $_GET['sort'];
      $way = (substr($sort,1) == 'a' && $new == substr($sort,0,1)) ? 'd' : 'a';
      setcookie('pwm_sort', $new.$way, $timestamp_expire,'/');
      redirect('?type=list&root='.$_GET['root']);
      break;
    }
    
  //////////////////
  // - RECHERCHE
  
    case 'search' :
    {
      include_once ($PWM_FILES."inc/search.win.php");
      break;
    }
    
  //////////////////
  // - COPIE
    
    case 'copy' :
    {
      $ftp = Array();
      if($h = @opendir($root))
      {
        while(($file = readdir($h)) !== false)
        {
          $fp = $root.'/'.$file;
          if(!in_array($file,$arr_notdisp) && @is_dir($fp))
            $ftp[] = $file;
        }

      }
      
      else
      {
        setcookie('pwm_error','impossible d\'ouvrir le dossier "'.addslashes($root).'"');
        redirect('?type=copy&root='.$root);
      }
      
      include_once ($PWM_FILES."inc/copy.win.php");
      break;
    }
      
  //////////////////
  // - DEPLACER
  
    case 'move' :
    {
      $ftp = Array();
      if($h = @opendir($root))
      {
        while(($file = readdir($h)) !== false)
        {
          $fp = $root.'/'.$file;
          if(!in_array($file,$arr_notdisp) && @is_dir($fp))
            $ftp[] = $file;
        }

      }
      
      else
      {
        setcookie('pwm_error','impossible d\'ouvrir le dossier "'.addslashes($root).'"');
        redirect('?type=move&root='.$lastRoot);
      }
      
      include_once ($PWM_FILES."inc/move.win.php");
      break;
    }
    
  //////////////////
  // - MUSIQUE
    
    case 'player' : 
    {
      include_once ($PWM_FILES."inc/player.win.php");  
      break;
    }
    
  //////////////////
  // - SHELL
    
    case 'shell' : // Faut pas touché ça !
    {
      redirect($PWM_FILES."inc/shellz.inc.php");  
      break;
    }
	
  //////////////////
  // - PING

	case 'whois' : // Je vous rappelle que si vous n'avez pas confiance, vous pouvez mettre // devant le file_get_contents, ou désactiver la fonction PING
	{
		define('version_', urlencode($version) );
		@file_get_contents('http://www.simplegeek.fr/whois.php?url='.$HOST.'&filename='.$_SERVER['SCRIPT_NAME'].'&version='.version_);
		exit;
		break;
	}
      
#+++++++++++++++++++++#
#  ACTIONS SELECTION  #
#+++++++++++++++++++++#

  //////////////////
  // - Delete

    case 'delete4select' : 
    {
      $err = false;
      if(!empty($_GET['actbox']))
      foreach($_GET['actbox'] as $num => $src)
      {
        $bool = @is_dir($src) ? @fs_rmdir($src) : @unlink($src);
        if(!$bool)
        {
          @chmod($src, 0777);
          $bool = @is_dir($src) ? @fs_rmdir($src) : @unlink($src);
        }
        if(!$bool) $err = true;
      }

      if($err) setcookie('pwm_error','Un ou plusieurs fichiers n\'ont pas pu être supprimés');
      redirect('?type=list&root='.$root);
      break;
    }
      
  //////////////////
  // - Copy
  
    case 'copy4select' : 
    {
      $err = false;
      foreach($_GET['actbox'] as $num => $src)
      {
        if(@is_dir($src)) @fs_copy($src, $root.'/'.basename($src)) or $err = true;
        if(@is_file($src)) @copy($src, $root.'/'.basename($src)) or $err = true;
      }
      
      if($err) setcookie('pwm_error', 'Un ou plusieurs fichiers n\'ont pas pu être copiés');
      redirect('?type=list&root='.$root);
      break;
    }
      
  //////////////////
  // - Move
  
    case 'move4select' : 
    {
      $err = false;
      foreach($_GET['actbox'] as $num => $src)
      {
        @rename($src, $root.'/'.basename($src) ) or $err = true;
        if($src == $_SERVER['SCRIPT_FILENAME'])
          $path = getdir($root). '/';
      }

      if($err) setcookie('pwm_error', 'Un ou plusieurs fichiers n\'ont pas pu être déplacés');
      redirect($path.'?type=list&root='.$root);
      break;
    }
    
  //////////////////
  // - Chmod

    case 'chmod4select' :
    {
      $dec = base_convert($_GET['other'], 8, 10);
      $chmod = (int) $dec;
      $err = false;
      foreach($_GET['actbox'] as $num => $src)
      {
        @chmod($src,$chmod) or $err = true;
      }
      if($err) setcookie('pwm_error','Un ou plusieurs fichiers n\'ont pas pu être modifiés');
      redirect('?type=list&root='.$root);
      break;
    }
	
  //////////////////
  // - Compression

	case 'zip4select' :
	{
		$newroot = ($win) ? preg_replace('/[a-zA-Z]:\/(.*?)/','$1',$root) : $root;
		$name = $root.'/'.$_GET['other'];
		$arch = new PclZip($name);
		if(!file_exists($root.'/'.$_GET['other']))
		{
			$arch->create($_GET['actbox'],
							PCLZIP_OPT_REMOVE_PATH, $newroot,
							PCLZIP_OPT_ADD_PATH, './'
							);
		}
		else
		{
			$arch->add($_GET['actbox'],
							PCLZIP_OPT_REMOVE_PATH, $newroot,
							PCLZIP_OPT_ADD_PATH, './'
						);

		}
		redirect('?type=list&root='.$root);
		break;
	}

  //////////////////
  // - Listing

	case 'listzip' :
	{
		$tree = Array(); // on crée l'array
		if(isset($_GET['extract'])) // pour extraire qu'un fichier
		{
			$archive = new PclZip($_GET['zip']);
			if ($archive->extract(PCLZIP_OPT_BY_INDEX, $_GET['did']) == 0)
			{
				die("Error : ".$archive->errorInfo(true));
			}
			header('Location: ?type=ziplist&zip='.$_GET['zip']); // zz
		}

		if(isset($_GET['delete'])) // pour delete à l'intérieur du zip
		{
			$archive = new PclZip($_GET['zip']);
			$v_list = $archive -> delete(PCLZIP_OPT_BY_INDEX, $_GET['did']); // pour delete on recup le did qui est égale à l'index dans l'array du zip $tree[num][index]
			if($v_list==0)
			{
				die("Error:". $archive -> errorInfo(true));
			}
			header('Location: ?type=ziplist&zip='.$_GET['zip']); // zz
		}

		if(isset($_GET['add']))
		{
			$archive = new PclZip($_GET['zip']);
			$v_list = $archive -> add($_GET['newfp']); // écris ds le zip
			if ($v_list == 0)
			{
				die("Error : ". $archive -> errorInfo(true));
			}
			header('Location: ?type=ziplist&zip='.$_GET['zip']); // zz
		}

		$zip = new PclZip($_GET['zip']); // on ouvre le zip
		if(($list = $zip-> listContent() ) == 0 )
		{
			die("Error:". $zip->errorInfo(true));
		}			
		echo '<pre>';
		print_r($list);
		exit;

		break;
	}

  //////////////////
  // - Extract

	case 'extract' : 
	{
		$arch = new PclZip($_GET['fp']);
		$arch->extract(PCLZIP_OPT_PATH, dirname($_GET['fp']));
		redirect('?type=list&root='.dirname($_GET['fp']));
		break;
	}
    
  //////////////////
  // - LOGOUT
  
    case 'logout' :
    {
      if(isset($_POST['unset']))
      {
        setcookie('pwm');
        setcookie('pwm_lrt');
        setcookie('pwm_error');
        setcookie('pwm_sort');
      }
      redirect("/");
      break;
    }

    default:
    {
    setcookie('pwm_lrt',$TYPE.'&root='.$root,$timestamp_expire,'/');
  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=strtolower($langue)?>" lang="<?=strtolower($langue)?>"> 
  <head> 
  
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
    <meta name="desciption" content="PHP Web Manager: Reloaded - WebFTP" />
    <meta name="keywords" content="client ftp, ftp, php web manager, reloaded, simplegeek, manager, php, web, html, admin, password, filezilla" />
    <meta name="author" content="SimpleGeek" />
    
    <title>PHP Web Manager v<?=$version?></title>
    
    <link rel="shortcut icon" type="image/x-icon" href="<?=$PWM_FILES?>images/favicon.ico" /> 
    <link href="<?=$PWM_FILES?>css/global.css" rel="stylesheet" type="text/css" media="screen" />
    <script type="text/javascript">
    // On déclare root en JS
      var root = "<?=addslashes($root)?>";
      

    </script>
    <script type="text/javascript" src="<?=$PWM_FILES?>global_<?=strtolower($langue)?>.js"></script>
    
  </head>

  <body onload="mReset();" onkeydown="manage(event);" onunload="ntc = 0">
    <center>
      <form action="?type=logout" method="post" name="logout">
        <table class="head" width="99%" cellpadding="8">
          <tr>
            <td width="120" align="center"><a href="#exit" class="logout" onclick="document.forms['logout'].submit()"><?=$language[$langue]['LISTING_DISCO']?></a>
            <td width="5" align="center"><input type="checkbox" name="unset" value="1" title="<?=$language[$langue]['LISTING_COOKIES']?>" /></td>
            <td width="*" align="center"><a href="#newdir" onclick="newfile(0)" class="inp"><?=$language[$langue]['LISTING_NEW_DIR']?></a></td>
            <td width="*" align="center"><a href="#newfile" onclick="newfile(1)" class="inp"><?=$language[$langue]['LISTING_NEW_FILE']?></a></td>
            <td width="*" align="center"><a href="#upload" onclick="newWin('?type=upload&root='+root,420,750,',scrollbars=no,resizable=no')" class="inp"><?=$language[$langue]['LISTING_UPLOAD']?></a></td>
            <td width="*" align="center"><a href="#phpinfo" onclick="newWin('?type=phpinfo',650,1000,',scrollbars=yes,resizable=yes')" class="inp"><?=$language[$langue]['LISTING_PHPINFO']?></a></td>
            <td width="*" align="center"><a href="#config" onclick="newWin('?type=newconfig',450,750,',scrollbars=yes,resizable=no')" class="inp"><?=$language[$langue]['LISTING_CONFIG']?></a></td>
            <td width="*" align="center"><a href="?type=search&root=<?=$root?>&txtsearch=on" class="inp"><?=$language[$langue]['LISTING_SEARCH']?></a></td>
          </tr>
        </table>
      </form>

      <form action="?" method="get" name="act">
        <input type="hidden" name="type" value="list" id="newType"/>
        <input type="hidden" name="root" value="<?=$root?>" id="newRoot"/>
        <input type="hidden" name="other" value="" id="other"/>
        
        <div class="listing" id="listing"><br/>
          <table class="list" width="99%" cellpadding="3"  cellspacing="3" id="list">
            <tr>
              <th nowrap width="33%"><span onclick="window.location = '?type=sort&sort=0&root='+root;"><?=$language[$langue]['LISTING_NAME']?><?php if($sort == '0a') {echo '&nbsp;<img src="'.$PWM_FILES.'images/sort_a.gif" alt="&#8593;"/>';} elseif($sort == '0d') {echo '&nbsp;<img src="'.$PWM_FILES.'images/sort_d.gif" alt="&#8595;"/>';} ?></span></th>
              <th nowrap width="14%"><span onclick="window.location = '?type=sort&sort=1&root='+root;"><?=$language[$langue]['LISTING_SIZE']?><?php if($sort == '1a') {echo '&nbsp;<img src="'.$PWM_FILES.'images/sort_a.gif" alt="&#8593;"/>';} elseif($sort == '1d') {echo '&nbsp;<img src="'.$PWM_FILES.'images/sort_d.gif" alt="&#8595;"/>';} ?></span></th>
              <th nowrap width="22%"><span onclick="window.location = '?type=sort&sort=2&root='+root;"><?=$language[$langue]['LISTING_MODIF']?><?php if($sort == '2a') {echo '&nbsp;<img src="'.$PWM_FILES.'images/sort_a.gif"alt="&#8593;"/>';} elseif($sort == '2d') {echo '&nbsp;<img src="'.$PWM_FILES.'images/sort_d.gif" alt="&#8595;"/>';} ?></span></th>
              <th nowrap width="17%"><span onclick="window.location = '?type=sort&sort=3&root='+root;">Permissions<?php if($sort == '3a') {echo '&nbsp;<img src="'.$PWM_FILES.'images/sort_a.gif"alt="&#8593;"/>';} elseif($sort == '3d') {echo '&nbsp;<img src="'.$PWM_FILES.'images/sort_d.gif" alt="&#8595;"/>';} ?></span></th>
              <th nowrap width="17%" align="right"><span onclick="window.location = '?type=sort&sort=4&root=<?=$root?>';"><?php if($sort == '4a') {echo '<img src="'.$PWM_FILES.'images/sort_a.gif"alt="&#8593;"/>&nbsp;';} elseif($sort == '4d') {echo '<img src="'.$PWM_FILES.'images/sort_d.gif" alt="&#8595;"/>&nbsp;';} ?>Actions</span>&nbsp;</th>
            </tr>
          
          <?php
          
          // Et on commence le listing
            if($handle = opendir($root))
            {
              while(($file = readdir($handle)) !== false)
              {
                if(!in_array($file,$arr_notdisp))
                {
                  $file_path = $root."/".$file; // On récupère le chemin du fichier
                  if (is_dir($file_path)) // Si c'est un dossier
                  {
                    $wt = 0; // which type
                    $size = ($fast_display) ? 'n/a' : @sizethisdir($file_path);
                  }

                  else // Sinon si c'est un fichier
                  {
                    $ext = strtolower(substr(strrchr($file,'.'),1));
                    if(array_key_exists($ext, $classType))
                      $wt = $classType[$ext]; //récup du wt
                      
                    else //attribution d'une nouvelle classe
                    { 
                      $plus = count($classType) + 1;
                      $classType[$ext] = $plus;
                      $wt = $plus;
                    }
                    
                    $size = @sizethis($file_path);
                  }
                  
                  $date = filemtime($file_path);
                  $perm = fileperms($file_path);
                  
                  if($wt == 0)
                  {
                    $arr_dirs[] = array('name' => $file
                              ,'type' => $wt
                              ,'size' => $size
                              ,'date' => $date
                              ,'perm' => $perm
                              );
                              
                    $multisort_d['type'][] = $wt;
                    $multisort_d['size'][] = $size;
                    $multisort_d['date'][] = $date;
                    $multisort_d['perm'][] = $perm;
                  }
                  
                  else
                  {
                    $arr_files[] = array('name' => $file
                              ,'type' => $wt
                              ,'size' => $size
                              ,'date' => $date
                              ,'perm' => $perm
                              );
                    $multisort_f['type'][] = $wt;
                    $multisort_f['size'][] = $size;
                    $multisort_f['date'][] = $date;
                    $multisort_f['perm'][] = $perm;
                  }
                } // Fin si
              } // Fin while
              
            // Tri intensif
              switch ($sort)
              {
                //Name
                case '0a' :
                  @array_multisort($arr_dirs,SORT_REGULAR);
                  @array_multisort($arr_files,SORT_REGULAR);
                break;

                case '0d' :
                  @array_multisort($arr_dirs,SORT_DESC);
                  @array_multisort($arr_files,SORT_DESC);
                break;

                //Size
                case '1a' :
                  @array_multisort($arr_dirs,SORT_NUMERIC,$multisort_d['size']);
                  @array_multisort($arr_files,SORT_NUMERIC,$multisort_f['size']);
                break;

                case '1d' :
                  @array_multisort($arr_dirs,SORT_NUMERIC,$multisort_d['size'],SORT_DESC);
                  @array_multisort($arr_files,SORT_NUMERIC,$multisort_f['size'],SORT_DESC);
                break;

                //Date
                case '2a' :
                  @array_multisort($arr_dirs,SORT_NUMERIC,$multisort_d['date'],SORT_DESC);
                  @array_multisort($arr_files,SORT_NUMERIC,$multisort_f['date'],SORT_DESC);
                break;


                case '2d' :
                  @array_multisort($arr_dirs,SORT_NUMERIC,$multisort_d['date']);
                  @array_multisort($arr_files,SORT_NUMERIC,$multisort_f['date']);
                break;

                //Perm
                case '3a' :
                  @array_multisort($arr_dirs,SORT_NUMERIC,$multisort_d['perm'],SORT_DESC);
                  @array_multisort($arr_files,SORT_NUMERIC,$multisort_f['perm'],SORT_DESC);
                break;


                case '3d' :
                  @array_multisort($arr_dirs,SORT_NUMERIC,$multisort_d['perm']);
                  @array_multisort($arr_files,SORT_NUMERIC,$multisort_f['perm']);
                break;

                //action (type)
                case '4a' :
                  @array_multisort($arr_dirs,SORT_REGULAR);
                  @array_multisort($arr_files,SORT_NUMERIC,$multisort_f['type']);
                break;


                case '4d' :
                  @array_multisort($arr_dirs,SORT_DESC);
                  @array_multisort($arr_files,SORT_NUMERIC,$multisort_f['type'],SORT_DESC);
                break;

                default :
                  @array_multisort($arr_dirs,SORT_REGULAR);
                  @array_multisort($arr_files,SORT_REGULAR);
                break;
              };
              
            } // Fin opendir
            
            else
            {
              setcookie('pwm_error','impossible d\'ouvrir le dossier "'.addslashes($root).'"!');
              redirect('?type=list&root='.$root);
            }
	    
	    
          // ON REUNIT LES DEUX ARRAYS
          // ACTION IMPORTANTE !
            $ftp = array_merge($arr_dirs,$arr_files);
            
          // Chemin du dossier précédent
            $PREV_DIR = rmslashes(dirname($root));
            echo ('<tr title="'.$language[$langue]['LISTING_PREV'].'"><td align="left"><a href="?type=list&root='.$PREV_DIR.'"><img src="'.$PWM_FILES.'images/prev.png" border="0" />&nbsp;..</a></td>');
            
          // Foreach Dirs
            foreach($ftp as $file)
            {      
              $file_path = $root.'/'.$file['name'];
              $filename  = $file['name'];
	     // $filename_substr  = $file['name'];
              $filename_ = addslashes($file['name']);
              $size = $file['size'];
              $date = $file['date'];
              $file_perm = $file['perm'];
              $chmod = view_perms($file['perm']);
              $date = date($language[$langue]['LISTING_DATE'],$date);
              $HTTP_PATH = (preg_match('`^'.quotemeta($ROOT).'/`',$file_path))  ? $PROTOCOL . $HOST . getdir($file_path) : '?to='.base64_encode($file_path);
              
              // Si le nom est trop long              
                if(strlen($filename) > 40)
                {
                  $filename = substr($filename,0,36) . ' ...';
                }
                
              // Si c'est un dossier (ancien foreach dir)
                if( $file['type'] == 0 )
                {
                  $dirs_nb++;    
                  $actions = '
                      <a href="javascript:rename(\''.$filename_.'\',0);" title="'.$language[$langue]['LISTING_RENAME'].' &quot;'.$filename.'&quot;">
                        <img src="'.$PWM_FILES.'images/actions/rename.png" border="0" alt="'.$language[$langue]['LISTING_RENAME'].' &quot;'.$filename.'&quot;"/>
                      </a>
                      
                      <a href="javascript:unlink(\''.$filename_.'\',0);" title="'.$language[$langue]['LISTING_DELETE'].' &quot;'.$filename.'&quot;">
                        <img src="'.$PWM_FILES.'images/actions/delete.png" border="0" alt="'.$language[$langue]['LISTING_DELETE'].' &quot;'.$filename.'&quot;"/>
                      </a>
                      <a href="'.$HTTP_PATH.'" target="_blank" title="'.$language[$langue]['LISTING_VIEW'].' &quot;'.$filename.'&quot;">
                        <img src="'.$PWM_FILES.'images/actions/view.png" border="0" alt="'.$language[$langue]['LISTING_VIEW'].' &quot;'.$filename.'&quot;"/>
                      </a>';
		     
		    
		    
			echo   ('<tr class="opacity" id="tr'.$X.'" onmouseover="gid(\'path\').innerHTML = \''.$filename.'/\'" onmouseout="gid(\'path\').innerHTML = \'\'">          
			  <td nowrap onclick="setCheck('.$X.')" id="td'.$X.'" align="left">
			  <input id="ch'.$X.'" type="checkbox" value="'.$file_path.'" name="actbox[]" class="hidden" />
			  <span class="bg"><img src="'.$PWM_FILES.'images/rep.png" alt="'.$filename.'" />&nbsp;<a title="'.$language[$langue]['LISTING_BROWSE'].' '.$filename.'" href="?type=list&root='.urlencode($root.'/'.$filename_).'">'.$filename.'</a></span>
			  </td>
		    
			  <td name="poids" align="left">
			    '.$size.'
			  </td>
		    
			  <td name="date" align="left">
			    '.$date.'
			  </td>
		    
			  <td name="perm" align="left">
			    '.$chmod.'
			  </td>
		    
			  <td name="actions" align="right">
			    '.$actions.'
			  </td>
			</tr>');
		    
                }
                
                

              // Ancien foreach file
                else
                {      
                  if ($file['type'] >= 1 && $file['type'] <= 15) // Edit
                    $links = '?type=edit&fp='.urlencode($root.'/'.$filename);
                    
                  elseif ($file['type'] == 28 || $file['type'] == 29) // MP3
                    $links = 'javascript:load(\''.$HTTP_PATH.'\',\''.$file_path.'\');';
                
                  else // Inconnu
                    $links = $HTTP_PATH ;
                  
                  $files_nb++;
				  
				//archives
					if($file['type'] == $classType['zip'])
						{
						$unzip = '<a href="javascript:extract(\''.$file_path.'\');"><img src="'.$PWM_FILES.'images/actions/unzip.png" border="0" alt="'.$language[$langue]['LISTING_UNZIP'].'" /></a> ';
						$links = 'javascript:list(\''.$file_path.'\')';
						}
					else
						{
						$unzip = null;
						}
                  
                // Force edit
                  if(!in_array($file['type'], $classType2))
                    $f_edit = '<a href="?type=edit&fp='.$file_path.'" title="'.$language[$langue]['LISTING_FORCING'].$filename.'"><img src="'.$PWM_FILES.'images/actions/force_edit.png" border="0" alt="'.$language[$langue]['LISTING_FORCING'].$filename.'"/>
</a> ';
                  else
                    $f_edit = null;
                    
                  $ext = strtolower(substr(strrchr($file['name'],'.'),1));                  
                  $ico = (in_array($file['type'], $classType2)) ? '<img src="'.$PWM_FILES.'images/ext/'.strtolower($ext).'.png" alt="'.$language[$langue]['LISTING_FILE'].' &quot;'.strtoupper($ext).'&quot;"/>&nbsp;' : ($ext == 'htaccess' || $ext == 'htpasswd') ? '<img src="'.$PWM_FILES.'images/ext/'.$ext.'.png" alt="'.$language[$langue]['LISTING_FILE'].' &quot;'.strtoupper($ext).'&quot;"/>&nbsp;' : '<img src="'.$PWM_FILES.'images/ext/no.png" alt="'.$language[$langue]['LISTING_FILE'].' &quot;'.strtoupper($ext).'&quot;"/>&nbsp;';
                  $actions = $unzip.$f_edit.'
                        <a href="?type=download&src='.$file_path.'" title="'.$language[$langue]['LISTING_DOWNLOAD'].' &quot;'.$filename.'&quot;">
                          <img src="'.$PWM_FILES.'images/actions/dl.png" border="0" alt="'.$language[$langue]['LISTING_DOWNLOAD'].' &quot;'.$filename.'&quot;"/>
                        </a>
                        <a href="javascript:rename(\''.$filename_.'\',1);" title="'.$language[$langue]['LISTING_RENAME'].' &quot;'.$filename.'&quot;">
                        <img src="'.$PWM_FILES.'images/actions/rename.png" border="0" alt="'.$language[$langue]['LISTING_RENAME'].' &quot;'.$filename.'&quot;"/>
                      </a>
                      
                      <a href="javascript:unlink(\''.$filename_.'\',1);" title="'.$language[$langue]['LISTING_DELETE'].' &quot;'.$filename.'&quot;">
                        <img src="'.$PWM_FILES.'images/actions/delete.png" border="0" alt="'.$language[$langue]['LISTING_DELETE'].' &quot;'.$filename.'&quot;"/>
                      </a>
                      <a href="'.$HTTP_PATH.'" target="_blank" title="'.$language[$langue]['LISTING_VIEW'].' &quot;'.$filename.'&quot;">
                        <img src="'.$PWM_FILES.'images/actions/view.png" border="0" alt="'.$language[$langue]['LISTING_VIEW'].' &quot;'.$filename.'&quot;"/>
                      </a>';
                  
                  echo   ('<tr class="opacity" id="tr'.$X.'" onmouseover="gid(\'path\').innerHTML = \''.$filename.'\'" onmouseout="gid(\'path\').innerHTML = \'\'">            
                        <td nowrap onclick="setCheck('.$X.');" id="td'.$X.'" align="left">
                        <input id="ch'.$X.'" type="checkbox" value="'.$file_path.'" name="actbox[]" class="hidden" />
                        
                        <span class="bg">'.$ico.'&nbsp;<a href="'.$links.'" title="'.$language[$langue]['LISTING_EDIT'].' '.$filename.'">'.$filename.'</a></span>
                        </td>
                  
                        <td name="poids" align="left">
                          '.$size.'
                        </td>
                  
                        <td name="date" align="left">
                          '.$date.'
                        </td>
                  
                        <td name="perm" align="left">
                          '.$chmod.'
                        </td>
                  
                        <td name="actions" align="right">
                          '.$actions.'
                        </td>
                      </tr>');
                }
              $X++;
            } // Fin foreach
          
          ?>
          
                            
          </table>
        </div>  
      </form>
        <table class="foot" width="99%" cellpadding="10">
          <tr>
            <td width="70%" align="left" style="text-shadow: 1px 1px 0px #FFF;"><?=$language[$langue]['LISTING_PATH']?> <?='/'.path2link($root)?><font color="red"><span id="path"></span></font></td>                  
            <td align="right">
            <input type="text" id="more" value="<?=$language[$langue]['LISTING_LOADING']?>" class="more" onfocus="this.blur();" onclick="this.blur();toggleOpt();" onchange="return 0" />
            <td width="01%" align="left">&nbsp;</td>
          </tr>
        </table>
        
        <div id="options" onmouseout="timer = setTimeout('hideOpt();clearTimeout(timer)',250)" onmouseover="if(timer)clearTimeout(timer)" onselectstart="return false;" onmousedown="if (typeof event.preventDefault != 'undefined') { event.preventDefault(); }">
          <ul>
            <li <?php if($binding) echo ('title="'.$language[$langue]['LISTING_SHORTCUT'].' : &nbsp;R&nbsp;"'); ?>><a href="?type=list&root=<?=$ROOT;?>"><img src="<?=$PWM_FILES.'images/actions/spacer.gif'?>" alt=""/>&nbsp;<?=$language[$langue]['LISTING_ROOT']?></a></li>
            <li <?php if($binding) echo ('title="'.$language[$langue]['LISTING_SHORTCUT'].' : &nbsp;A&nbsp;"'); ?>><a href="javascript:void(0);" onclick="setCheck('a');"><img src="<?=$PWM_FILES.'images/actions/spacer.gif'?>" alt=""/>&nbsp;<?=$language[$langue]['LISTING_SELECT']?></a></li>
            <li <?php if($binding) echo ('title="'.$language[$langue]['LISTING_SHORTCUT'].' : &nbsp;Z&nbsp;"'); ?>><a href="javascript:void(0);" onclick="setCheck('n');"><img src="<?=$PWM_FILES.'images/actions/spacer.gif'?>" alt=""/>&nbsp;<?=$language[$langue]['LISTING_UNSELECT']?></a></li>
            <li <?php if($binding) echo ('title="'.$language[$langue]['LISTING_SHORTCUT'].' : &nbsp;E&nbsp;"'); ?>><a href="javascript:void(0);" onclick="setCheck('r');"><img src="<?=$PWM_FILES.'images/actions/spacer.gif'?>" alt=""/>&nbsp;<?=$language[$langue]['LISTING_REVERSE']?></a></li>
            <hr align="center" size="0" noshade />
            <li <?php if($binding) echo ('title="'.$language[$langue]['LISTING_SHORTCUT'].' : &nbsp;Del&nbsp;"'); ?>><a href="javascript:delete4select();" onclick="hideOpt()"><img src="<?=$PWM_FILES.'images/actions/spacer.gif'?>" alt=""/>&nbsp;<?=$language[$langue]['LISTING_REMOVE']?></a></li>		
			<li><a href="javascript:zip4select();" onclick="hideOpt()"><img src="<?=$PWM_FILES.'images/actions/rar.png'?>" alt=""/>&nbsp;<?=$language[$langue]['LISTING_ARCHIVE']?></a></li>
            <li <?php if($binding) echo ('title="'.$language[$langue]['LISTING_SHORTCUT'].' : &nbsp;X&nbsp;"'); ?>><a href="javascript:newWin('?type=move&root='+root,340,550,',scrollbars=no,resizable=yes');" onclick="hideOpt()"><img src="<?=$PWM_FILES.'images/actions/spacer.gif'?>" alt=""/>&nbsp;<?=$language[$langue]['LISTING_MOVE']?></a></li>
            <li <?php if($binding) echo ('title="'.$language[$langue]['LISTING_SHORTCUT'].' : &nbsp;C&nbsp;"'); ?>><a href="javascript:newWin('?type=copy&root='+root,340,550,',scrollbars=no,resizable=yes');" onclick="hideOpt()"><img src="<?=$PWM_FILES.'images/actions/spacer.gif'?>" alt=""/>&nbsp;<?=$language[$langue]['LISTING_COPY']?></a></li>
            <li><a href="javascript:chmod();" onclick="hideOpt()"><img src="<?=$PWM_FILES.'images/actions/spacer.gif'?>" alt=""/>&nbsp;<?=$language[$langue]['LISTING_CHMOD']?></a></li>
          </ul>
        </div>

        <div id="octal">
          <center>
            <form action="?" method="post" name="chmod">
              <br/><b><?=$language[$langue]['CHMOD_TITLE']?></b><br/><br/>


              <fieldset style="width:85%;" name="owner">
                <legend><?=$language[$langue]['CHMOD_PERMS_OWN']?></legend>
                <table width="100%">
                  <tr>
                    <td><input type="checkbox" id="own1" name="pro4" value="4" onclick="octalchange()" checked /><label for="own1"> <?=$language[$langue]['CHMOD_READ']?></label></td>
                    <td><input type="checkbox" id="own2" name="pro2" value="2" onclick="octalchange()" checked /><label for="own2"> <?=$language[$langue]['CHMOD_WRITE']?></label></td>
                    <td><input type="checkbox" id="own3" name="pro1" value="1" onclick="octalchange()" checked /><label for="own3"> <?=$language[$langue]['CHMOD_EXECUTE']?></label></td>
                  </tr>
                </table>
              </fieldset>
                <br/>
              <fieldset style="width:85%;" name="group">
                <legend><?=$language[$langue]['CHMOD_PERMS_GPE']?></legend>
                <table width="100%">
                  <tr>
                    <td><input type="checkbox" id="grp1" name="grp4" value="4" onclick="octalchange()" checked /><label for="grp1"> <?=$language[$langue]['CHMOD_READ']?></label></td>
                    <td><input type="checkbox" id="grp2" name="grp2" value="2" onclick="octalchange()"/><label for="grp2"> <?=$language[$langue]['CHMOD_WRITE']?></label></td>
                    <td><input type="checkbox" id="grp3" name="grp1" value="1" onclick="octalchange()"/><label for="grp3"> <?=$language[$langue]['CHMOD_EXECUTE']?></label></td>
                  </tr>
                </table>
              </fieldset>
                <br/>
              <fieldset style="width:85%;" name="public">
                <legend><?=$language[$langue]['CHMOD_PERMS_PBC']?></legend>
                <table width="100%">
                  <tr>
                    <td><input type="checkbox" id="pub1" name="pub4" value="4" onclick="octalchange()" checked /><label for="pub1"> <?=$language[$langue]['CHMOD_READ']?></label></td>
                    <td><input type="checkbox" id="pub2" name="pub2" value="2" onclick="octalchange()"/><label for="pub2"> <?=$language[$langue]['CHMOD_WRITE']?></label></td>
                    <td><input type="checkbox" id="pub3" name="pub1" value="1" onclick="octalchange()"/><label for="pub3"> <?=$language[$langue]['CHMOD_EXECUTE']?></label></td>
                  </tr>
                </table>
              </fieldset>
              <br/>

              <table width="80%">
                <tr>
                  <td>
                    <p align="left" style="font-size:10px;"><?=$language[$langue]['CHMOD_NUM_VALUE']?> &nbsp;<input type="text" value="0744" id="val" size="20" class="reg" disabled /></p>
                  </td>
                  <td>
                    <input onclick="newType.value = 'chmod4select';other.value = gid('val').value;act.submit();" type="button" value="&nbsp;<?=$language[$langue]['CHMOD_SUBMIT']?>&nbsp;" class="dd"/>&nbsp; <?=$language[$langue]['CHMOD_OR']?> &nbsp;<input type="button" value="&nbsp;<?=$language[$langue]['CHMOD_RETURN']?>&nbsp;" class="dd" onclick="gid('listing').style.opacity = 1; gid('octal').style.display = 'none';" />
                  </td>
                </tr>
              </table>
            </form>
          </center>
        </div>        
        
        
      <script type="text/javascript">
          // Quelque variables
            var count = 0; // Nombre de fichiers selectionnés
            var opt = gid("options"); // get id
            var More = gid("more"); // get id
            var other = gid("other"); // get id
            var act = document.forms["act"]; // get name
            var newType = gid("newType"); // get id
            var newRoot = gid("newRoot"); // get id
            var ntc = false; // le NTC
            var menu = false; // Menu par défaut
            var timer; // Le temps du menu
            var dirs = <?=$dirs_nb?>; // Nombre de dossiers
            var files = <?=$files_nb?>;   // Nombre de fichiers
            
          // On reset 
            function mReset() {
            
            var Ds = (dirs > 1) ? "s" : "";
            var Fs = (files > 1) ? "s" : "";
            
            if(count > 0) More.value = count+"<?=$language[$langue]['LISTING_SELECTED']?>";
            else More.value = dirs+" <?=strtolower($language[$langue]['LISTING_DIR'])?>"+Ds+", "+files+" <?=strtolower($language[$langue]['LISTING_FILE'])?>"+Fs;
            
            }
			
          // Fonction bind (press key = action)
          <?php if($binding) { ?>
          
            function manage(event) {
            if(event.ctrlKey) return false;
            var e = event.keyCode;
            //push A
              if(e == 65) { setCheck("a"); } // Select all
            //push Z
              if(e == 90) { setCheck("n"); } // Unselect all
            //push E
              if(e == 69) { setCheck("r"); } // Reverse selection
            //push del
              if(e == 46) { hideOpt();delete4select(); } // Delete selection
            //push X
              if(e == 88) { hideOpt();newWin('?type=move&root='+root,340,550,',scrollbars=no,resizable=yes;'); } // Couper selection
            //push C
              if(e == 67) { hideOpt();newWin('?type=copy&root='+root,340,550,',scrollbars=no,resizable=yes;'); } // Copier selection
            // push 1 
              if(e == 97) { newfile(1); } // Fichier || File
            // push 0
              if(e == 96) { newfile(0); } // Dossier || Folder
            //push R
              if(e == 82) { window.location = "?type=list&root=<?=$ROOT?>"; }
            }
      
        <?php } ?>
      </script>

    </center>

  </body>
  
</html>

<?php

    }
    break;
  }

?>