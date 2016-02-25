<?php
$datumDnes = date('j.n.Y');
$denDnes = NULL;
echo $datumDnes;
foreach ($dny->getDny() as $key => $den) {
  if($den->getDatum() == $datumDnes){
    $denDnes = $den;
  }
}
