<?php
$datumDnes = date('j.n.Y');
$denDnes = NULL;
?><ul id="dnyTabs" role="tablist" class="nav nav-tabs">

<?php
  $class = "";
  foreach ($dny->getDny() as $key => $den) {
    $datum = $den->getDatum();
    $attr = "";
    if($datum == $datumDnes){
      $denDnes = $den;
      $class = 'active';
    }
    echo '<li role="presentation" class="'.$class.'"><a href="#">'.$den->getNazevDne().' '.$den->getDatum()."</a></li>\n";
    $class = "";
  }
 ?>
</ul>
