<?php
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Jidelna je místo, kde se vydává jídlo.
 * 
 * @Entity
 * @Table(uniqueConstraints={@UniqueConstraint(name="jidelna_unique", columns={"nazev"})})
 * @author pavel
 */
class Jidelna {

	/** @Id @Column(type="integer") @GeneratedValue **/
	protected $id;

	/** @Column **/
	private $nazev;

	/** 
	 *  @ManyToOne(targetEntity="Zarizeni", inversedBy="jidelny")
	 *  @var Zarizeni
	 **/
	protected $zarizeni;

	/**
	 *  @OneToMany(targetEntity="Jidlo", mappedBy="jidelna") 
	 *  @var Jidlo[]
	 **/
	protected $jidla;
    
	public function __construct() {
		$this->jidla = new ArrayCollection();
	}

	public function getNazev() {
		return $this->nazev;
	}
	
	public function setNazev($nazev) {
		$this->nazev = $nazev;
	}

	public function getZarizeni() {
		return $this->zarizeni;
	}
	
	public function setZarizeni($zarizeni) {
		$this->zarizeni = $zarizeni;
	}

	/**	@param Jidlo $jidlo **/
	public function addJidlo($jidlo) {
		$this->jidla->add($jidlo);
		$jidlo->setJidelna($this);
	}

	public function getJidla() {
		return $this->jidla;
	}

	public function getDny() {
		return $this->dny;
	}

	public function getTydenRelative($tyden = 0) {
		$now = new DateTime('NOW');
		$tyden += (int) $now->format('W');

		$r = array();
		if (!empty($this->dny)) {
			foreach ($this->dny as $key => $den) {
				$datum = new DateTime($this->dny[$key]->getDatum());
				if ((int) $datum->format('W') == $tyden){
					array_push($r, $den);
				}
			}
		}
		return $r;
	}

	public function getDen($datum) {
			if (!empty($this->dny)) {
			foreach ($this->dny as $key => $den) {
				if ($this->dny[$key]->getDatum() == $datum) {
					return $den;
				}
			}
		}
		return false;
	}
	
	public function jsonSerialize() {
		return $this->dny;
	}
    
}
