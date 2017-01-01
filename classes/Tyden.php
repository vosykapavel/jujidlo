<?php

/**
 * Value object holding week days in one place.
 *
 * @author pavel
 */
class Tyden implements JsonSerializable {
	private $cisloTydne;
	/* @var Den[] */
	private $dny = [];
	
	/**
	 * 
	 * @param Den[] $dny
	 * @return Tyden[]
	 */
	public static function getTydnyZeDnu($dny) {
		/* @var Tyden[] */
		$tydny = [];
		foreach ($dny as $keyD => $den) {
			$cisloTydne = (int) $den->getDatum()->format('W');

			/* @var Tyden */
			$tydenDne = null;
			/* @var $tyden Tyden */
			foreach ($tydny as $keyT => $tyden) {
				if ($tyden->getCisloTydne() == $cisloTydne) {
					$tydenDne = $tyden;
					break;
				}
			}
			if ($tydenDne == null) {
				$tydenDne = new Tyden();
				$tydenDne->setCisloTydne($cisloTydne);
				array_push($tydny, $tydenDne);
			}
			$tydenDne->addDen($den);
		}
		return $tydny;
	}
	
	public function getCisloTydne() {
		return $this->cisloTydne;
	}

	public function getDny() {
		return $this->dny;
	}

	public function setCisloTydne($cisloTydne) {
		$this->cisloTydne = $cisloTydne;
		return $this;
	}

	public function setDny($dny) {
		$this->dny = $dny;
		return $this;
	}

	public function addDen($den) {
		array_push($this->dny, $den);
	}

	public function jsonSerialize() {
		return [
			"cisloTydne" => $this->getCisloTydne(),
			"dny" => $this->getDny(),
		];
	}

}
