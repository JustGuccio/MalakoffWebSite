<?php

class Dispatcher{
	
	public static function dispatch($unMenuP){
		$unMenuP = "controleur" . ucfirst($unMenuP) ;
		$unMenuP .= ".php";
		$unMenuP = "controller/" . $unMenuP;
		return $unMenuP ;
	}
}

