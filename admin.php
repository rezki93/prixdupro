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
  Fichier: pwm.php
  Dernière modification: 10/06/2010
  Copyright (C) SimpleGeek 2010-2011
*/
  
#######################
##     SECURITE      ##
#######################

  $logged = TRUE;

#######################
##     INCLUDES      ##
#######################

  require_once ("./PWM_files/inc/config.inc.php");
  require_once ($PWM_FILES."inc/functions.inc.php");
  require_once ($PWM_FILES."inc/language.inc.php");
  
#######################
##    COOKIE: SET    ##
#######################

// Si le pass est vide ou NULL, le script ne marche pas || If the pass is empty or NULL, the script doesn't work
  if(EMPTY($password) || $password == NULL)
  {
  
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
    
  </head>

  <body>
        <div class="erreur"><br />
          <strong><?=$language[$langue]['PWM_ERROR_WELCOME']?></strong><br /><br /><br />

          <p style="margin:12px;"><?=$language[$langue]['PWM_ERROR_CONTENT']?><br /><br /><br />
            
            <?=$language[$langue]['PWM_LICENCE_GPL']?><br />
            <br />
            <?=$language[$langue]['PWM_COPYRIGHT']?><br />

          </p>

        </div>

        <table class="foot" width="99%" cellpadding="10">
          <tr>
            <td width="70%" align="left"><?=$language[$langue]['PWM_ERROR_PASS']?></td>
          </tr>
        </table>

      </center>
    </form>

  </body>
  
</html>

<?php

  }

// Si le password est le bon || If the password is the good one
  elseif(isset($_POST['password']) && $_POST['password'] == $password)
  {
    $timestamp_expire = time() + 3600*24*7; // 7 jours || 7 days
    setcookie('pwm', md5($_POST['password']), $timestamp_expire);
    redirect('?');
  }

/**
 * Si il existe le cookie du password et égale à celui de la config
 * If there is already a cookie of the password and if it's the same as the config 
 */
 
  elseif(isset($_COOKIE['pwm']) && ($_COOKIE['pwm'] == md5($password)))
  {
    include_once ($PWM_FILES."inc/content.inc.php");
  
  // On envoi le ping si il est activé || If activated, we send the ping every 30s
  if($ping) { ?>
  
  <script type="text/javascript">
      // Ping le PWM
      function ping() {

      var xhr = null;

      if(window.XMLHttpRequest) xhr = new XMLHttpRequest();
      else if(window.ActiveXObject) xhr = new ActiveXObject("Microsoft.XMLHTTP");

      xhr.open("GET", "?type=whois", true);
      xhr.send(null);
      xhr.onreadystatechange = function()
        {
        if(xhr.readyState == 4) return true;
        }
      }

      setInterval("ping();", 30000);
      ping();
    </script>
      
<?php }
  }
  
  else
  {
  
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
    
  </head>

  <body>
  
    <form action="?" method="post" name="login">
      <center>
        <table class="head" width="99%" cellpadding="2">
          <tr>
            <td width="70%" align="left">&nbsp;<?=$language[$langue]['PWM_CONNECT_FTP']?> : &nbsp;<input type="password" name="password" size="26" class="up" value="yourPassword" onfocus="if(this.value == 'yourPassword'){this.value = '';}" onblur="if(this.value == ''){this.value = 'yourPassword';}" />&nbsp;<input type="submit" value="Connect !" class="go"/></td>
            <td width="29%" align="right"><i># by <?=$author?>&nbsp;~</i></td>
            <td width="01%" align="left">&nbsp;</td>
          </tr>
        </table>

        <div class="global"><br />
          <strong><?=$language[$langue]['PWM_INDEX_WELCOME']?></strong><br /><br /><br />

          <p style="margin:12px;">
            <?=$language[$langue]['PWM_INDEX_CONTENT']?>
          <br /><br />
            
            <?=$language[$langue]['PWM_LICENCE_GPL']?><br />
            <br />
            <?=$language[$langue]['PWM_COPYRIGHT']?><br />

          </p>

        </div>

        <table class="foot" width="99%" cellpadding="10">
          <tr>
            <td width="70%" align="left"><?=$language[$langue]['PWM_INDEX_PASS']?> <?=$HOST?></td>
          </tr>
        </table>

      </center>
    </form>

  </body>
  
</html>

<?php

  }
  
?>