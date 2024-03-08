<?php

require_once __DIR__ . '/../lib/Formulaire.php';
require_once __DIR__ . '/../modeles/DAO/ContactDAO.php';
require_once __DIR__ . '/../lib/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../lib/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../lib/PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include_once 'vues/vueMenuHaut.php' ;




$formContact = new Formulaire("post","#","formContact","formContact");

$formContact->ajouterComposantLigne($formContact->creerLabel("Nom : ","nomContact"),1);
$formContact->ajouterComposantLigne($formContact->creerInputTexte("inputNomC","inputNomC","",1,"",0),1);
$formContact->ajouterComposantTab();
$formContact->ajouterComposantLigne($formContact->creerLabel("Prénom : ","prenomContact"),1);
$formContact->ajouterComposantLigne($formContact->creerInputTexte("inputPrenomC","inputPrenomC","",1,"",0),1);
$formContact->ajouterComposantTab();
$formContact->ajouterComposantLigne($formContact->creerLabel("Mail : ","prenomContact"),1);
$formContact->ajouterComposantLigne($formContact->creerInputMail("inputMailC","inputMailC","",1,"",0),1);
$formContact->ajouterComposantTab();
$formContact->ajouterComposantLigne($formContact->creerLabel("Téléphone : ","prenomContact"),1);
$formContact->ajouterComposantLigne($formContact->creerInputMobile("inputTelC","inputTelC","",0,"",0),1);
$formContact->ajouterComposantTab();
$formContact->ajouterComposantLigne($formContact->creerLabel("Message : ","prenomContact"),1);
$formContact->ajouterComposantLigne($formContact->creerTextArea("inputMessC","inputMessC","",10,50,1,0),1);
$formContact->ajouterComposantTab();
$formContact->ajouterComposantLigne($formContact->creerInputSubmit("envoyerContact","envoyerContact","Envoyer"),1);
$formContact->ajouterComposantTab();

$formContact->creerFormulaire();


if(isset($_POST['envoyerContact'])){
    if (preg_match("/^[a-zA-ZÀ-ÿ\-]+$/u", $_POST['inputNomC'])) {
        $nom = $_POST['inputNomC'];
    } else {
        echo "Nom invalide.";
    }
    if (preg_match("/^[a-zA-ZÀ-ÿ\-]+$/u", $_POST['inputPrenomC'])) {
        $prenom = $_POST['inputPrenomC'];
    } else {
        echo "Nom invalide.";
    }
    if (filter_var($_POST['inputMailC'], FILTER_VALIDATE_EMAIL)) {
        $email = $_POST['inputMailC'];
    } else {
        echo "Adresse e-mail invalide.";
        die;
    }
    if (preg_match("/^[0-9]{10}$/", $_POST['inputTelC'])) {
        $tel = $_POST['inputTelC'];
    } else {
        echo "Numéro de téléphone invalide.";
        $tel = '';
    }
    
    $message = $_POST['inputMessC'];
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
    $mail->setFrom("paul0rouzeau@gmail.com", "Contact");
    $mail->addAddress('paul0rouzeau@gmail.com', "Malakoff");
    $mail->isHTML(true);                                 
    $mail->Subject = "Contact";
    $mail->Body    = "Nom : " . $nom . "<br>Prénom : " . $prenom . "<br>Mail : ".$email."<br>Téléphone : " .$tel." <br><br>Message : " .$message;
    $mail->setLanguage('fr', '/optional/path/to/language/directory/');
    if (!$mail->Send()) {
        echo "Erreur lors de l'envoi de l'e-mail";
    } else {
        header("Location: index.php?menuPrincipal=info");
        exit();
    }
}
$map = '<iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d19899.77079750476!2d-0.036911137093183215!3d45.588693068198104!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48007fca4b07cd77%3A0xd4db449e104ad0e6!2sDomaine%20de%20Malakoff!5e0!3m2!1sfr!2sfr!4v1708355692985!5m2!1sfr!2sfr" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';

include_once 'vues/vueInfo.php' ;

include_once 'vues/vueBas.php' ;
?>