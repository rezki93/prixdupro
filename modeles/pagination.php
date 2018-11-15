<?php

/**
 * paginate($url, $param, $total, $current [, $adj]) appelée à chaque affichage de la pagination
 * @param string $url - URL ou nom de la page appelant la fonction, ex: 'index.php' ou 'http://example.com/'
 * @param string $param - paramètre à ajouter à l'URL, ex: '?page=' ou '&amp;p='
 * @param int $total - nombre total de pages
 * @param int $current - numéro de la page courante
 * @param int $adj (facultatif) - nombre de numéros de chaque côté du numéro de la page courante (défaut : 3)
 * @return string $pagination
 */
 
function paginate($url, $param, $total, $current, $adj=2)
{
  /* Déclaration des variables */
  $prev = $current - 1; // numéro de la page précédente
  $next = $current + 1; // numéro de la page suivante
  $n2l = $total - 1; // numéro de l'avant-dernière page (n2l = next to last)
 
  /* Initialisation : s'il n'y a pas au moins deux pages, l'affichage reste vide */
  $pagination = '';
 
  /* Sinon ... */
  if ($total > 1)
  {
    /* Concaténation du <div> d'ouverture à $pagination */
    $pagination .= "<div class=\"pagination2\">\n";
 
 
    /* ////////// Début affichage du bouton [précédent] ////////// */
    if ($current == 2) // la page courante est la 2, le bouton renvoit donc sur la page 1, remarquez qu'il est inutile de mettre ?p=1
      $pagination .= "<a href=\"{$url}\"><<</a>";
    elseif ($current > 2) // la page courante est supérieure à 2, le bouton renvoit sur la page dont le numéro est immédiatement inférieur
      $pagination .= "<a href=\"{$url}{$param}{$prev}\"><<</a>";
    else // dans tous les autres, cas la page est 1 : désactivation du bouton [précédent]
      $pagination .= '<span class="inactive"><<</span>';
    /* Fin affichage du bouton [précédent] */
 
 
    /* ///////////////
    Début affichage des pages, l'exemple reprend le cas de 3 numéros de pages adjacents (par défaut) de chaque côté du numéro courant
    - CAS 1 : il y a au plus 12 pages, insuffisant pour faire une troncature
    - CAS 2 : il y a au moins 13 pages, on effectue la troncature pour afficher 11 numéros de pages au total
    /////////////// */
 
    /* CAS 1 */
    if ($total < 7 + ($adj * 3))
    {
      /* Ajout de la page 1 : on la traite en dehors de la boucle pour n'avoir que index.php au lieu de index.php?p=1 et ainsi éviter le duplicate content */
      $pagination .= ($current == 1) ? '<span class="active">1</span>' : "<a href=\"{$url}\">1</a>"; // Opérateur ternaire : (condition) ? 'valeur si vrai' : 'valeur si fausse'
 
      /* Pour les pages restantes on utilise une boucle for */
      for ($i = 2; $i<=$total; $i++)
      {
        if ($i == $current) // Le numéro de la page courante est mis en évidence (cf fichier CSS)
        $pagination .= "<span class=\"active\">{$i}</span>";
        else // Les autres sont affichés normalement
        $pagination .= "<a href=\"{$url}{$param}{$i}\">{$i}</a>";
      }
    }
 
    /* CAS 2 : au moins 13 pages, troncature */
    else
    {
      /*
      Troncature 1 : on se situe dans la partie proche des premières pages, on tronque donc la fin de la pagination.
      l'affichage sera de neuf numéros de pages à gauche ... deux à droite (cf figure 1)
      */
      if ($current < 2 + ($adj * 2))
      {
        /* Affichage du numéro de page 1 */
        $pagination .= ($current == 1) ? "<span class=\"active\">1</span>" : "<a href=\"{$url}\">1</a>";
 
        /* puis des huit autres suivants */
        for ($i = 2; $i < 4 + ($adj * 2); $i++)
        {
        if ($i == $current)
          $pagination .= "<span class=\"active\">{$i}</span>";
          else
          $pagination .= "<a href=\"{$url}{$param}{$i}\">{$i}</a>";
        }
 
        /* ... pour marquer la troncature */
        $pagination .= ' ... ';
 
        /* et enfin les deux derniers numéros */
        $pagination .= "<a href=\"{$url}{$param}{$n2l}\">{$n2l}</a>";
        $pagination .= "<a href=\"{$url}{$param}{$total}\">{$total}</a>";
      }
 
      /*
      Troncature 2 : on se situe dans la partie centrale de notre pagination, on tronque donc le début et la fin de la pagination.
      l'affichage sera deux numéros de pages à gauche ... sept au centre ... deux à droite (cf figure 2)
      */
      elseif ( (($adj * 2) + 1 < $current) && ($current < $total - ($adj * 2)) )
      {
        /* Affichage des numéros 1 et 2 */
        $pagination .= "<a href=\"{$url}\">1</a>";
        $pagination .= "<a href=\"{$url}{$param}2\">2</a>";
 
        $pagination .= ' ... ';
 
        /* les septs du milieu : les trois précédents la page courante, la page courante, puis les trois lui succédant */
        for ($i = $current - $adj; $i <= $current + $adj; $i++)
        {
          if ($i == $current)
          $pagination .= "<span class=\"active\">{$i}</span>";
          else
          $pagination .= "<a href=\"{$url}{$param}{$i}\">{$i}</a>";
        }
 
        $pagination .= ' ... ';
 
        /* et les deux derniers numéros */
        $pagination .= "<a href=\"{$url}{$param}{$n2l}\">{$n2l}</a>";
        $pagination .= "<a href=\"{$url}{$param}{$total}\">{$total}</a>";
      }
 
      /*
      Troncature 3 : on se situe dans la partie de droite, on tronque donc le début de la pagination.
      l'affichage sera deux numéros de pages à gauche ... neuf à droite (cf figure 3)
      */
      else
      {
        /* Affichage des numéros 1 et 2 */
        $pagination .= "<a href=\"{$url}\">1</a>";
        $pagination .= "<a href=\"{$url}{$param}2\">2</a>";
 
        $pagination .= ' ... ';
 
        /* puis des neufs dernières */
        for ($i = $total - (2 + ($adj * 2)); $i <= $total; $i++)
        {
          if ($i == $current)
            $pagination .= "<span class=\"active\">{$i}</span>";
          else
            $pagination .= "<a href=\"{$url}{$param}{$i}\">{$i}</a>";
        }
      }
    }
    /* Fin affichage des pages */
 
 
    /* ////////// Début affichage du bouton [suivant] ////////// */
    if ($current == $total)
      $pagination .= "<span class=\"inactive\">>></span>\n";
    else
      $pagination .= "<a href=\"{$url}{$param}{$next}\">>></a>\n";
    /* Fin affichage du bouton [suivant] */
 
 
    /* </div> de fermeture */
    $pagination .= "</div>\n";
  }
 
  /* Fin de la fonction, renvoi de $pagination au programme */
  return ($pagination);
}
?>