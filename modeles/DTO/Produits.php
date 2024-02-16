<?php
class Produits{
    private array $produits;


    public function __construct($array){
		if (is_array($array)) {
			$this->produits = $array;
		}
	}

	public function getProduits(){
		return $this->produits;
	}

	public function chercheProduits($unID){
		$i = 0;
		while ($unID != $this->produits[$i]->getID() && $i < count($this->produits)-1){
			$i++;
		}
		if ($unID == $this->produits[$i]->getID()){
			return $this->produits[$i];
		}
	}
}