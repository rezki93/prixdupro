<?php
  
  //On inclut le contr�leur s'il existe et s'il est sp�cifi�
  if (!empty($_GET['rub']) && is_file('templates/'.$_GET['rub'].'.tpl'))
    $smarty->display('templates/'.$_GET['rub'].'.tpl');  
  else
    include 'controleurs/search.php';
   
?>