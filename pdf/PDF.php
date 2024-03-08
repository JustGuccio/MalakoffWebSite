<?php
    require_once __DIR__ . '/../lib/fpdf/fpdf.php';
    require_once __DIR__ . '/../modeles/DAO/CommandeDAO.php';
    require_once __DIR__ . '/../modeles/DAO/LigneCommandeDAO.php';
    require_once __DIR__ . '/../modeles/DAO/DBConnex.php';
    require_once __DIR__ . '/../modeles/DAO/Param.php';

    header('Content-Type: text/html; charset=UTF-8');

//210x297  190large
class PDF extends FPDF
{
    // Attribut pour stocker l'identifiant de commande
    private $numCom;

    // Constructeur prenant l'identifiant de commande en paramètre
    public function __construct($numCom)
    {
        parent::__construct();
        $this->numCom = $numCom;
    }

    // En-tête
    function Header()
    {
        $logo = __DIR__ . '/../images/Logo.png';

        $commande = CommandeDAO::getByNum($this->numCom);
        $datee = date("d/m/y");
        // Logo
        $this->Image($logo,23,10,30);
        $this->SetFont('Arial', '', 12);
        $this->Cell(150,10,'Date : ' . $datee,0,1,'R');
        $this->Ln(10);
        $this->Cell(100,10,'',0,0,'R');
        $this->Cell(90,10,'BON DE COMMANDE',0,1,'C');
        $this->SetFont('Times', '', 10);
 
        $this->SetFont('Arial', '', 12);
        $this->Cell(100,10,'',0,0,'R');
        $this->Cell(90,10,"N° " . $this->numCom,0,1,'C');
        $this->SetFont('Times', '', 10);
        $this->Ln(5);
        $this->Cell(55,5,"215 Allée de Malakoff",0,1,'C');
        $this->Cell(55,5,"16120 Châteauneuf",0,1,'C');
        $this->Cell(55,5,"@ : malakoff16120@gmail.com",0,1,'C');
        $this->Cell(55,5,"Tel : 05 45 62 54 77",0,1,'C');
        $this->Cell(55,5,"SIRET : 840 984 652 00015",0,0,'C');
        $this->Cell(35,5,"",0,0,'C');
        $this->Cell(75,5,"Client : ",0,1,'L');
        $this->Cell(55,5,"TVA : FR70 840 984 652",0,0,'C');
        $this->Cell(35,5,"",0,0,'C');
        $this->Cell(75,5,"Nom Prénom : " .$commande[0]['NomClient']."  " .$commande[0]['PrenomClient'],0,1,'L');
        $this->Cell(55,5,"Identifiant N° 1FRVAH",0,0,'C');
        $this->Cell(35,5,"",0,0,'C');
        $this->Cell(75,5,"Mail : " .$commande[0]['MailClient'],0,1,'L');
        $this->Cell(90,5,"",0,0,'C');
        $this->Cell(75,5,"Téléphone : " .$commande[0]['TelephoneClient'],0,1,'L');
        $this->Cell(90,5,"",0,0,'C');
        $this->Cell(75,5,"Lieu de Réception : " .$commande[0]['LieuReception'],0,1,'L');
        $this->Cell(90,5,"",0,0,'C');
        $this->Cell(75,5,"Date et Heure de Réception : " .$commande[0]['DateReception'],0,1,'L');


 
        // Saut de ligne
        $this->Ln(20);
    }
    
    // Pied de page
    function Footer()
    {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial','I',8);
        // Numéro de page
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    }
    ?>