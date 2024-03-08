<?php
include_once 'vues/vueMenuHaut.php' ;
require_once __DIR__ .'/../pdf/PDF.php';
require_once __DIR__ .'/../lib/Formulaire.php';
require_once __DIR__ .'/../modeles/DAO/ProduitDAO.php';
require_once __DIR__ .'/../modeles/DAO/CommandeDAO.php';
require_once __DIR__ .'/../modeles/DAO/LigneCommandeDAO.php';
require_once __DIR__ . '/../lib/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../lib/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../lib/PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: text/html; charset=UTF-8');

if(!empty($_SESSION['Panier'])){
    $panier = $_SESSION['Panier'];
}
$retour = "<a href='index.php?menuPrincipal=listeProduits' class='retour'>Retour</a>";

$produitDAO = new ProduitDAO;

$formPanier = new Formulaire("post" , "index.php?menuPrincipal=panier" , "formPanier" , "formPanier");



if(!empty($panier)){
    $formPanier->ajouterComposantLigne($formPanier->creerLabel("Votre Panier", "LabelPanier"),1);
    $formPanier->ajouterComposantTab();
    foreach($panier as $unProduit){
        $infoProduit = $produitDAO->getById($unProduit);
        $formPanier->ajouterComposantLigne($formPanier->creerImg($infoProduit[0]['Photo'], "imgProduit") ,1);
        $formPanier->ajouterComposantLigne($formPanier->creerLabel($infoProduit[0]['Nom'], "LabelNomProduit") ,1);
        $formPanier->ajouterComposantLigne($formPanier->creerLabel($infoProduit[0]['Prix'] ."€", "LabelPrixProduit") ,1);
        $formPanier->ajouterComposantLigne($formPanier->creerLabel("Quantitée", "LabelQttProduit") ,1);
        $formPanier->ajouterComposantLigne($formPanier->creerInputNumberV("inputQtt[]", "inputQtt",0,0),1);
        $formPanier->ajouterComposantLigne($formPanier->creerInputHidden("inputId[]", "inputId",$unProduit),1);
        $formPanier->ajouterComposantLigne($formPanier->creerButton("btnSuppProduit", "btnSuppProduit", "<i class='fa fa-trash'>", $infoProduit[0]['ID']), 1);

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
    $formPanier = null;
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
    $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerInputMobile("inputTelC","inputTelC","",0, null,0),1);
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
        if($qttProduits[$i] > 0){
            $produit = ProduitDAO::getById($id);
            $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerLabel("-","lblNomProduit"),1);
            $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerInputTexte("nomProduit[]","nomProduit[]",$produit[0]['Nom'],1,0,1),1);
            $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerLabel("Quantité : ","lblQttProduit"),1);
            $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerInputTexte("qttProduit[]","qttProduit[]",$qttProduits[$i],1,0,1),1);
            $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerLabel("Prix :","lblPrixProduit"),1);
            $prixProduit = $qttProduits[$i] * $produit[0]['Prix'];
            $formValidationPanier->ajouterComposantLigne($formValidationPanier->creerInputTexte("prixProduits[]","prixProduits[]",$prixProduit,1,0,1),1);
            $formValidationPanier->ajouterComposantTab();
            
            $prixTotal += $prixProduit;
        }
        $i++;

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
    if (preg_match("/^[a-zA-ZÀ-ÿ\-]+$/u", $_POST['inputNomC'])) {
        $nomClient = $_POST['inputNomC'];
    } else {
        echo "Nom invalide.";
        die;
    }
    if (preg_match("/^[a-zA-ZÀ-ÿ\-]+$/u", $_POST['inputPrenomC'])) {
        $prenomClient = $_POST['inputPrenomC'];
    } else {
        echo "prenom invalide.";
        die;
    }
    if (filter_var($_POST['inputMailC'], FILTER_VALIDATE_EMAIL)) {
        $mailClient = $_POST['inputMailC'];
    } else {
        echo "Adresse e-mail invalide.";
        die;
    }
    if (preg_match("/^[0-9]{10}$/", $_POST['inputTelC'])) {
        $telClient = $_POST['inputTelC'];
    } else {
        echo "Numéro de téléphone invalide.";
        $tel = '';
    }
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
    $lignesCommande = LigneCommandeDAO::getByNumCommande($lastNum['MAX(Num)']);

        // Créer une nouvelle instance de FPDF
    $pdf = new PDF($lastNum['MAX(Num)']);
    $pdf->AliasNbPages();
    $pdf->AddPage();

    $pdf->SetFont('Times','B',15);
    $pdf->Cell(80,5,"Produits",0,1,'L');

    $pdf->SetFont("Arial" , "" , 12);
    $pdf->Cell(80,8,"Désignation",1,0,'C');
    $pdf->Cell(55,8,"Quantité",1,0,'C');
    $pdf->Cell(55,8,"Prix",1,1,'C');

    $prixtotal = 0;
    foreach($lignesCommande as $uneligne){
            $infoProduit = LigneCommandeDAO::getInfoByIdProduit($uneligne['ID'],$uneligne['Num']);
            $pdf->Cell(80,8,$infoProduit[0]['Nom'],1,0,'C');
            $pdf->Cell(55,8,$infoProduit[0]['Quantite'],1,0,'C');
            $pdf->Cell(55,8,$infoProduit[0]['Prix'] * $infoProduit[0]['Quantite']. " €",1,1,'C');
            $prixtotal += $infoProduit[0]['Prix'] * $infoProduit[0]['Quantite'];
    }
    $pdf->Cell(80,8,"",1,0,'C');
    $pdf->Cell(55,8,"",1,0,'C');
    $pdf->Cell(55,8,$prixtotal. " €",1,1,'C');

    $pdfFileName = 'commande.pdf';
    $pdf->Output($pdfFileName, 'F');

    $_SESSION['Panier'] = [];
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPSecure = 'ssl';
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;     
    $mail->Username   = 'paul1rouzeau@gmail.com';               
    $mail->Password   = 'csek vyqi enrj wxgd';                               
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
    $mail->Port       = 465;
    $mail->setFrom("paul0rouzeau@gmail.com", "Malakoff Commande");
    $mail->addAddress($mailClient);
    $mail->isHTML(true);                                 
    $mail->Subject = "Commande";
    $mail->Body    = "Votre Commande au Domaine de Malakoff à bien été réceptionné.";
    $mail->addAttachment('commande.pdf', 'commande.pdf');
    $mail->setLanguage('fr', '/optional/path/to/language/directory/');

    $mailE = new PHPMailer();
    $mailE->isSMTP();
    $mailE->SMTPDebug = 0;
    $mailE->SMTPSecure = 'ssl';
    $mailE->Host       = 'smtp.gmail.com';
    $mailE->SMTPAuth   = true;     
    $mailE->Username   = 'paul1rouzeau@gmail.com';               
    $mailE->Password   = 'csek vyqi enrj wxgd';                               
    $mailE->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
    $mailE->Port       = 465;
    $mailE->setFrom("paul0rouzeau@gmail.com", "Malakoff Commande");
    $mailE->addAddress("paul1rouzeau@gmail.com");
    $mailE->isHTML(true);                                 
    $mailE->Subject = "Commande";
    $mailE->Body    = "Votre Commande au Domaine de Malakoff à bien été réceptionné.";
    $mailE->addAttachment('commande.pdf', 'commande.pdf');
    $mailE->setLanguage('fr', '/optional/path/to/language/directory/');
    if (!$mail->Send() || !$mailE->Send()) {
        echo "Erreur lors de l'envoi de l'e-mail";
    } else {
        header("Location: index.php?menuPrincipal=listeProduits");
        exit();
    }

    
}



include_once 'vues/vuePanier.php' ;
include_once 'vues/vueBas.php' ;
?>