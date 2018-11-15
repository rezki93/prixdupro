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
	Fichier: functions.inc.php
	Dernière modification: 10/06/2010
	Copyright (C) SimpleGeek 2010-2011
*/

#######################
##   FONCTIONS PHP   ##
#######################

// Sécurité des slashes
	function rmslashes($str) {
		$str = str_replace('//','/', str_replace('\\','/',$str));
		if(substr($str,-1) == '/' && strlen($str) > 1)
			$str = substr($str,0,-1);
		
		return $str;
	}
	
	function partpath($str) {
	//Recherche contenant des parenthèses.
		$str =  str_replace('(','&part',$str);
		$str =  str_replace(')','&parts',$str);
		return $str;
	}
	
// Sécurité des caractères
	function format($str) {
		return strtr(trim($str), '"¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏĞÑÒÓÔÕÖØÙÚÛÜİßàáâãäåæçèéêëìíîïğñòóôõöøùúûüıÿ@#%&[]{}?$', '_YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy__________');
	}
	
// Redirection du header
	function redirect($to) {
		if (headers_sent())
		{
			echo '<meta http-equiv="refresh" content="0;URL='.rmslashes($to).'">';
		}
		else
		{
			header("Location: $to");
		}
	}
	
// Obtenir le Mime
	function getmime($filename) {
		$ext = strtolower(end(explode('.', $filename)));
		$mime = array(
						'htm' => 'text/html',
						'html' => 'text/html',
						'css' => 'text/css',
						'js' => 'text/javascript',
						'rtf' => 'text/rtf',
						'xml' => 'text/xml',
						'txt' => 'text/plain',
						'jpe' => 'image/jpeg',
						'jpeg' => 'image/jpeg',
						'jpg' => 'image/jpeg',
						'gif' => 'image/gif',
						'bmp' => 'image/bitmap',
						'png' =>'image/png',
						'tif' =>'image/tiff',
						'tiff' =>'image/tiff',
						'mp2' => 'audio/mpeg',
						'mp3' => 'audio/mpeg',
						'mid' => 'audio/midi',
						'midi' => 'audio/midi',
						'mpga' => 'audio/mpeg',
						'wav' => 'audio/x-wav',
						'mp4' => 'video/mpeg',
						'mpe' => 'video/mpeg',
						'mpg' => 'video/mpeg',
						'avi' => 'video/x-msvideo',
						'mov' => 'video/quicktime',
						'movie' => 'video/x-sgi-movie',
						'mpeg' => 'video/mpeg',
						'fli' => 'video/x-fli',
						'zip' => 'application/zip',
						'swf' => 'application/x-shockwave-flash',
						'gtar' => 'application/x-gtar',
						'gz' => 'application/x-gzip',
						'ai' => 'application/postscript',
						'dir' => 'application/x-director',
						'doc' => 'application/msword',
						'pps' =>'application/mspowerpoint',
						'ppt' =>'application/mspowerpoint',
						'ppz' =>'application/mspowerpoint',
						'pdf' =>'application/pdf',
						'exe' => 'application/octet-stream',
						'tar' =>'application/x-tar' );
		return (array_key_exists($ext,$mime)) ? $mime[$ext] : 'text/plain';
	}
	
// Récupération du root
	function getroot() {
		if(is_dir($_SERVER['DOCUMENT_ROOT']))
		return $_SERVER['DOCUMENT_ROOT'];

		elseif(is_dir($_SERVER['DOCUMENT_ROOT_HASH']))
		return $_SERVER['DOCUMENT_ROOT_HASH'];

		else
		{
			$array = explode('/',dirname($_SERVER['SCRIPT_FILENAME']));
			foreach($array as $dir)
			{
				$path .= is_dir($dir) ? null : ($dir.'/');
				if(is_dir($path)) return realpath($path);
			}
			$real = realpath('.');
		}

		if(is_dir($real))
		return $real;

	return false;
	}
	
