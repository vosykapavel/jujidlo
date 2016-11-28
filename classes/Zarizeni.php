<?php
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Stravovací zařízení jako celek sdržující více jídelen.
 * @author pavel
 *
 * @Entity
 * @Table(uniqueConstraints={@UniqueConstraint(name="zarizeni_unique", columns={"nazev"})})
 **/
class Zarizeni {

	/** @Id @Column(type="integer") @GeneratedValue **/
	protected $id;

	/** @Column **/
	private $nazev;

	/** @OneToMany(targetEntity="Jidelna", mappedBy="zarizeni") 
	 *  @var Jidelna[]
	 **/
	protected $jidelny;
    
	public function __construct() {
		$this->jidelny = new ArrayCollection();
	}

	public function getNazev() {
		return $this->nazev;
	}
	
	public function setNazev($nazev) {
		$this->nazev = $nazev;
	}

	/**	@param Jidelna $jidelna **/
	public function addJidelna($jidelna) {
		$this->jidelny->add($jidelna);
		$jidelna->setZarizeni($this);
	}

	public function getJidelny() {
		return $this->jidelny;
	}    
	
}
