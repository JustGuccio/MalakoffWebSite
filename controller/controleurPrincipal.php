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

$menuPrincipalImg = new Menu("MenuPrincipalImage");
$menuPrincipal = new Menu("MenuPrincipal");
$menuPrincipalImg->ajouterComposant($menuPrincipalImg->creerItemLien("<img src='images/Logo3.png'>", "accueil"));
$menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("Accueil", "accueil"));
$menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("Nos Produits", "listeProduits"));
$menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("Poules", "poules"));
$menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("Actualité", "actualite"));
$menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("Le domaine", "domaine"));
$menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien("Nous Contacter", "info"));



$menuPrincipal = $menuPrincipal->creerMenu("menuPrincipal",$_SESSION['menuPrincipal']);
$menuPrincipalImg = $menuPrincipalImg->creerMenu("menuPrincipal",$_SESSION['menuPrincipal']);



include_once Dispatcher::dispatch($_SESSION['menuPrincipal']);






