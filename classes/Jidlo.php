<?php

class Jidlo
{
	private static $pizza = array(
			array('nazev' => 'Pizza šunková'),
			array('nazev' => 'Pizza šunková se žampiony'),
			array('nazev' => 'Pizza šunková s ananasem'),
			array('nazev' => 'Pizza šunková s brokolicí'),
			array('nazev' => 'Pizza salámová'),
			array('nazev' => 'Pizza zeleninová'),
			array('nazev' => 'Pizza sýrová'),
			array('nazev' => 'Pizza špenátová se zakysanou smetanou'),
			array('nazev' => 'Pizza špenátová se šunkou a smetannou'),
			array('nazev' => 'Pizza tuňáková'),
			array('nazev' => 'Pizza s česnekem a sýrem'),
	);

	public static function getPizza() {
		return self::$pizza;
	}

	function __construct($typJidla, $alergeny, $nazev)
	{
		$this->nazev = $nazev;
		$this->typJidla = $typJidla;
		$this->alergeny = $alergeny;
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