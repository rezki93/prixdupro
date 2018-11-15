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
	Fichier: phpinfo.win.php
	Dernière modification: 10/06/2010
	Copyright (C) SimpleGeek 2010-2011
*/

#######################
##     SECURITE      ##
#######################

  if(!$logged)
	exit;
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=strtolower($langue)?>" lang="<?=strtolower($langue)?>"> 
	<head> 
	
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
		<meta name="desciption" content="PHP Web Manager: Reloaded - WebFTP" />
		<meta name="keywords" content="client ftp, ftp, php web manager, reloaded, simplegeek, manager, php, web, html, admin, password, filezilla" />
		<meta name="author" content="SimpleGeek" />
		
		<title>PHP Web Manager v<?=$version?></title>
		
		<link href="<?=$PWM_FILES?>css/phpinfo.css" rel="stylesheet" type="text/css" media="screen" />
		
	</head>

	<body>
		<div align="center" class="testdiv">
			<center>
				<h1><?=$language[$langue]['INFO_TITLE']?></h1>
			</center><br />
			<table class="test">
				<?php
				
				// Si le test est lancé
					if(isset($_GET['test']))
					{
						$erreurs = 0;
						if(!file_exists('./pwm_tests/'))

						if(!@mkdir('./pwm_tests/',0777))
							die('<tr><td width="20px"><img src="'.$PWM_FILES.'images/cross.png" alt="" /></td><td><font color="red">'.$language[$langue]['INFO_FOLDER'].'</font></td></tr>');

						if($file_open = @fopen('./pwm_tests/file.txt', 'w+'))
						{
							echo ('<tr><td width="20px"><img src="'.$PWM_FILES.'images/tick.png" alt="" /></td><td><font color="green">'.$language[$langue]['INFO_NEW_FILE_YES'].'</font></td></tr>');
							@fclose($file_open);
						}
						 
						else 
						{
							echo ('<tr><td width="20px"><img src="'.$PWM_FILES.'images/cross.png" alt="" /></td><td><font color="red">'.$language[$langue]['INFO_NEW_FILE_NO'].'</font></td></tr>');
							$erreurs++;
						}
						
						$fp = @fopen('./pwm_tests/file.txt', 'a+');
						if(@fwrite($fp, 'Vous pouvez supprimer ce fichier' ."\r"))
						{
							echo ('<tr><td width="20px"><img src="'.$PWM_FILES.'images/tick.png" alt="" /></td><td><font color="green">'.$language[$langue]['INFO_EDIT_YES'].'</font></td></tr>');
							@fclose($fp);
						}
						
						else
						{
							echo ('<tr><td width="20px"><img src="'.$PWM_FILES.'images/cross.png" alt="" /></td><td><font color="red">'.$language[$langue]['INFO_EDIT_NO'].'</font></td></tr>');
							$erreurs++;
						}
						
						if(@rename('./pwm_tests/file.txt','./pwm_tests/file_renamed.txt'))
						echo ('<tr><td width="20px"><img src="'.$PWM_FILES.'images/tick.png" alt="" /></td><td><font color="green">'.$language[$langue]['INFO_RENAME_YES'].'</font></td></tr>');
						else
						{
							echo ('<tr><td width="20px"><img src="'.$PWM_FILES.'images/cross.png" alt="" /></td><td><font color="red">'.$language[$langue]['INFO_RENAME_NO'].'</font></td></tr>');
							$erreurs++;
						}
					 
						if((@unlink('./pwm_tests/file_renamed.txt')) or (@unlink('./pwm_tests/file.txt')))
						echo  ('<tr><td width="20px"><img src="'.$PWM_FILES.'images/tick.png" alt="" /></td><td><font color="green">'.$language[$langue]['INFO_DELETE_F_YES'].'</font></td></tr>');
						else
						{
							echo ('<tr><td width="20px"><img src="'.$PWM_FILES.'images/cross.png" alt="" /></td><td><font color="red">'.$language[$langue]['INFO_DELETE_F_NO'].'</font></td></tr>');
							$erreurs++;
						}
					 
						if(@fs_rmdir('./pwm_tests/'))
						echo ('<tr><td width="20px"><img src="'.$PWM_FILES.'images/tick.png" alt="" /></td><td><font color="green">'.$language[$langue]['INFO_DELETE_D_YES'].'</font></td></tr>');
						else
						{
							echo ('<tr><td width="20px"><img src="'.$PWM_FILES.'images/cross.png" alt="" /></td><td><font color="red">'.$language[$langue]['INFO_DELETE_D_NO'].'</font></td></tr>');
							$erreurs++;
						}
						$percent =  array(100, 80, 60, 40, 20, 0);
						$erreurs_ = ($erreurs == 5) ? $erreurs++ : $erreurs;
						$s = ($erreurs > 1) ? 's' : '';
						$e = ($erreurs == 0) ? ' !' : '.';
						
						echo ('</table><br /><br /><table><tr><td>'.$language[$langue]['INFO_RESULT_1'].'<u>'.$erreurs.'</u> '.$language[$langue]['INFO_RESULT_2'].$s.' : '.$language[$langue]['INFO_RESULT_3'].$percent[$erreurs_].'% '.$language[$langue]['INFO_RESULT_4'].$e.'</td></tr></table></div>');
					}

					else
						echo ('<form action="?type=phpinfo&test" method="post"><input type="submit" value="'.$language[$langue]['INFO_SUBMIT_TEST'].'" /></form>');


					echo ('</table></div><div align="center" class="phpinfo"><h1>'.$language[$langue]['INFO_PHP'].'</h1><br />');
					ob_start();
						phpinfo();
						$pinfo = ob_get_contents();
					ob_end_clean();
						$pinfo = preg_replace( '%^.*<body>(.*)</body>.*$%ms','$1',$pinfo);
					// PHPBB code
						if (preg_match('#<a[^>]*><img[^>]*></a>#', $pinfo))
							{
								$pinfo = preg_replace('#<tr class="v"><td>(.*?<a[^>]*><img[^>]*></a>)(.*?)</td></tr>#s', '<tr class="row1"><td><table class="type2"><tr><td>\2</td><td>\1</td></tr></table></td></tr>', $pinfo);
							}
						else
							{
								$pinfo = preg_replace('#<tr class="v"><td>(.*?)</td></tr>#s', '<tr class="row1"><td><table class="type2"><tr><td>\1</td></tr></table></td></tr>', $pinfo);
							}
						$pinfo = str_replace('PHP Credits','',$pinfo);
						$pinfo = preg_replace('#<table[^>]+>#i', '<table>', $pinfo);
						$pinfo = preg_replace('#<img border="0"#i', '<img', $pinfo);
						$pinfo = preg_replace('#<a href="http://www.php.net/"><img src="/([a-z0-9\._-]+)\?\=([^"]+)" alt="PHP Logo" /></a><h1 class="p">([a-z0-9 .+-]+)</h1>#iU', '<center><a href="http://www.php.net/"><img src="'.$PWM_FILES.'images/PHP.png" width="128px" height="128px" alt="PHP Logo" /></a><h1 class="p">PHP Version 5.2.6-1+lenny4</h1></center>', $pinfo);
						$pinfo = preg_replace('#<img src="/([a-z0-9\._-]+)\?\=([^"]+)" alt="Zend Logo" />#iU', '<img src="'.$PWM_FILES.'images/zend.png" width="128px" height="128px" alt="Zend Logo" />', $pinfo);
						$pinfo = preg_replace('#<img src="/([a-z0-9\._-]+)\?\=([^"]+)" alt="Suhosin Logo" />#iU', '<img src="'.$PWM_FILES.'images/suhosin.png" alt="Suhosin Logo" />', $pinfo);
						$pinfo = str_replace(array('class="e"', 'class="v"', 'class="h"', '<hr />', '<font', '</font>'), array('class="row1"', 'class="row2"', '', '', '<span', '</span>'), $pinfo);
					echo $pinfo;
					if (@function_exists('ini_get_all'))
					{
						echo '<center><h1 style="margin-bottom:15px;">PHP.INI Reader</h1></center>';

						function U_wordwrap($str) {
							$str = @wordwrap(@htmlspecialchars($str), 100, '<wbr />', true);
							return @preg_replace('!(&[^;]*)<wbr />([^;]*;)!', '$1$2<wbr />', $str);
						}

						function U_value($value) {
							if (empty($value)) return '<i>no value</i>';
							if (@is_bool($value)) return $value ? 'TRUE' : 'FALSE';
							if ($value === null) return 'NULL';
							if (@is_object($value)) $value = (array) $value;
							if (@is_array($value))
							{
								@ob_start();
								print_r($value);
								$value = @ob_get_contents();
								@ob_end_clean();
							}
							return U_wordwrap((string) $value);
						}

						echo '<table>
							<tr>
								<th>Directive</th>
								<th>Local Value</th>
								<th>Master Value</th>
							</tr>';
						foreach (@ini_get_all() as $key=>$value)
						{
							echo '
							<tr>
								<td class="row1">'.$key.'</td>
								<td class="row2">'.U_value($value['local_value']).'</td>
								<td class="row2">'.U_value($value['global_value']).'</td>
							</tr>';
					  }
					}

				?>
			</table>
		</div>
	</body>
</html>