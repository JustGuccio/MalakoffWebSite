<?php
    require_once('../lib/fpdf/fpdf.php');
    require_once('../modeles/DAO/CommandeDAO.php');
    require_once('../modeles/DAO/LigneCommandeDAO.php');
    require_once('../modeles/DAO/DBConnex.php');
    require_once('../modeles/DAO/Param.php');

    header('Content-Type: text/html; charset=UTF-8');

//210x297  190large
    class PDF extends FPDF
    {

    // En-tête
    function Header()
    {

        $numCom = $_GET['nCom'];
        $commande = CommandeDAO::getByNum($numCom);
        $datee = date("d/m/y");
        // Logo
        $this->Image('../images/logo.jpg',23,10,30);
        // Police Arial gras 15
        $this->SetFont('Arial', '', 12);
        // Titre
        $this->Cell(150,10,'Date : ' . $datee,0,1,'R');
        $this->Ln(10);
        $this->Cell(100,10,'',0,0,'R');
        $this->Cell(90,10,'BON DE COMMANDE',0,1,'C');
        $this->SetFont('Times', '', 10);
        $this->Cell(55,5,"215 Allée de Malakoff",0,0,'C');
        $this->SetFont('Arial', '', 12);
        $this->Cell(80,10,'',0,0,'R');
        $this->Cell(55,10,"N° " . $numCom,0,1,'L');
        $this->SetFont('Times', '', 10);
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
    $numCom = $_GET['nCom'];
    $lignesCommande = LigneCommandeDAO::getByNumCommande($numCom);

    // Instanciation de la classe dérivée
    $pdf = new PDF();
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

    



    $pdf->Output("D", "Commande".$numCom);
    ?>