<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
  <head>
    <script type="text/javascript" src="js/dept_xhr.js" charset="iso_8859-1"></script>
    
    <?php
      $sql = "SELECT `id_region` AS idr, `region` ".
        "FROM `region` ".
        "ORDER BY `id_region`;";
      $recherche = mysql_query($sql);
      $regions = array();
      $id = 0;
      while($ligne = mysql_fetch_assoc($recherche)){
        $regions[$ligne['idr']] = $ligne['region'];
      }
      ?>
    
  </head>
  
  <body style="font-family: verdana, helvetica, sans-serif; font-size: 85%">
    <form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="post" id="chgdept">
      <fieldset style="border: 3px double #333399">
        <legend>Sélectionnez une région</legend>
        <select name="region" id="region" onchange="getDepartements(this.value);">
          <option value="vide">- - - Choisissez une région - - -</option>
          <?php
      /* Construction de la première liste : on se sert du tableau PHP */
      foreach($regions as $nr => $nom)
      {
        ?> 
          <option value="<?php echo($nr); ?>"><?php echo($nom); ?></option>
        <?php
      }
      ?>
        </select>
        <span id="blocDepartements"></span><br />
        <input type="submit" name="ok" id="ok" value="Envoyer" />
      </fieldset> 
    </form>
  </body>
</html>


