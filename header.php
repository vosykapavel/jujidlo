<?php
$datumDnes = date('j.n.Y');
$datumZitra =  date('j.n.Y', strtotime("+1 day"));
$denDnes = NULL;
$class = "";
/*
  echo '<ul id="dnyTabs" role="tablist" class="nav nav-tabs">';
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
*/

echo  "<nav>";
echo    '<ul class="pagination">';

//echo '<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
foreach ($dny->getStareDny() as $key => $den) {
  $datum = $den->getDatum();
  $attr = "";
  if($datum == $datumDnes){
    $denDnes = $den;
    $class = 'active';
  }
    //data-date="'.$datum.'" data-date="'.$den->getNazevDne().'"
    echo "<li class=\"den $class\"><span>";
    echo ($denDnes == $den)?'DNES<span class="sr-only">(current)</span>':mb_substr($den->getNazevDne(), 0, 2);
    echo  '</span></li>';
    $class = "";
  //$den->getDatum()
}
foreach ($dny->getTyden() as $key => $den) {
  $datum = $den->getDatum();
  $attr = "";
  if($datum == $datumDnes){
    $denDnes = $den;
    $class = 'active';
  }
    echo "<li class=\"den $class\"><span>";
    echo ($denDnes == $den)?'DNES<span class="sr-only">(current)</span>':(($datumZitra == $datum)?'Zítra':mb_substr($den->getNazevDne(), 0, 2));
    echo  '</span></li>';
    $class = "";
  //$den->getDatum()
}
foreach ($dny->getPristiDny() as $key => $den) {
  $datum = $den->getDatum();
  $attr = "";
  if($datum == $datumDnes){
    $denDnes = $den;
    $class = 'active';
  }
    echo "<li class=\"den $class\"><span>";
    echo ($denDnes == $den)?'DNES<span class="sr-only">(current)</span>':mb_substr($den->getNazevDne(), 0, 2);
    echo  '</span></li>';
    $class = "";
  //$den->getDatum()
}
