<div class="panel-group">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" href="#collapse1">STUDENTSKÁ</a>
      </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse in">
      <ul class="list-group">
        <?php
          foreach ($denDnes->getJidla() as $key => $jidlo) {
              echo "<li class=\"list-group-item\">".htmlspecialchars($jidlo->getTypJidla().": ".$jidlo->getNazev().(($jidlo->getAlergeny()=="")?" (ALERGENY: ".$jidlo->listAlergens().")":""))."</li>\n";
          }
         ?>
      </ul>
    </div>
  </div
</div>

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