// Retourne la taille d'un dossier
	function sizethisdir($src) {
		$units = array('octets','Ko','Mo','Go','To');
		$cpt = 0;
		$size = 0;
		
		if($h = opendir($src))
		{
			while (($o = readdir($h))!== false)
			{
				if (($o !== '.') && ($o !== '..'))
				{
					if (is_dir($src.'/'.$o))
					{
						$size+=sizethisdir($src.'/'.$o);
					}
				else
				{
					$size+=filesize($src.'/'.$o);
				}
			}
		}
		
		closedir($h);
		
		$file_size = intval($size);
		while ($file_size > 1024)
		{
			$file_size = $file_size / 1024;
			$cpt++;
		}
		$size = round($file_size, 1). ' ' .$units[$cpt];
		return $size;

		}
	
		else return false;
	}

// Retourne la taille d'un fichier
	function sizethis($src) {
		$cpt = 0;
		$units = array('octets','Ko','Mo','Go','To');
		$file_size = intval(filesize($src));
		while ($file_size > 1024)
		{
			$file_size = $file_size / 1024;
			$cpt++;
		}
		$size = round($file_size, 1). ' ' .$units[$cpt];
		return $size;
	}

// Suppression intégrale d'un dossier.
	function fs_rmdir($src) {
		chmod($src,0777);
		if($h = opendir($src))
		{
			while ($o = readdir($h))
			{
				if (($o !== '.') and ($o !== '..'))
				{
					if (is_file($src.'/'.$o))
					{
						// Fichier
						if(!unlink($src.'/'.$o))
						{
							chmod($src.'/'.$o, 0777);
							unlink($src.'/'.$o);
						}
					}
					
					elseif(is_dir($src))
					{
						// Dossier, on renvois la fonction.
						fs_rmdir($src.'/'.$o);
					}
				}
			}
			closedir($h);
			return (rmdir($src));
		}
		
		else return false;
	}
	
// Copie intégrale d'un dossier et de ses sous-fichiers.
	function fs_copy($dir,$src)	{
		if ($h = opendir($dir))
		{
			// On recrée le chemin du dossier à copier.
			if (!is_dir($src)) 
				mkdir($src,0777);
			while ($file = readdir($h))
			{
				if($file !== '..'  && $file !== '.')
				{
					if(is_dir($dir.'/'.$file))
					{
						// On renvoi la fonction.
						fs_copy($dir.'/'.$file, $src);
					}
					else
					{
						// Fichier, simple copie.
						copy ($dir.'/'.$file , $src.'/'.$file);
					}
				}
			}
			 closedir($h);
			 return true;
		}
		else
		{ 
			return false; 
		}
	}
	
// Rétrécie un nom trop long
	function str2mini($content,$len) {
		if (strlen($content) > $len)
		{
			$len = ceil($len/2) - 2;
			return substr($content, 0,$len).'...'.substr($content,-$len);
		}
		return $content;
	}
	
// Retourne le path linké
	
	function path2link($str) {
		global $win;
		$bar = explode('/',$str);
		$bar = array_filter($bar);
		$link = null;

		foreach($bar as $minipath)
		{
			if($win)
			{
				$path .= $minipath . '/' ;
			}
			else
			{
				$path .= '/' .$minipath ;
			}

			if(@is_dir($path))
			{
				if(!is_writable($path))
					$class = 'nowrite';

				if(!is_readable($path))
					$class = 'noread';

				else
					$class = 'none';

			$link .= '<a href="?type='.$_GET['type'].'&root='.$path.'" class="'.$class.'">'.$minipath.DIRECTORY_SEPARATOR.'</a>';
			}
		}

return $link;
}

// Inverse du realpath
	function getdir($path) {
		global $ROOT;
		$ROOT = rmslashes($ROOT);
		$new = preg_replace('`^'.preg_quote($ROOT,'`').'`', null, rmslashes($path));
		return empty($new) ? '/' : $new;
	}
	
