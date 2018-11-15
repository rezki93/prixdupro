<?php 
require_once 'libs/Swift-4.1.0/lib/swift_required.php';
require 'modeles/annonce.class.php';
  
function get_all_users() 
{    
	$link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis PHP 5.3
	$users = array();
	$chaine="SELECT * FROM USERS ORDER BY id_user DESC";
	$req = mysqli_query($link,$chaine);
	while ($data = mysqli_fetch_assoc($req))
		$users[] = $data;
	return $users;
}
function get_user($ref)
{    
	$link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis PHP 5.3
  $user = array();
    if (is_numeric($ref)) 
    {
    $chaine="SELECT * FROM USERS WHERE id_user = ".$ref;
    $req = mysqli_query($link, $chaine);
    while ($data = mysqli_fetch_assoc($req))
      $user = $data; 
    }
   return $user;
} 
function supprimer_user($ref)
{    
	$link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis PHP 5.3
	$chaine="DELETE FROM USERS WHERE USERS.id_user ='".$ref."'";
	$req = mysqli_query($link,$chaine);
}
function get_annonces_en_attente(){    
	$link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis PHP 5.3
	$annonces = array();
	$chaine="SELECT * FROM ANNONCES WHERE etat_annonce = 'en attente'";
	$req = mysqli_query($link,$chaine);
	while ($data = mysqli_fetch_assoc($req))
		$annonces[] = $data; 
	return $annonces;
}

function get_annonces(){    
	$link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis PHP 5.3
	$annonces = array();
	$chaine="SELECT * FROM ANNONCES, CATEGORIES WHERE ANNONCES.cat_annonce = CATEGORIES.id_categorie order by id_annonce desc";
	$req = mysqli_query($link,$chaine);
		while ($data = mysqli_fetch_assoc($req))
	$annonces[] = $data; 
	return $annonces;
}
function valider_annonce($ref){    
	$link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis PHP 5.3
	$chaine="UPDATE ANNONCES SET etat_annonce = 'validee' WHERE id_annonce = '".$ref."'";  
	$req = mysqli_query($link,$chaine);
	envoyer_email_annonceur($ref,"acceptee");
}

function refuser_annonce($ref){    
	$link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis PHP 5.3
	$chaine="UPDATE ANNONCES SET etat_annonce = 'refusee' WHERE id_annonce = '".$ref."'";  
	$req = mysqli_query($link,$chaine);
	envoyer_email_annonceur($ref,"refusee");
}

function renouveler_annonce($ref){    
	$link = new mysqli(SERVER, USER, MDP, NAMEBDD); //depuis PHP 5.3
	$chaine="UPDATE ANNONCES SET etat_annonce = 'validee' , date_annonce = now() WHERE id_annonce = '".$ref."'";  
	$req = mysqli_query($link,$chaine);
}

  function envoyer_email_annonceur($ref,$moderation = "acceptee") {
    $annonce = new Annonce();
    $annonce->recuperer_une_annonce($ref);
    $email = $annonce->mail_user;
    $url = 'http://'.$_SERVER['SERVER_NAME'].'/index.php?page=annonce&ref='.$ref;
    
    $msg = "Bonjour,<br/>";
    if($moderation == "acceptee")
      $msg .= "Votre annonce a &eacute;t&eacute; valid&eacute; par nos &eacute;quipes de mod&eacute;rateurs et est accessible &agrave; cette url : $url";
    else
      $msg .= "Votre annonce a &eacute;t&eacute; refus&eacute;e par nos &eacute;quipes de mod&eacute;rateurs. Vous ne respectez pas les r&egrave;gles de diffusion.<br/>Potentielles raisons du refus : Risque d'arnaques, Annonce illegale ...";  
    $msg .= "<br/><br/>Nous vous remercions d'utiliser prixdupro.fr.<br/><br><br><br>";  

    
    $msg .= "<a href='".$_SERVER['HTTP_HOST']."'><img src='http://www.prixdupro.fr/images/banniere prixdupro.gif' /></a>";
    $subject = "Annonce $moderation par les moderateurs prixdupro.fr";
    $nom = "Administrateur prixdupro.fr";
    $from = "donotreply@prixdupro.fr" ;
    

    $message = Swift_Message::newInstance()
    ->setSubject($subject)
    ->setFrom(array($from => $nom))
    ->setTo(array($email))
    ->setBody($msg, 'text/html')
    ;
    $transport = Swift_MailTransport::newInstance();
    $mailer = Swift_Mailer::newInstance($transport);
    $valid = $mailer->send($message);      
  }  
  
  
