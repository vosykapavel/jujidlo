<div class="panel-group col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
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
            $fotacek = '<span class="glyphicon glyphicon-camera fotacek" onclick="takePhoto()" aria-hidden="true"></span>';
              echo "<li class=\"list-group-item $class\">".$typ.": ".$jidlo->getNazev().$fotacek."</li>\n";
          }
         ?>
      </ul>
    </div>
  </div>
<?php
}
?>
  <br>
  <div class="panel panel-default">
  <div class="panel-heading">
      <span class="panel-title">A jaká že ta pizza může být?</span>
    <div style="float:right">
      <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
      <span>Minutková&nbsp;</span>
      <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
      <span>9:30 - 13:30</span>
    </div>
</div>
  <div id="collapse1" class="panel-collapse collapse in">
    <ul class="list-group">
      <?php

        foreach ($den->getPizza() as $key => $p) {
          $fotacek = '<span class="glyphicon glyphicon-camera fotacek fotacek-pizza" onclick="takePizzaPhoto()" aria-hidden="true"></span>';
            echo "<li class=\"list-group-item\">".$p["nazev"].$fotacek."</li>\n";
          }
       ?>
    </ul>
  </div>
</div>

</div>
