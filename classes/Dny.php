<?php


class Dny implements JsonSerializable {
	private $dny = array();

	public function ulozit($den) {
		array_push($this->dny, $den);
	}

	public function getDny() {
		return $this->dny;
	}

	public function getTyden() {
	$r = array();
	if (!empty($this->dny)) {
		foreach ($this->dny as $key => $den) {//$key =>
			$datum = strtotime($this->dny[$key]->getDatum());
			if($datum > strtotime("this week -1 day") && $datum < strtotime("next week") ){
				array_push($r, $den);
			}
		}
	}
	return $r;
}
public function getStareDny(){
		$r = array();
		if(!empty($this->dny)){
			foreach ($this->dny as $key => $den) {//$key =>
				$datum = strtotime($this->dny[$key]->getDatum());
				if($datum <= strtotime("this week -1 day")){
					array_push($r, $den);
				}
			}
		}
		return $r;
	}
	public function getPristiDny(){
			$r = array();
			if(!empty($this->dny)){
				foreach ($this->dny as $key => $den) {//$key =>
					$datum = strtotime($this->dny[$key]->getDatum());
					if($datum >= strtotime("next week") ){
						array_push($r, $den);
					}
				}
			}
			return $r;
		}


	public function getDen($datum){
		if(!empty($this->dny)){
//      var_dump($this->dny[0]);
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