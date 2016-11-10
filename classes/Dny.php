<?php


class Dny implements JsonSerializable {
	private $dny = array();

	public function ulozit($den) {
		array_push($this->dny, $den);
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

	public function getDen($datum){
		if(!empty($this->dny)){
			foreach ($this->dny as $key => $den) {//$key =>
				if($this->dny[$key]->getDatum() == $datum){
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