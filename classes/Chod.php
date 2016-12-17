<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * @author pavel
 */

/**
 * Description of Chod
 * @Entity
 */
class Chod {
    /**
	 * @Id
	 * @Column(type="integer")
	 * @GeneratedValue
	 */
    protected $id;

	/** 
	 * @Column
	 */
	protected $nazev;

	/** 
	 * @Column(type="datetime")
	 * @var DateTime
	 */
	protected $denniVydejOd;

	/** 
	 * @Column(type="datetime")
	 * @var DateTime
	 */
	protected $denniVydejDo;

	/**
	 * @Column
	 */
	protected $cena;

	/** 
	 *  @ManyToOne(targetEntity="Jidelna", inversedBy="chody")
	 *  @var Jidelna
	 */
	protected $jidelna;

	
	public function getId() {
		return $this->id;
	}

	public function getNazev() {
		return $this->nazev;
	}

	public function setNazev($nazev) {
		$this->nazev = $nazev;
	}
	public function getDenniVydejOd() {
		return $this->denniVydejOd;
	}

	public function getDenniVydejDo() {
		return $this->denniVydejDo;
	}

	public function getCena() {
		return $this->cena;
	}

	public function getJidelna() {
		return $this->jidelna;
	}

	public function setDenniVydejOd(DateTime $denniVydejOd) {
		$this->denniVydejOd = $denniVydejOd;
	}

	public function setDenniVydejDo(DateTime $denniVydejDo) {
		$this->denniVydejDo = $denniVydejDo;
	}

	public function setCena($cena) {
		$this->cena = $cena;
	}

	public function setJidelna(Jidelna $jidelna) {
		$this->jidelna = $jidelna;
	}



}
