<?php
require_once __DIR__ .'/../lib/Formulaire.php';
require_once __DIR__ .'/../lib/Menu.php';
require_once __DIR__ .'/../modeles/DAO/CommentaireDAO.php';
require_once __DIR__ .'/../modeles/DAO/ProduitDAO.php';



include_once 'vues/vueMenuHaut.php' ;



$monPanier = new Formulaire("post","index.php?menuPrincipal=panier","FormPanier", "FormPanier");

$monPanier->ajouterComposantLigne($monPanier->creerInputSubmit("voirPanier", "voirPanier" ,"Voir Mon Panier"),1);
$monPanier->ajouterComposantTab();

$monPanier->creerFormulaire();


if(isset($_GET['listeProduits']) && $_GET['listeProduits'] != null){


	$retour = "<a href='index.php?menuPrincipal=listeProduits'>Retour</a>";


	$idProduit = $_GET['listeProduits'];
	$produit = new ProduitDAO;
	$infoProduit = $produit->getById($idProduit);

	$commentairesProduit = CommentaireDAO::getByIdProduit($idProduit);

	$btnCommander = new Formulaire("post", "index.php?listeProduits=".$idProduit."", "formCommander", "formCommandeer");

	$btnCommander->ajouterComposantLigne($btnCommander->creerInputSubmit("btnCommander","btnCommander","Commander"),1);
	$btnCommander->ajouterComposantTab();

	$btnCommander->creerFormulaire();

	//$btnCommander = "<button id='btnCommander'>Commander</button>";

	$ajouterPanier = "<span id='messageAddPanier'></span>";

	$descriptionCourte = substr($infoProduit[0]['Description'], 0, 255);
	

	if(!isset($_SESSION['Panier'])){
		$_SESSION['Panier'] = [];
	}

	

	if(isset($_POST['btnCommander'])){
		$ajouterPanier = "L'article a été ajouté au panier";

		array_push($_SESSION['Panier'],$idProduit);
	}

	// Récupérer les données du panier depuis la requête AJAX






	$fromCommentaire = new Formulaire("post", "index.php?listeProduits=".$idProduit."","formCommentaire", "formCommentaire");

	$fromCommentaire->ajouterComposantLigne($fromCommentaire->creerLabel("Ajouter un commentaire :" , "LabelAddComm"),1);
	$fromCommentaire->ajouterComposantTab();

	$fromCommentaire->ajouterComposantLigne($fromCommentaire->creerInputTexte("NomPrenomCom", "NomPrenomCom", "", 1,"Nom Prénom" , 0), 1);
	$fromCommentaire->ajouterComposantTab();
	$fromCommentaire->ajouterComposantLigne($fromCommentaire->creerTextArea("LibelleCommentaire", "LibelleCommentaire", "Commentaire", 5 , 10, 1,0), 1);
	$fromCommentaire->ajouterComposantTab();
	$fromCommentaire->ajouterComposantLigne($fromCommentaire->creerInputSubmit("SubmitCom","SubmitCom","Envoyer"),1);
	$fromCommentaire->ajouterComposantTab();

	$fromCommentaire->creerFormulaire();

	if(isset($_POST['SubmitCom'])){
		$NomPrenom = $_POST['NomPrenomCom'];
		$Libelle = $_POST['LibelleCommentaire'];
		$now = new DateTime();
		$date = date("d/M/Y",$now->getTimestamp());

		CommentaireDAO::AddCommentaire($idProduit,$NomPrenom,$Libelle,$date);

	}




	include_once 'vues/vueProduit.php';

}
else{
	$var = new ProduitDAO;
	$listeProduit = $var->getAll();
	
	
	
	
	$produits = new Menu("listeProduits");
	
	foreach($listeProduit as $unProduit){
		$produits->ajouterComposant($produits->creerItemImage($unProduit['ID'],$unProduit['Photo'],$unProduit['Nom']));
	}
	
	$produits = $produits->creerMenuImage("listeProduits",$listeProduit);
	
	
	
	include_once 'vues/vueListeProduits.php' ;
}