// Récupération des permissions chmod
	function view_perms($mode) {
		if (($mode & 0xc000) === 0xc000) {$type = 's';}
		elseif (($mode & 0x4000) === 0x4000) { $type = 'd' ; }
		elseif (($mode & 0xa000) === 0xa000) { $type = 'l' ; }
		elseif (($mode & 0x8000) === 0x8000) { $type = '-' ; }
		elseif (($mode & 0x6000) === 0x6000) { $type = 'b' ; }
		elseif (($mode & 0x2000) === 0x2000) { $type = 'c' ; }
		elseif (($mode & 0x1000) === 0x1000) { $type = 'p' ; }
		else {$type = '?';}

		$owner['read'] = ($mode & 00400) ? 'r' : '-' ;
		$owner['write'] = ($mode & 00200) ? 'w' : '-' ;
		$owner['execute'] = ($mode & 00100) ? 'x' : '-' ;
		$group['read'] = ($mode & 00040) ? 'r' : '-' ;
		$group['write'] = ($mode & 00020) ? 'w' : '-' ;
		$group['execute'] = ($mode & 00010) ? 'x' : '-' ;
		$world['read'] = ($mode & 00004) ? 'r' : '-' ;
		$world['write'] = ($mode & 00002) ? 'w' : '-' ;
		$world['execute'] = ($mode & 00001) ? 'x' : '-' ;

		if ($mode & 0x800) {$owner['execute'] = ($owner['execute'] == 'x') ? 's' : 'S' ;}
		if ($mode & 0x400) {$group['execute'] = ($group['execute'] == 'x') ? 's' : 'S' ;}
		if ($mode & 0x200) {$world['execute'] = ($world['execute'] == 'x') ? 't' : 'T' ;}

		$hex = $type.implode(null,$owner).implode(null,$group).implode(null,$world);

		return ($hex[0] == '?') ? '<font color="red">'.$hex.'</font>' : $hex;
	}
	
// Obtenir le temps d'execution d'une page
	function getMtime() {
		$dd = explode(' ',microtime() );
		$da = $dd[1].substr($dd[0], 1);
		return $da;
	}

	 function writeTime($da,$uni) {
		$dc = explode(' ',microtime() );
		$dv = $dc[1].substr($dc[0],1);
		$setT = number_format($dv - $da, 4);
		if($uni > strlen($setT))
		{
			$setT = substr($setT, 0, strlen($setT));
			}
		else
		{
			$setT = substr($setT, 0, $uni);
		}
		return $setT;
	}
	
// Scanner un FTP
	function scan_txt($tofind,$file) {

		$tofind = str_replace('$','',$tofind); // Permet de chercher dans les variables PHP
		if($recup=@file($file))
		{
			while(list($line_num, $line) = each($recup))
			{
				if(!isset($_GET['casse']) || $_GET['casse'] == "0")
				{
					if(eregi(htmlentities($tofind),htmlentities($line)))
					{
						$self[$line_num] = htmlspecialchars($line); // On enregistre la ligne et son n°
					}
				}
				else
				{
					if(ereg(htmlentities($tofind),htmlentities($line)))
					{
					$self[$line_num] = htmlspecialchars($line); // On enregistre la ligne et son n°
					}
				}
			}
		}
		else return FALSE;
		if(!empty($self)) return $self;
		else return false;
	}

// Parcours un FTP
	function runftp($from) {
		if($h = opendir($from))
		{
			$tree[] = $from;
			while ($o = readdir($h))
			{
				if (($o != '.') and ($o != '..'))
				{
					if (@is_dir($from.'/'.$o))
					{
						$tree[] = $from.'/'.$o;
						$tree = array_merge($tree,runftp($from.'/'.$o));
					}
				}
			}
			closedir($h);
		}
		else return false;
		return $tree;
	}
	
?>