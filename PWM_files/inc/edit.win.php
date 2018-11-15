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
  Fichier: edit.win.php
  Dernière modification: 10/06/2010
  Copyright (C) SimpleGeek 2010-2011
*/

#######################
##     SECURITE      ##
#######################

  if(!$logged)
	exit;

require($PWM_FILES.'inc/config.inc.php');

$ext = strtolower(preg_replace('/(.*?\.)(\w+)$/i', '$2', $_GET['fp']));
$file4edit = array('php','html','htm','css','js');
$type = $_GET['type'];
$FP = $_GET['fp'];

setcookie('pwm_lrt',$type.'&fp='.$FP,$timestamp_expire,'/');

$HTTP_PATH = (preg_match('`^'.quotemeta($ROOT).'/`',$_GET['fp']))  ? $PROTOCOL . $HOST . getdir($_GET['fp']) : '?to='.base64_encode($_GET['fp']);
  
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
  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=strtolower($langue)?>" lang="<?=strtolower($langue)?>"> 
  <head> 
  
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
    <meta name="desciption" content="PHP Web Manager: Reloaded - WebFTP" />
    <meta name="keywords" content="client ftp, ftp, php web manager, reloaded, simplegeek, manager, php, web, html, admin, password, filezilla" />
    <meta name="author" content="SimpleGeek" />
    
    <title>PHP Web Manager v<?=$version?></title>
    
    <link href="<?=$PWM_FILES?>css/global.css" rel="stylesheet" type="text/css" media="screen" />
    <script type="text/javascript" src="<?=$PWM_FILES?>global_<?=strtolower($langue)?>.js"></script>
    <!-- CODE MIRROR SCRIPT //-->
    <script type="text/javascript" src="<?=$PWM_FILES?>codemirror/js/codemirror.js"></script>
    <script type="text/javascript" src="<?=$PWM_FILES?>codemirror/js/editor.js.js"></script>

    <style>
    .CodeMirror-line-numbers {
color: #aaa;
text-align: right;
width: 50px;
padding-right: .5em;
padding-top: .4em;
  font-family: "Trebuchet MS";
  font-size: 12px;
  line-height: 12pt;
  border-right: 1px solid grey;
}
</style>
    
  </head>

  <body>
  
    <form action="#save" method="post" id="edit" name="edit"><table class="head" width="99%" cellpadding="2">
    <tr>
      <td width="10">&nbsp;</td>
      <td width="80%" align="left"><i><?=str2mini(getdir($_GET['fp']),175)?></i></td>
      <td width="18%" align="right">
        <img src="./PWM_files/images/save.gif" style="cursor: pointer;" onclick="saveCode('<?=addslashes($_GET['fp'])?>', '<?php if($syntax_highlighting && filesize($_GET['fp']) < $size_syntax_highlighting && in_array($ext, $file4edit)) echo (1); else echo (0); ?>');" class="ico" alt="<?=$language[$langue]['EDIT_TITLE_SAVE']?>" />
        <?='<img src="'.$PWM_FILES.'images/sep.gif" alt="|"/>'?>
        &nbsp;
        <a href="<?=$HTTP_PATH?>" title="<?=$language[$langue]['EDIT_TITLE_VIEW']?>" target="blank_"><?='<img src="'.$PWM_FILES.'images/goTo.gif" class="ico" alt="'.$language[$langue]['EDIT_TITLE_VIEW'].'" /></a>'?>
        <a href="?type=list&root=<?=dirname($_GET['fp'])?>" title="<?=$language[$langue]['EDIT_TITLE_BACK']?>"><?='<img src="'.$PWM_FILES.'images/goBack.png" class="ico" alt="'.$language[$langue]['EDIT_TITLE_BACK'].'" /></a>'?>
      </td>
      <td width="02%" align="right">&nbsp;</td>
    </tr>
    </table>

    <div class="listing" <?php if($syntax_highlighting && filesize($_GET['fp']) < $size_syntax_highlighting && in_array($ext, $file4edit)) echo ('style="border: 1px inset darkgray;"'); ?>>

    <center>
     
    <?php
    if(@is_readable($_GET['fp'])) // anti-bug
    {
      $width = ($syntax_highlighting && filesize($_GET['fp']) < $size_syntax_highlighting && in_array($ext, $file4edit)) ? '' : 'cols="119"';
	  if (function_exists(mb_detect_encoding))
	  {
		if(mb_detect_encoding(utf8_decode(@file_get_contents($_GET['fp']))) == "UTF-8") // UTF8
			$file_code = utf8_decode(@file_get_contents($_GET['fp']));
		else
			$file_code = @file_get_contents($_GET['fp']); // ISO
	  }
	  else
		$file_code = @file_get_contents($_GET['fp']); // Default
      echo '<textarea id="code" name="code" style="height: 81%;" '.$width.'>'.htmlspecialchars($file_code).'</textarea>';
    }
    else
    {
      echo '<script type="text/javascript">alert("'.$language[$langue]['EDIT_ALERT_NOREAD'].'");</script>';
    }
    
    ?>
	</center>
    </div></form>
    
    <?php 
    if($syntax_highlighting && filesize($_GET['fp']) < $size_syntax_highlighting && in_array($ext, $file4edit))
    {
    
    ?>
    <script type="text/javascript"> 
      var editor = CodeMirror.fromTextArea('code', {
        parserfile: [<?php 
    if($ext == 'css') 
    { 
      echo ('"parsecss.js"');
    } 
    elseif($ext == 'js')
    { 
      echo ('"tokenizejavascript.js", "parsejavascript.js"');
    }
    elseif($ext == 'php')
    { 
      echo ('"parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js", "../contrib/php/js/tokenizephp.js", "../contrib/php/js/parsephp.js", "../contrib/php/js/parsephphtmlmixed.js"');
    } 
    elseif($ext == 'html' || $ext == 'htm')
    {
    echo ('"parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js", "parsehtmlmixed.js"');
    }
    ?>],
        stylesheet: [<?php 
    if($ext == 'js') 
      echo '"./PWM_files/codemirror/css/jscolors.css"';  
    elseif($ext == "css") 
      echo '"./PWM_files/codemirror/css/csscolors.css"'; 
    elseif ($ext == 'php') 
      echo '"./PWM_files/codemirror/css/xmlcolors.css", "./PWM_files/codemirror/contrib/php/css/phpcolors.css","./PWM_files/codemirror/css/xmlcolors.css", "./PWM_files/codemirror/css/jscolors.css", "./PWM_files/codemirror/css/csscolors.css"';
    elseif($ext == 'html' || $ext == 'htm')
      echo '"./PWM_files/codemirror/css/xmlcolors.css", "./PWM_files/codemirror/css/jscolors.css", "./PWM_files/codemirror/css/csscolors.css"';
    ?>],
        path: "./PWM_files/codemirror/js/",
    lineNumbers: true,
    textWrapping: false,
      });
    </script> 
    <?php } ?>
	<script type="text/javascript">
	function saveCode(fp, syn) {
		if(syn == 1)
			var code = editor.getCode();
		else
			var code = gid('code').value;
			
		code = code.replace(/&/g, "%%amp");
		code = code.replace(/\+/g, "%%plus");
		var xhr = null;
		
		if(window.XMLHttpRequest)
			xhr = new XMLHttpRequest();

		else if(window.ActiveXObject)
			xhr = new ActiveXObject("Microsoft.XMLHTTP");

		xhr.open("POST", "?type=edit&fp="+fp, true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("code="+code);

		xhr.onreadystatechange = function()
		{
		if(xhr.readyState == 4)
			if(xhr.responseText == 1)
				{
				alert("<?=$language[$langue]['EDIT_ALERT_YES']?>");
				}
			else{
				alert("<?=$language[$langue]['EDIT_ALERT_NO']?>");
				}
		}

		return false;
		}
    </script>
	
  </body>
</html>