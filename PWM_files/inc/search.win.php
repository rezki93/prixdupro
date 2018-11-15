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
	Fichier: search.win.php
	Dernière modification: 10/06/2010
	Copyright (C) SimpleGeek 2010-2011
*/

#######################
##     SECURITE      ##
#######################

  if(!$logged)
	exit;
			
	// Recherche de nom de fichiers et/ou dossiers
	if(isset($_GET['search']) && !empty($_GET['search']) && isset($_GET['txtsearch']))
	{
						
	// Une paire de ternaire
		$search = (isset($_GET['search'])) ? '&search='.$_GET['search'] : '';
		$casse = (isset($_GET['casse'])) ? '&casse='.$_GET['casse'] : '';
		$txtsearch = (isset($_GET['txtsearch'])) ? '&txtsearch='.$_GET['txtsearch'] : '';
	// On set le cookie avant l'HTML
		setcookie('pwm_lrt',$TYPE.'&root='.$root.$search.$casse.$txtsearch,$timestamp_expire,'/');
	}
			
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
		<link href="<?=$PWM_FILES; ?>css/global.css" rel="stylesheet" type="text/css" media="screen" />
		<script type="text/javascript" src="<?=$PWM_FILES?>global_<?=strtolower($langue)?>.js" /></script>
		<script type="text/javascript">
		// On déclare root en JS
			var root = "<?=addslashes($root)?>";
			function switch_disabled(){
				if (document.searchform.exept.disabled==true)
					document.searchform.exept.disabled=false
				else
					document.searchform.exept.disabled=true
			}
		</script>
		
	</head>

	<body>
	
		<table class="head" width="99%" cellpadding="8">
			<tr>
				<td>
				<form action="" method="GET" name="searchform" id="a">
					<input type="hidden" name="type" value="search" />
					<input type="hidden" name="root" value="<?=$root?>" />
				
				<?=$language[$langue]['SEARCH_SEARCH']?>: <input type="text" name="search" class="inputsearch" value="<?php if(isset($_GET['search']) && !empty($_GET['search'])) echo $_GET['search']; else echo ($language[$langue]['SEARCH_SEARCH'].'...'); ?>" onfocus="if(this.value=='<?=$language[$langue]['SEARCH_SEARCH']?>...'){this.value=''}" size="20" />
				<?=$language[$langue]['SEARCH_EXEPT']?>: <input type="text" name="exept" id="exept" class="inputsearch" size="20" value="<?php if(isset($_GET['exept']) && !empty($_GET['exept'])) echo $_GET['exept']; else echo (''); ?>" <?php if($_GET['txtsearch'] == "off" || !isset($_GET['txtsearch'])) echo ('disabled'); ?> />
				<input type="checkbox" onclick="if(this.checked)document.getElementById('x1').style.color='black';else document.getElementById('x1').style.color='darkgray';" name="casse" class="inputchecksearch" value="1" <?php if($_GET['casse'] == "0" || !isset($_GET['casse'])) echo (''); else echo ('checked'); ?> /> <i style="color: <?php if($_GET['casse'] == "0" || !isset($_GET['casse'])) echo ('darkgray'); else echo ('black'); ?>;" id="x1"><?=$language[$langue]['SEARCH_CASE']?></i>
				<input type="checkbox" onclick="switch_disabled(); if(this.checked)document.getElementById('x2').style.color='black';else document.getElementById('x2').style.color='darkgray';"  name="txtsearch" <?php if($_GET['txtsearch'] == "off" || !isset($_GET['txtsearch'])) echo (''); else echo ('checked'); ?> /> <i style="color: <?php if($_GET['txtsearch'] == "off" || !isset($_GET['txtsearch'])) echo ('darkgray'); else echo ('black'); ?>;" id="x2"><?=$language[$langue]['SEARCH_NAME']?></i>
				<input type="submit" value="<?=$language[$langue]['SEARCH_START']?>" style="cursor: pointer;" class="buttonsearch" /></form></td><td width="*" align="right"><a href="?type=list&root=<?=$root?>" class="inp"><?=$language[$langue]['SEARCH_BACK']?></a></td>
			</tr>
		</table>
		
			<?php

			
			// Recherche de nom de fichiers et/ou dossiers
				if(isset($_GET['search']) && !empty($_GET['search']) && isset($_GET['txtsearch']))
				{
				
			?>
					<div class="listing"><br/>
						<table class="list" width="99%" cellpadding="3"  cellspacing="3" id="list">
							<tr name="FTP">
								<th nowrap name="files" width="30%"><span class="line"><?=$language[$langue]['SEARCH_FILE']?></span></th>
								<th nowrap name="type" width="22%"><span class="line"><?=$language[$langue]['SEARCH_TYPE']?></span></th>
								<th nowrap name="dir" width="30%"><span class="line"><?=$language[$langue]['SEARCH_ONDIR']?></span></th>
								<th nowrap name="actions" align="right"><?=$language[$langue]['SEARCH_ACTIONS']?></th>
							</tr>

					<?php

					$a0 = getMtime();
					$tree = runftp($root);
					$found_file = 0;
					$C = ($_GET['casse'] == 0) ? null : 'i' ;
					// On protect
					$search = htmlentities($_GET['search']);
					$exept = htmlentities($_GET['exept']);
					foreach($tree as $key => $hdir)
					{
						if($handle_search = opendir($hdir))
						{
							while ($file = readdir($handle_search))
							{
								$unfile = empty($exept) ? 0 : preg_match("`$exept`$C",$file);
								if(!in_array($file,$arr_notdisp) && !$unfile)
								{
									$file_path = $hdir. '/' .$file;								
									if(@is_dir($file_path))
									{
										$which_type = 0;
									}
									else // Sinon si c'est un fichier
									{
										$ext = strtolower(substr(strrchr($file,'.'),1));
										if(array_key_exists($ext, $classType))
											$which_type = $classType[$ext]; //récup du wt
												
										else //attribution d'une nouvelle classe
										{ 
											$plus = count($classType) + 1;
											$classType[$ext] = $plus;
											$which_type = $plus;
										}								
									}

									if(!isset($_GET['casse']) || $_GET['casse'] == "0")
									{
										if(eregi(partpath($search),partpath(basename($file))))
										{
											if(!@in_array((array('name' => $file_path,'type' => $which_type,'dir' => $hdir)),$ftp))
											{
												$ftp[] = array('name' => $file_path,'type' => $which_type,'dir' => $hdir);
												$found_file++;
											}
										}
									}
									else
									{
										if(ereg(partpath($search),partpath(basename($file))))
										{
											if(!@in_array((array('name' => $file_path,'type' => $which_type,'dir' => $hdir)),$ftp))
											{
												$ftp[] = array('name' => $file_path,'type' => $which_type,'dir' => $hdir);
												$found_file++;
											}
										}
									}
								}
							}
							closedir($handle_search);

						}
						
						if($found_file == 1)
							$sx = '';
						else 
							$sx = ($langue == 'FR') ? 's' : '';
						if($found_file == 0)
							$rsult = $language[$langue]['SEARCH_FAIL'];
						elseif($found_file == 1)
							$rsult = '<b>1</b> '.$language[$langue]['SEARCH_RESULT_1'].' ('.writeTime($a0, "4").' '.$language[$langue]['SEARCH_SECONDS'].')';
						else
							$rsult = '<b>' .$found_file. '</b> '.$language[$langue]['SEARCH_RESULT_2'].$sx.' '.$language[$langue]['SEARCH_RESULT_3'].$sx.' ('.writeTime($a0, "4").' '.$language[$langue]['SEARCH_SECONDS'].')';
					}
					
					$display = 0;
					while($display < $found_file)
					{
					//Brut FTP
						$file = $ftp[$display];
						$file2 = realpath($root.'/'.$file['name']);
						$HTTP_PATH = urldecode($PROTOCOL.$HOST.getdir($file['name'])); //Chemin HTTP
						$filename = basename($file['name']);
						if(strlen($filename) > 40)
						{
							$filename = substr($filename,0,36) . ' ...';
						}
						
						$dirname = $file['dir'];
						if(strlen($dirname) > 40)
						{
							$dirname = substr($dirname,0,36) . ' ...';
						}
						
						if($file['type'] == 0)
						{
						// Dossier				
							echo '<tr class="opacity" id="'.$display.'">
									<td>
										<img src="'.$PWM_FILES.'images/rep.png">
										<a href="?type=list&root='.$file['name'].'">' .$filename. '</a>
									</td>
									<td name="type">
										'.$language[$langue]['SEARCH_DIR'].'
									</td>
									<td name="dir">
										<a class="realpath" href="?type=list&root=' .$file['dir']. '">' .$HOST.getdir($dirname). '</a>
									</td>
									<td align="right" name="actions">
										<a href="javascript:newrename(\''.($file['name']).'\',\''.($filename).'\',1);" title="'.$language[$langue]['LISTING_RENAME'].' '.$filename.'">
												<img src="'.$PWM_FILES.'images/actions/rename.png" alt="'.$language[$langue]['LISTING_RENAME'].' '.$filename.'">
											</a>
										<a href="javascript:remove(\''.$file['name'].'\',\''.$filename.'\',0);" title="'.$language[$langue]['LISTING_DELETE'].' '.$filename.'">
											<img src="'.$PWM_FILES.'images/actions/delete.png" border="0" alt="'.$language[$langue]['LISTING_DELETE'].' '.$filename.'"/>
										</a>
										<a href="' .$HTTP_PATH. '" target="_blank" title="'.$language[$langue]['LISTING_VIEW'].' '.$filename.'">
											<img src="'.$PWM_FILES.'images/actions/view.png" border=0 alt="'.$language[$langue]['LISTING_VIEW'].' '.$filename.'">
										</a>
									</td>
								</tr>';


							$dirs_nb++;;
						}
						
						else
						{
						//Fichier
							if ($file['type'] >= 1 && $file['type'] <= 15) // Edit
								$links = '?type=edit&fp='.urlencode($root.getdir($file['name']));
										
							elseif ($file['type'] == 28 || $file['type'] == 29) // MP3
								$links = 'javascript:load(\''.$HTTP_PATH.'\',\''.$file_path.'\');';
								
							else // Inconnu
								$links = $HTTP_PATH ;
									
									$files_nb++;
									
								// Force edit
									if(!in_array($file['type'], $classType2))
										$f_edit = '<a href="?type=edit&fp='.$file_path.'" title="Edition"><img src="'.$PWM_FILES.'images/actions/force_edit.png" border="0" alt="'.$language[$langue]['LISTING_FORCING'].' '.$filename.'"/>
</a> ';
									else
										$f_edit = null;
							$ext = strtolower(substr(strrchr($file['name'],'.'),1));
							$icone = (in_array($file['type'], $classType2)) ? '<img src="'.$PWM_FILES.'images/ext/'.strtolower($ext).'.png" alt="'.$language[$langue]['LISTING_FILE'].' '.strtoupper($ext).'" />' : ($ext == 'htaccess' || $ext == 'htpasswd') ? '<img src="'.$PWM_FILES.'images/ext/'.$ext.'.png" alt="'.$language[$langue]['LISTING_FILE'].' '.strtoupper($ext).'" />' : '<img src="'.$PWM_FILES.'images/ext/no.png" alt="'.$language[$langue]['LISTING_FILE'].' '.strtoupper($ext).'" />';

							switch($ext)
							{
								case 'php' : $that=$language[$langue]['LISTING_FILE'].' PHP'; break;
								case 'js' : $that=$language[$langue]['LISTING_FILE'].' JavaScript'; break;
								case 'html' : $that=$language[$langue]['SEARCH_HTML'].' HTML'; break;
								case 'htm' : $that=$language[$langue]['SEARCH_HTML'].' HTM'; break;
								case 'txt' : $that=$language[$langue]['LISTING_FILE'].' Texte'; break;
								case 'psd' : $that='Image Photoshop'; break;
								case 'css' : $that=$language[$langue]['LISTING_FILE'].' CSS'; break;
								case 'cfg' : $that=$language[$langue]['LISTING_FILE'].' de configuration'; break;
								case 'pps' : $that=$language[$langue]['LISTING_FILE'].' PowerPoint'; break;
								case 'ppsx' : $that=$language[$langue]['LISTING_FILE'].' PowerPoint'; break;
								case 'ppt' : $that=$language[$langue]['LISTING_FILE'].' PowerPoint'; break;
								case 'pptx' : $that=$language[$langue]['LISTING_FILE'].' PowerPoint'; break;
								case 'xls' : $that=$language[$langue]['LISTING_FILE'].' Excel'; break;
								case 'xlsx' : $that=$language[$langue]['LISTING_FILE'].' Excel'; break;
								case 'doc' : $that=$language[$langue]['LISTING_FILE'].' Word'; break;
								case 'docx' : $that=$language[$langue]['LISTING_FILE'].' Word'; break;
								case 'gz' : $that='Archive GZ'; break;
								case 'rar' : $that='Archive RAR'; break;
								case 'zip' : $that='Archive ZIP'; break;
								case 'swf' : $that='Animation Flash'; break;
								case '' : $that=$language[$langue]['LISTING_FILE'].' '.$language[$langue]['SEARCH_UNKNOWN']; break;
								default : $that=$language[$langue]['LISTING_FILE'].' ' .strtoupper($ext); break;
							}

							echo '<tr class="opacity" id="'.$display.'">
									<td>
										'.$icone.'
											<a href="'.$links.'">'.$filename.'</a>
										</td>
										<td name="type">
											'.$that.'
										</td>
										<td name="dir">
											<a class="realpath" href="?type=list&root=' .$file['dir']. '">' .$HOST.getdir($dirname). '</a>
										</td>
										<td align="right">
											<a href="?type=download&src=' .$file['name']. '" title="'.$language[$langue]['LISTING_DOWNLOAD'].' '.$filename.'">
												<img src="'.$PWM_FILES.'images/actions/dl.png" alt="'.$language[$langue]['LISTING_DOWNLOAD'].' '.$filename.'">
											</a>
											<a href="javascript:newrename(\''.($file['name']).'\',\''.($filename).'\',1);" title="'.$language[$langue]['LISTING_RENAME'].' '.$filename.'">
												<img src="'.$PWM_FILES.'images/actions/rename.png" alt="'.$language[$langue]['LISTING_RENAME'].' '.$filename.'">
											</a>
											<a href="javascript:remove(\''.$file['name'].'\',\''.$filename.'\',1);" title="'.$language[$langue]['LISTING_DELETE'].' '.$filename.'">
												<img src="'.$PWM_FILES.'images/actions/delete.png" alt="'.$language[$langue]['LISTING_DELETE'].' '.$filename.'"/>
											</a>
											<a href="' .$HTTP_PATH. '" target="_pwm" title="'.$language[$langue]['LISTING_VIEW'].' '.$filename.'">
												<img src="'.$PWM_FILES.'images/actions/view.png" alt="'.$language[$langue]['LISTING_VIEW'].' '.$filename.'">
											</a>
										</td>
									</tr>';
							$files_nb++;
						}
						$display++;
					}
					if(empty($ftp))
					echo '<tr id="'.$display.'"><td>'.$language[$langue]['SEARCH_FOUND'].'</td><td style="padding-left:10px;">n/a</td><td>--/--</td></tr>';
					echo('</div>');
				}			

			//Recherche de mots clés dans des fichiers textes.
				elseif(isset($_GET['search']) and !empty($_GET['search']) && !isset($_GET['txtsearch']))
				{
					$a0 = getMtime();
					$arr_txt = array('pl','php','txt','cfg','htaccess','htpasswd','log','xml','htm','html','css');
					$tree = runftp($root);
					$occ = 0;
					$found = 0;
					$search = addslashes(htmlentities($_GET['search']));
					foreach($tree as $key => $hdir)
					{
						if($handle_search = opendir($hdir))
						{
							while ($file = readdir($handle_search))
							{
								if(!in_array($file,$arr_notdisp))
								{
									$file_path = $hdir. '/' .$file;
									if(!@is_dir($file_path) && in_array(strtolower(substr(strrchr($file,'.'),1)),$arr_txt))
									{
										if($lol = scan_txt($search,$file_path))
										{	
											if(!@in_array((array('src' => $file_path,'lines' => $lol)),$ftp))
											{
												$ftp[] = array('src' => $file_path,'lines' => $lol);
												$found++;
												$occ = $occ + count($lol);
											}
										}
									}

								}
							}
							closedir($handle_search);
						}
					}
					
					if($found == 1)
						$sx = '';
					else
						$sx = ($langue == 'FR') ? 's' : '';	
					if($occ == 0)
						$rsult = $language[$langue]['SEARCH_FAIL'];
					elseif($occ == 1)
						$rsult = '<b>1</b> '.$language[$langue]['SEARCH_RESULT_1'].' ('.writeTime($a0, "4").' '.$language[$langue]['SEARCH_SECONDS'].')';
					else
						$rsult = '<b>' .$occ. '</b> '.$language[$langue]['SEARCH_RESULT_2'].$sx.' '.$language[$langue]['SEARCH_RESULT_3'].$sx.' ('.writeTime($a0, "4").' '.$language[$langue]['SEARCH_SECONDS'].')';
				}
				
				if(isset($found))
				{
					if($found == 0)
						echo ('<!--<div class="search">-->');
					else
						echo ('<div class="search">');
					
			
					$display = 0;
							
					while($display<$found)
					{
						$file = $ftp[$display];	
						$occurence_file = count($file['lines']);					
							if($occurence_file != 1)
								$occurence_file .= ' occurences';						
							else
								$occurence_file .= ' occurence';						
					// Le nom du fichier
						echo ('<b style="padding-left:5px;"><a href="?type=edit&fp='.dirname($file['src']).'/'.basename($file['src']).'">'.basename($file['src']).'</a></b>');
					// Le nombre d'occurence par fichier
						echo ('<span style="padding-left: 6px; padding-right: 12px;">('.$occurence_file.')</span><img style="cursor:pointer;" src="'.$PWM_FILES.'images/actions/minus.gif" border="0" onclick="hide(\'hid'.$display.'\');skimg(this);">');
						echo "<br />";
					// Le chemin du dossier
						echo ('<div style="margin-top: 5px; padding-left: 25px;">- '.$language[$langue]['SEARCH_ONDIR'].': <i><a href="?type=list&root='.dirname($file['src']).'">'.$HOST.dirname(getdir($file['src'])).'</a></i></div>');
						echo ('<br /><table style="font-family: Courier New, Arial, Microsoft Sans Serif,LineDraw,Trebuchet MS;	font-size: 12px;" class="results" id="hid'.$display.'"><br />');

					// Le foreach d'affichage
						foreach($file['lines'] as $num => $line)
						{					
							$vars = str_replace('$','',$_GET['search']);
							$line_code = eregi_replace(htmlspecialchars($_GET['search']),'<b style="color: red; padding: 1px;"><u>' .htmlspecialchars($_GET['search']). '</u></b>',$line);
							$line_code = eregi_replace($vars,'<b style="color: red; padding: 1px;"><u>' .htmlspecialchars($vars). '</u></b>',$line_code);
							echo ('<tr id="'.$display.'"><td nowrap>'.$language[$langue]['SEARCH_LINE'].$num.' :</td><td nowrap style="padding-left:8px;">'.stripslashes($line_code).'</td></tr>');
						}
						echo "</table>";
						echo "<br /><hr size=1 align=left color=#C0C0C0 width=65%><br />";

						$display++;
					}
					
					if($found == 0)
						echo ('<!--</div-->');
					else
						echo ('</div>');
					echo ('</div>');
				}

			?>

		
		<table class="foot" width="99%" cellpadding="10">
			<tr>
				<td width="70%" align="left"><?=$language[$langue]['SEARCH_BOTTOM']?></td>
				<?='<td align="right">'.$rsult.'</td>'?>
			</tr>
		</table>
	</body>
</html>