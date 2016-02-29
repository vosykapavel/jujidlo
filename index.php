<?php
/*
Jujidlo si klade za cíl přinést víc user-friendly jídelníček
*/
mb_internal_encoding("UTF-8");
require('phpQuery.php');
//setlocale(LC_TIME, 'cs_CZ.utf8');

class Dny{
  private $dny = array();

  public function ulozit($den){
      array_push($this->dny, $den);
  }
  public function getDny(){
      return $this->dny;
  }
  public function getDen($datum){
    if(!empty($this->dny)){
//      var_dump($this->dny[0]);
      foreach ($this->dny as $key => $den) {//$key =>
        if($this->dny[$key]->getDatum() == $datum){
          return $den;
          break;
        }
      }
    }
    return false;
  }

}

class Den{
  private static $ceskeDny = array('Pondělí', 'Úterý', 'Středa', 'Čtvrtek', 'Pátek', 'Sobota', 'Neděle');
  private $jidla = array();
  private $datum = "";
  private $nazevDne = "";

  public function __construct($datum){
    $this->datum = $datum;
    $this->nazevDne = self::$ceskeDny[DateTime::createFromFormat('j.n.Y', $datum)->format('N')-1];

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
  public function getNazevDne(){
    return $this->nazevDne;
  }

}
/**
 *
 */
class Jidelna{
  private $jidla = array();

  public function ulozit($jidlo){
      array_push($this->jidla, $jidlo);
  }
  public function getJidla(){
    $dny = array();

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
//$studentska = file_get_contents("jidelnicky/15-10-29.html");

function parse($url = "http://menza.jcu.cz/Studentska.html"){
    $jidelnicek = file_get_contents($url);
    $jidelnicek = str_replace('&nbsp;', '', iconv('WINDOWS-1250', 'UTF-8', $jidelnicek));
    $doc = phpQuery::newDocumentHTML($jidelnicek);
    $rows = $doc["table  tr"];
    $radekDne = 0;
    $datumDne = "";
    $den = NULL;
    //echo $rows;
    foreach(pq($rows) as $row)
    {
      global $jidelna, $dny;


        $tr = pq($row);
        $datum = $tr['td:nth-child(1)']->text();

        // tady začínají jídla dne - datumem
        if(validateDate($datum)){
          $radekDne = 1;
          $datumDne = $datum;
          $uzExistuje = $dny->getDen($datum);
          if(!$uzExistuje){
            $den = new Den($datum);
            $dny->ulozit($den);
          }else{
            $den = $uzExistuje;
          }

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
  }
//      echo ucfirst(strftime('%A',DateTime::createFromFormat('j.n.Y', $tdDatum)->format('U')));
$jidelna = new Jidelna();
$dny = new Dny();
parse();
parse("http://menza.jcu.cz/Minutkova.html");
include "template.php";
