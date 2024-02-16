<?php

require_once __DIR__ .'/../lib/Menu.php';
require_once __DIR__ .'/../lib/Dispatcher.php';

$messageErreurConnexion = "";



if(isset($_GET['menuPrincipal'])){
	$_SESSION['menuPrincipal']= $_GET['menuPrincipal'];
}
else
{
	if(!isset($_SESSION['menuPrincipal'])){
		$_SESSION['menuPrincipal']="accueil";
	}
}


$menuPrincipal = new Menu("MenuPrincipal");

$menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("Accueil", "accueil"));
$menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("Nos Produits", "listeProduits"));
$menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("Notre Histoire", "accueil"));
$menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("Nous Trouver", "accueil"));



$menuPrincipal = $menuPrincipal->creerMenu("menuPrincipal",$_SESSION['menuPrincipal']);



include_once Dispatcher::dispatch($_SESSION['menuPrincipal']);






