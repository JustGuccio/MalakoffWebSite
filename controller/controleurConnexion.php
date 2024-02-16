<?php

require_once __DIR__ .'/../lib/Formulaire.php';


if(!isset($_SESSION['statut']) || empty($_SESSION['statut'])){

    $formConnexion = new Formulaire("post","index.php?menuPrincipal=panel","formuCo","formuCo");

    $formConnexion->ajouterComposantLigne($formConnexion->creerLabel("Login","login"),1);
    $formConnexion->ajouterComposantLigne($formConnexion->creerInputTexte("login","log",0,false,"",false),2);
    $formConnexion->ajouterComposantTab();
    
    $formConnexion->ajouterComposantLigne($formConnexion->creerLabel("Mot de Passe","mdp"),1);
    $formConnexion->ajouterComposantLigne($formConnexion->creerInputPass("motdepasse","mdp",0,false),2);
    $formConnexion->ajouterComposantTab();
    
    $formConnexion->ajouterComposantLigne($formConnexion->creerLabel($messageErreurConnexion, "messageErreurConnexion"),2);
    $formConnexion->ajouterComposantTab();
    
    
    $formConnexion->ajouterComposantLigne($formConnexion->creerInputSubmit("Valider","valider","Valider"),1);
    $formConnexion->ajouterComposantTab();
    
    $formConnexion->creerFormulaire();

	require_once 'vues/vueConnexion.php' ;

}
else{

	$_SESSION['statut']=false;
	$_SESSION['menuPrincipal']="accueil";
	header('location: index.php');
}