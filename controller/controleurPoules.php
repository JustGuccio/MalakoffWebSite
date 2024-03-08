<?php
require_once __DIR__ . '/../modeles/DAO/LignePouleDAO.php';
require_once __DIR__ . '/../modeles/DAO/PouleDAO.php';
require_once __DIR__ . '/../lib/Formulaire.php';
include_once 'vues/vueMenuHaut.php' ;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


$formPoule = new Formulaire("post" , "#" , "formPoule" , "formPoule");

$Vente = PouleDAO::getByStatut("En Cours");




if(count($Vente) == 1){
    $ligneVentes = LignePouleDAO::getByIdPoule($Vente[0]['id']);

    $pouleVendu = 0;

    foreach($ligneVentes as $uneVente){
        $pouleVendu += $uneVente['nbPouleClient'];
    }
    $formPoule->ajouterComposantLigne($formPoule->creerLabel("Vente en cours du ". $Vente[0]['dateDebut'] . " au " .$Vente[0]['dateFin'],"lblDateVente"),1);
    $formPoule->ajouterComposantTab();
    $formPoule->ajouterComposantLigne($formPoule->creerLabel("Il reste encore " . $Vente[0]['nbPoule'] - $pouleVendu. " poules","lblnbPoule"),1);
    $formPoule->ajouterComposantTab();
    $formPoule->ajouterComposantLigne($formPoule->creerLabel("Réservez vos poules","lblReservations"),1);
    $formPoule->ajouterComposantTab();
    $formPoule->ajouterComposantLigne($formPoule->creerLabel("Nom : " , "nomClientP"),1);
    $formPoule->ajouterComposantLigne($formPoule->creerInputTexte("nomClient","nomClient","",1,"",0),1);
    $formPoule->ajouterComposantTab();
    $formPoule->ajouterComposantLigne($formPoule->creerLabel("Prenom : " , "prenomClientP"),1);
    $formPoule->ajouterComposantLigne($formPoule->creerInputTexte("prenomClient","prenomClient","",1,"",0),1);
    $formPoule->ajouterComposantTab();
    $formPoule->ajouterComposantLigne($formPoule->creerLabel("Téléphone : " , "telClientP"),1);
    $formPoule->ajouterComposantLigne($formPoule->creerInputMobile("TelPClient","TelPClient","",1,"",0),1);
    $formPoule->ajouterComposantTab();
    $formPoule->ajouterComposantLigne($formPoule->creerLabel("Mail : " , "mailClientP"),1);
    $formPoule->ajouterComposantLigne($formPoule->creerInputTexte("mailClient","mailClient","",1,"",0),1);
    $formPoule->ajouterComposantTab();
    $formPoule->ajouterComposantLigne($formPoule->creerLabel("Nombre de Poule : " , "nbPouleClient"),1);
    $formPoule->ajouterComposantLigne($formPoule->creerInputNumberV("nbPoule","nbPoule",0,0,$Vente[0]['nbPoule'] - $pouleVendu),1);
    $formPoule->ajouterComposantTab();
    $formPoule->ajouterComposantLigne($formPoule->creerInputSubmit("validerPoule","validerPoule","Valider Commande"),1);
    $formPoule->ajouterComposantTab();
}
else{
    $formPoule->ajouterComposantLigne($formPoule->creerLabel("Il n'y a aucune vente en ce moment <br> revenez plus tard", "lblPasVente"),1);
    $formPoule->ajouterComposantTab();
}

$formPoule->creerFormulaire();



if(isset($_POST['validerPoule'])){
    $nomC = $_POST['nomClient'];
    $prenomC = $_POST['prenomClient'];
    $TelC = $_POST['TelPClient'];
    $MailC = $_POST['mailClient'];
    $pouleC = $_POST['nbPoule'];
    LignePouleDAO::create($nomC,$prenomC,$TelC,$MailC,$pouleC,$Vente[0]['id']);

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
    $mailE->setFrom("paul0rouzeau@gmail.com", "Malakoff Commande Poule");
    $mailE->addAddress($MailC);
    $mailE->isHTML(true);                                 
    $mailE->Subject = "Commande Poule";
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

include_once 'vues/vuePoule.php';

include_once 'vues/vueBas.php' ;
?>