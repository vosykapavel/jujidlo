<div class="panel-group">
  <?php
foreach ($dny->getDny() as $key => $den) {
  $datum = $den->getDatum();
  $attr = "";
/*
    echo "<li class=\"$class\"><span>";
    echo ($denDnes == $den)?'DNES<span class="sr-only">(current)</span>':mb_substr($den->getNazevDne(), 0, 2);
    echo  '</span></li>';
    $class = "";
    */
  //$den->getDatum()
?>
  <div class="panel panel-default jidelnicek<?=($datum == $datumDnes)?' show':''?>">
    <div class="panel-heading">
      <h4 class="panel-title">
        STUDENTSKÁ + MINUTKOVÁ
      </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse in">
      <ul class="list-group">
        <?php
        $css = array(
          'Oběd 5' => 'bezobjednavkova',
          'Oběd 6' => 'bezobjednavkova',
          'Minutka 1' => 'minutka',
          'Minutka 2' => 'minutka',
          'Specialita 1' => 'specialita',

        );
          foreach ($den->getJidla() as $key => $jidlo) {
            // (($jidlo->getAlergeny()!="")?" (ALERGENY: ".$jidlo->listAlergens().")":"").
            $typ = $jidlo->getTypJidla();
            $class = isset($css[$typ])?$css[$typ]:'';

              echo "<li class=\"list-group-item $class\">".$typ.": ".$jidlo->getNazev()."</li>\n";
          }
         ?>
      </ul>
    </div>
  </div>
<?php
}
?>
</div>
<!--
<div class="panel-group">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" href="#collapse2">PIZZA</a>
      </h4>
    </div>
    <div id="collapse2" class="panel-collapse collapse">
      <ul class="list-group">
        <li class="list-group-item">One</li>
        <li class="list-group-item">Two</li>
        <li class="list-group-item">Three</li>
      </ul>
      <div class="panel-footer">Footer</div>
    </div>
  </div>
</div>
-->
