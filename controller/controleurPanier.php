<?php
include_once 'vues/vueMenuHaut.php' ;

require_once __DIR__ .'/../lib/Formulaire.php';
require_once __DIR__ .'/../modeles/DAO/ProduitDAO.php';
require_once __DIR__ .'/../modeles/DAO/CommandeDAO.php';
require_once __DIR__ .'/../modeles/DAO/LigneCommandeDAO.php';



if(!empty($_SESSION['Panier'])){
    $panier = $_SESSION['Panier'];
}
$retour = "<a href='index.php?menuPrincipal=listeProduits'>Retour</a>";

$produitDAO = new ProduitDAO;

$formPanier = new Formulaire("post" , "index.php?menuPrincipal=panier" , "formPanier" , "formPanier");

$formPanier->ajouterComposantLigne($formPanier->creerLabel("Votre Panier", "LabelPanier"),1);
$formPanier->ajouterComposantTab();

if(!empty($panier)){
    foreach($panier as $unProduit){
        $infoProduit = $produitDAO->getById($unProduit);
        $formPanier->ajouterComposantLigne($formPanier->creerImg($infoProduit[0]['Photo'], "imgProduit") ,1);
        $formPanier->ajouterComposantLigne($formPanier->creerLabel($infoProduit[0]['Nom'], "LabelNomProduit") ,1);
        $formPanier->ajouterComposantLigne($formPanier->creerLabel($infoProduit[0]['Prix'] ."€", "LabelPrixProduit") ,1);
        $formPanier->ajouterComposantLigne($formPanier->creerLabel("Quantitée", "LabelQttProduit") ,1);
        $formPanier->ajouterComposantLigne($formPanier->creerInputNumberV("inputQtt[]", "inputQtt",0),1);
        $formPanier->ajouterComposantLigne($formPanier->creerInputHidden("inputId[]", "inputId",$unProduit),1);
        $formPanier->ajouterComposantLigne($formPanier->creerButton("btnSuppProduit", "btnSuppProduit", "Retirer le produit", $infoProduit[0]['ID']), 1);

        $formPanier->ajouterComposantTab();
    }

    $formPanier->ajouterComposantLigne($formPanier->creerInputSubmit("ValiderPanier", "ValiderPanier","Valider Mon Panier"),1);
    $formPanier->ajouterComposantLigne($formPanier->creerInputSubmit("SuppPanier","SuppPanier" , "Supprimer Mon Panier"),1);
    $formPanier->ajouterComposantTab();
}

else{
    $formPanier->ajouterComposantLigne($formPanier->creerLabel("Votre panier est vide", "LabelPanierVide"),1);
    $formPanier->ajouterComposantTab();
}
$formPanier->creerFormulaire();

if(isset($_POST['SuppPanier'])){
    $_SESSION['Panier'] = [];
    $panier = [];
    header('Location: index.php?menuPrincipal=panier');
    exit();
}
if(isset($_POST["btnSuppProduit"])){
    $idProduit = $_POST['btnSuppProduit'];
    $listeProduit = $_SESSION['Panier'];
    $indexProduit = array_search($idProduit, $listeProduit);
    
    if ($indexProduit !== false) {
        unset($listeProduit[$indexProduit]);
        $_SESSION['Panier'] = array_values($listeProduit);  // Réindexe le tableau après la suppression
        header('Location: index.php?menuPrincipal=panier');
        exit();
    }
}


$formValidationPanier = new Formulaire("post","#","formValidationPanier","formValidationPanier");
if(isset($_POST['ValiderPanier'])){
    $idProduits = $_POST['inputId'];
    $qttProduits = $_POST['inputQtt'];
    $options = ['Marché','Domaine'];
    $prixTotal =0;
    $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerLabel("Nom :","nomClient"),1);
    $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerInputTexte("inputNomC","inputNomC","",1,"",0),1);
    $formValidationPanier->ajouterComposantTab();
    $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerLabel("Prénom :","prenomClient"),1);
    $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerInputTexte("inputPrenomC","inputPrenomC","",1,"",0),1);
    $formValidationPanier->ajouterComposantTab();
    $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerLabel("Mail :","mailClient"),1);
    $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerInputMail("inputMailC","inputMailC","",1, null,0),1);
    $formValidationPanier->ajouterComposantTab();
    $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerLabel("Téléphone :","telClient"),1);
    $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerInputMobile("inputTelC","inputTelC","",1, null,0),1);
    $formValidationPanier->ajouterComposantTab();
    $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerLabel("Lieu réception :","lieuReception"),1);
    $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerSelect("selectLieu","selectLieu","selectLieu",$options),1);
    $formValidationPanier->ajouterComposantTab();
    $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerLabel("Date réception :","dateReception"),1);
    $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerInputDate("inputDateR","inputDateR","",1, null,0),1);
    $formValidationPanier->ajouterComposantTab();
    $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerLabel("Produits : " ,"produitCommande"),1);
    $formValidationPanier->ajouterComposantTab();
    $i = 0;
    $_SESSION['idProduits'] = $idProduits;
    foreach($idProduits as $id){
        $produit = ProduitDAO::getById($id);
        $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerLabel("-","lblNomProduit"),1);
        $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerInputTexte("nomProduit[]","nomProduit[]",$produit[0]['Nom'],1,0,1),1);
        $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerLabel("Quantité : ","lblQttProduit"),1);
        $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerInputTexte("qttProduit[]","qttProduit[]",$qttProduits[$i],1,0,1),1);
        $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerLabel("Prix :","lblPrixProduit"),1);
        $prixProduit = $qttProduits[$i] * $produit[0]['Prix'];
        $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerInputTexte("prixProduits[]","prixProduits[]",$prixProduit,1,0,1),1);
        $formValidationPanier->ajouterComposantTab();
        $i++;
        $prixTotal += $prixProduit;
    }


    $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerLabel("Prix total :","prixTotalProduit"),1);
    $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerInputTexte("prixTotal","prixTotal",$prixTotal,1,0,1),1);
    $formValidationPanier->ajouterComposantTab();
    $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerInputSubmit("validerCommande","validerCommande","Valider ma Commande"),1);
    $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerInputSubmit("annulerCommande","annulerCommande","Annuler ma Commande"),1);
    $formValidationPanier->ajouterComposantTab();
    $formValidationPanier->creerFormulaire();

}


if(isset($_POST['validerCommande'])){
    $nomClient = $_POST['inputNomC'];
    $prenomClient = $_POST['inputPrenomC'];
    $mailClient = $_POST['inputMailC'];
    $telClient = $_POST['inputTelC'];
    $lieuReception = $_POST['selectLieu'];
    $dateReception = $_POST['inputDateR'];
    $idProduits = $_SESSION['idProduits'];
    $qttProduits = $_POST['qttProduit'];
    $prixProduit = $_POST['prixProduits'];
    $prixTotal = $_POST['prixTotal'];

    CommandeDAO::create($nomClient,$prenomClient,$mailClient,$telClient,$lieuReception,$dateReception);
    $lastNum = CommandeDAO::getLastNum();
    $i = 0;
    foreach($idProduits as $id){
        LigneCommandeDAO::create($lastNum['MAX(Num)'],$id,$qttProduits[$i]);
        $i++;
    }
    $_SESSION['Panier'] = [];
}



include_once 'vues/vuePanier.php' ;
?>