/*Connexion admin */
if( (isset($_POST['con_login_admin']) && ($_POST['con_login_admin'] == "rezki.kies@gmail.com") && isset($_POST['con_password_admin']) && ($_POST['con_password_admin'] == "000000")) || (isset($_SESSION['admin']) && ($_SESSION['admin']== "connecte")) ){
  $_SESSION['admin']= "connecte";
  $_SESSION['con_login_admin']= "rezki";
}else{
  $_SESSION['admin']= "deconnecte";
}

if(isset($_GET['action']) && ($_GET['action'] == "deconnexion")){  
  session_unset ();  
  session_destroy ();
  header("Location: index.php?page=dashboard");
}

?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <style type="text/css">
      input {border: solid 1px #B3C4C9;height:25px;background-color: white;padding: 3px;font-family: Arial;font-size: 13px;border-radius: 5px;margin: 1px;}
      input[type=text] {width:150px;}
      input:hover {background-color: #FFC;}
      input[type=submit]{cursor:pointer}
      a{text-decoration:none}
    </style>
  </head>
<?php
if(isset($_SESSION['admin']) == false || ($_SESSION['admin']) == "deconnecte"){
  $_SESSION['admin']= "deconnecte";
?>
  
  <body style="margin:auto;width:800px;font-family:Arial;">
    <h2 align="center" style="color:Green">Dashboard Prixdupro</h2>
      <div style="padding:60px;border:1px solid gray; border-radius:10px;background-color:#e7f7f7;">
        
    <form method="POST" name="connexion_admin" action="./index.php?page=dashboard">
          <div style="float:left">
            <div style="margin-left:0px">
              <div style="float:left;margin: 3px;width:80px">Login/email :</div>
              <input type="text" class="zone-saisie" style="font-size: 1em;" id="con_login_admin" name="con_login_admin" />
            </div>
          </div>

          <div style="float:left">
            <div style="margin-left:20px">
              <div style="float:left;margin: 3px;width:90px">Mot de passe :</div>
              <input type="password" class="zone-saisie" style="font-size: 1em;" id="con_password_admin" name="con_password_admin" />
            </div>
          </div>
          
          <input type="submit" id="connexion_button2" value="Connexion" style="width: 100px;margin-left:20px"/>
      <?php
          if( isset($_REQUEST['action'])  && isset($_REQUEST['ref_annonce']) ){
            ?>
              <input type="hidden" id="action" name="action" <?php echo ' value="' . $_REQUEST['action'] . '"'; ?> />
              <input type="hidden" id="ref_annonce" name="ref_annonce" <?php echo ' value="' . $_REQUEST['ref_annonce'] . '"'; ?> />                  
            <?php
          }
       ?>
         
      
        </form>
      </div>
    </body>

<?php
}
else{
  if( isset($_REQUEST['action']) && ($_REQUEST['action']== "valider_annonce") && (isset($_REQUEST['ref_annonce'])) ){
    valider_annonce($_REQUEST['ref_annonce']);
    header("Location: index.php?page=dashboard");
  }
  
  if( isset($_REQUEST['action']) && ($_REQUEST['action']== "refuser_annonce") && (isset($_REQUEST['ref_annonce'])) ){
    refuser_annonce($_REQUEST['ref_annonce']);
    header("Location: index.php?page=dashboard");
  }
  
  if( isset($_REQUEST['action']) && ($_REQUEST['action']== "renouveler_annonce") && (isset($_REQUEST['ref_annonce'])) ){
    renouveler_annonce($_REQUEST['ref_annonce']);
    header("Location: index.php?page=dashboard");
  }
  
  $tab_users = get_all_users();
  $tab_annonces = get_annonces(); 
?>

    <head>
    <!-- Autres -->
    <script src="includes/media/js/complete.js" type="text/javascript" ></script>
    <script src="includes/media/js/jquery.validate.js" type="text/javascript"></script>
    <link href="includes/media/css/demo_validation.css" rel="stylesheet" type="text/css" />
    
    <!-- jQuery -->
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/cupertino/jquery-ui.css" rel="stylesheet" type="text/css"/>
    
    <script src="includes/media/js/jquery-ui.js" type="text/javascript"></script>
      
    
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="includes/datatables/media/css/jquery.dataTables.css" />
    <link rel="stylesheet" type="text/css" href="includes/datatables/media/css/jquery.dataTables_themeroller.css" />
    <link rel="stylesheet" type="text/css" href="includes/datatables/media/css/demo_table.css" />
    <script src="includes/datatables/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="includes/datatables/media/js/jquery.dataTables.js" type="text/javascript" ></script>
    
    <!-- TableTools -->
    <script src="includes/datatables/extras/TableTools/media/js/TableTools.js"></script>
    <script src="includes/datatables/extras/TableTools/media/js/TableTools.min.js"></script>
    <script src="includes/datatables/extras/TableTools/media/js/ZeroClipboard.js"></script>
    <link href="includes/datatables/extras/TableTools/media/css/TableTools.css" rel="stylesheet" type="text/css"/>

    
    
      <script language="javascript" type="text/javascript">
          $(document).ready(function () {
            //$("#table_users").dataTable().makeEditable();
      
      
            $("#table_users").dataTable({
          "bJQueryUI": true,
          "iDisplayLength": 25,
          "sPaginationType": "full_numbers",
          "sDom": 'T<"clear"><"H"lfr>t<"F"ip>',
          "aaSorting": [[0,'desc']],
          "oTableTools": {
             "sSwfPath": "includes/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf",
             "aButtons": [
                    "copy",
                    "print",
                    "xls",
                    "csv"
                  ]
          }
        });
      
      
      
            $("#table_annonces").dataTable({
        "bJQueryUI": true,
        "iDisplayLength": 50,
        "sPaginationType": "full_numbers",
        "sDom": 'T<"clear"><"H"lfr>t<"F"ip>',
        "aaSorting": [[0,'desc']],
        "oTableTools": {
           "sSwfPath": "includes/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf",
           "aButtons": [
                  "copy",
                  "print",
                  "xls",
                  "csv"
                ]
        }
      });
      
          });
      </script>
    </head>

  <body style="max-width:1300px; margin:auto;font-family: arial;">    
  
    <div style="margin:auto;border:1px solid gray; border-radius:10px;background-color:#e7f7f7;height:90px;">
      <a href="./index.php?page=dashboard"><h1 style="color:blue;margin:25px 0 0 20px">DashBoard Prixdupro</h1> </a>
    </div>
    
    <div style=" width: 300px; height:30px; float:left; margin: 0 0 0px 0;">
      
      <div style="float:left;">
        <a href="./index.php?page=dashboard&action=deconnexion"><input type="submit" value="Deconnexion" /></a>
      </div>
      <div style="float:left;margin:5px"><?php echo 'Bonjour '.$_SESSION['con_login_admin']?></div>
    </div>     
    
    <div style="margin:auto;">
      <table id="table_users" style="float:left">
        <thead>
          <tr>
            <th>Identifiant</th>
            <th>Email</th>
            <th>Prenom</th>
            <th>Nom</th>
            <th>Adresse</th>
            <th>Ville</th>
            <th>Departement</th>
            <th>Date d'inscription</th>
            <th>IP</th>
          </tr>
        </thead>
        <tbody>
    
<?php
        
        foreach($tab_users as $u){
          echo '
            <tr id="17">
              <td>'.$u['id_user'].'</td>
              <td>'.$u['mail_user'].'</td>
              <td>'.$u['prenom_user'].'</td>
              <td>'.$u['nom_user'].'</td>
              <td>'.$u['adresse_user'].'</td>
              <td>'.$u['ville_user'].'</td>
              <td>'.$u['dep_user'].'</td>
              <td>'.$u['date_inscription_user'].'</td>
              <td>'.$u['ip_user'].'</td>
            </tr>
          ';
        }  
?>
        </tbody>
      </table>
    </div>
    
    
    <div style="margin: auto;margin-top: 30px;">
      <table id="table_annonces" style="">
        <thead>
          <tr>
            <th>Identifiant</th>
            <th>Annonceur</th>
            <th>Titre</th>
            <th>Prix</th>
            <th>Categorie</th>
            <th>Date</th>
            <th>Localisation</th>
            <th>A débattre</th>
            <th>Etat</th>
            <!--<th>photos_annonce</th>-->
            <th>Description</th>
            <th>Lien</th>
            <th>Validation</th>
          </tr>
        </thead>
        <tbody>
  <?php    
        foreach($tab_annonces as $a){
          echo '
            <tr id="17">
              <td>'.$a['id_annonce'].'</td>
              <td>'.$a['id_user'].'</td>
              <td style="color:blue">'.$a['titre_annonce'].'</td>
              <td>'.$a['prix_annonce'].'</td>
              <td>'.$a['nom_categorie'].'</td>
              <td>'.$a['date_annonce'].'</td>
              <td>'.$a['map_annonce'].'</td>
              <td>'.$a['debat_annonce'].'</td>';
          if($a['etat_annonce'] == "validee")
             echo '<td style="color:green">';
          else if($a['etat_annonce'] == "en attente")
             echo '<td style="color:orange">';
          else echo '<td style="color:red">';
          
          echo $a['etat_annonce'].'</td>
              <!--<td>'.$a['photos_annonce'].'</td>-->
              <td style=\'font-size: 13px;\'>'.substr($a['desc_annonce'],0,50).'</td>
                           <td><a href="./annonce/'.$a['id_annonce'].'">voir</a></td>
              ';
              if(($a['etat_annonce'] == "en attente") || ($a['etat_annonce'] == "")){
                echo '<td>
                      <a href="./index.php?page=dashboard&action=valider_annonce&ref_annonce='.$a['id_annonce'].'">valider</a>
                      <br>
                      <a href="./index.php?page=dashboard&action=refuser_annonce&ref_annonce='.$a['id_annonce'].'">refuser</a>
                  
                  </td>';
              }
              else if($a['etat_annonce'] == "validee"){
                echo '<td>
                    <a href="./index.php?page=dashboard&action=refuser_annonce&ref_annonce='.$a['id_annonce'].'">refuser</a>
                  </td>';
              }
              else if($a['etat_annonce'] == "refusee"){
                echo '<td>
                    <a href="./index.php?page=dashboard&action=valider_annonce&ref_annonce='.$a['id_annonce'].'">valider</a>
                  </td>';
              }
        else if($a['etat_annonce'] == "expiree"){
                echo '<td>
                    <a href="./index.php?page=dashboard&action=renouveler_annonce&ref_annonce='.$a['id_annonce'].'">renouveler</a>
                  </td>';
              }
              else{
                echo '<td></td>';
              }
          echo '
            </tr>
          ';
        }  
  echo '
        </tbody>
      </table> 
    </div>
</body>

';
}
?>
</html>