<?php
/*
Jujidlo si klade za cíl přinést víc user-friendly jídelníček
*/
require('phpQuery.php');
setlocale(LC_TIME, 'Czech');

class Dny{
  private $dny = [];

  public function ulozit($den){
      array_push($this->dny, $den);
  }
  public function getDny(){
      return $this->dny;
  }
  public function getDen($datum){
    foreach ($dny as $key => $den) {
      if($den->datum == $datum){
        return $den;
      }
    }
  }
}

class Den{
  private $jidla = [];
  private $datum = "";

  public function __construct($datum){
    $this->datum = $datum;
  }

  public function addJidlo($jidlo){
      array_push($this->jidla, $jidlo);
  }
  public function getJidla(){
      return $this->jidla;
  }
  public function getDatum(){
    return $this->datum;
  }
}
/**
 *
 */
class Jidelna{
  private $jidla = [];

  public function ulozit($jidlo){
      array_push($this->jidla, $jidlo);
  }
  public function getJidla(){
    $dny = [];

      return $this->jidla;
  }
}
class Jidlo
{

  function __construct($datum, $typJidla, $alergeny, $nazev)
  {
    $this->datum = $datum;
    $this->typJidla = $typJidla;
    $this->alergeny = $alergeny;
    $this->nazev = $nazev;
  }

  function getNazev(){
    return $this->nazev;
  }
  function getTypJidla(){
    return $this->typJidla;
  }
  function getAlergeny(){
    return $this->alergeny;
  }
  function listAlergens(){
    return implode(", ", $this->alergeny);
  }

}

function validateDate($date)
{
    $d = DateTime::createFromFormat('j.n.Y', $date);
    return $d && $d->format('j.n.Y') == $date;
}
$jidelna = new Jidelna();
$studentska = file_get_contents("http://menza.jcu.cz/Studentska.html");
//$studentska = file_get_contents("jidelnicky/15-10-29.html");
$studentska = str_replace('&nbsp;', '', iconv('WINDOWS-1250', 'UTF-8', $studentska));

$doc = phpQuery::newDocumentHTML($studentska);
//echo $studentska;
$rows = $doc["table  tr"];
//echo $rows;
//echo "$rows[0] ahoj \n";
/*
foreach ($doc["table tr"] as $tr) {
//    echo pq($tr)->html()." \n ";
//    $tr["td:first"]->text();
    if(validateDate(pq()->text())){
      echo $tr["td:first"]->html();
    }
}
*/
$radekDne = 0;
$datumDne = "";
$den = NULL;
$dny = new Dny();
//echo $rows;
foreach(pq($rows) as $row)
{

    $tr = pq($row);
    $datum = $tr['td:nth-child(1)']->text();

    // tady začínají jídla dne - datumem
    if(validateDate($datum)){
      $radekDne = 1;
      $datumDne = $datum;
      $den = new Den($datum);
      $dny->ulozit($den);
    }elseif($radekDne>0){
      $radekDne++;
    }
    if($radekDne>0){
      $typJidla = $tr['td:nth-child(2)']->text();
      $alergeny = explode(', ',$tr['td:nth-child(3)']->text());
      $nazev = $tr['td:nth-child(4)']->text();
      if($nazev != ""){
        $j = new Jidlo($datumDne, $typJidla, $alergeny, $nazev);
        $den->addJidlo($j);
      }
//      var_dump($jidelna->getJidla());
    }

//    $prvni =pq($row)->text();
}
//      echo ucfirst(strftime('%A',DateTime::createFromFormat('j.n.Y', $tdDatum)->format('U')));

include "template.php";
