<?php
$datumDnes = date('j.n.Y');
$denDnes = NULL;

  echo '<ul id="dnyTabs" role="tablist" class="nav nav-tabs">';
  $class = "";
  foreach ($dny->getDny() as $key => $den) {
    $datum = $den->getDatum();
    $attr = "";
    if($datum == $datumDnes){
      $denDnes = $den;
      $class = 'active';

      echo '<li role="presentation" class="'.$class.'"><a href="#">';
      echo ($denDnes == $den)?'DNES':mb_substr($den->getNazevDne(), 0, 2);
      echo "</a></li>\n";
      $class = "";
    }
    //$den->getDatum()
  }
  echo "</ul>";
