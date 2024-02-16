<?php
    require('lib/fpdf/fpdf.php');

    header('Content-Type: text/html; charset=UTF-8');

//210x297  190large
    class PDF extends FPDF
    {

    // En-tête
    function Header()
    {
        $datee = date("d/m/y");
        // Logo
        $this->Image('images/logo.jpg',23,10,30);
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
        $this->Cell(55,10,"N° ",0,1,'L');
        $this->SetFont('Times', '', 10);
        $this->Cell(55,5,"16120 Châteauneuf",0,1,'C');
        $this->Cell(55,5,"@ : malakoff16120@gmail.com",0,1,'C');
        $this->Cell(55,5,"Tel : 05 45 62 54 77",0,1,'C');
        $this->Cell(55,5,"SIRET : 840 984 652 00015",0,1,'C');
        $this->Cell(55,5,"TVA : FR70 840 984 652",0,1,'C');
        $this->Cell(55,5,"Identifiant N° 1FRVAH",0,1,'C');


 
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
    
    // Instanciation de la classe dérivée
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
/*
    $pdf->SetFont('Times','B',15);
    $pdf->Cell(80,5,"Œufs de poules élevées en plein air calibrés",0,1,'L');

    $pdf->SetFont("Arial" , "" , 12);
    $pdf->Cell(63,8,"Calibre",1,0,'C');
    $pdf->Cell(63,8,"Quantité",1,0,'C');
    $pdf->Cell(63,8,"Prix",1,1,'C');

    $pdf->Cell(63,8,"XL - Très gros",1,0,'C');
    $pdf->Cell(63,8,"",1,0,'C');
    $pdf->Cell(63,8,"",1,1,'C');

    $pdf->Cell(63,8,"L - Gros",1,0,'C');
    $pdf->Cell(63,8,"",1,0,'C');
    $pdf->Cell(63,8,"",1,1,'C');

    $pdf->Cell(63,8,"M - Moyen",1,0,'C');
    $pdf->Cell(63,8,"",1,0,'C');
    $pdf->Cell(63,8,"",1,1,'C');

    $pdf->Cell(63,8,"",1,0,'C');
    $pdf->Cell(63,8,"",1,0,'C');
    $pdf->Cell(63,8,"",1,1,'C');

    $pdf->Cell(63,8,"",1,0,'C');
    $pdf->Cell(126,8,"A consommer de préférence avant le : ",1,1,'L');
*/
    $pdf->SetFont('Times','B',15);
    $pdf->Cell(80,5,"Produits Viticoles",0,1,'L');

    $pdf->SetFont("Arial" , "" , 12);
    $pdf->Cell(80,8,"Désignation",1,0,'C');
    $pdf->Cell(55,8,"Quantité",1,0,'C');
    $pdf->Cell(55,8,"Prix",1,1,'C');

    $pdf->Cell(80,8,"Cognac XO",1,0,'L');
    $pdf->Cell(55,8,"",1,0,'C');
    $pdf->Cell(55,8,"",1,1,'C');

    $pdf->Cell(80,8,"Cognac VSOP",1,0,'L');
    $pdf->Cell(55,8,"",1,0,'C');
    $pdf->Cell(55,8,"",1,1,'C');

    $pdf->Cell(80,8,"Pineau des Charentes Blanc",1,0,'L');
    $pdf->Cell(55,8,"",1,0,'C');
    $pdf->Cell(55,8,"",1,1,'C');

    $pdf->Cell(80,8,"Pineau des Charentes Rouge",1,0,'L');
    $pdf->Cell(55,8,"",1,0,'C');
    $pdf->Cell(55,8,"",1,1,'C');

    $pdf->Cell(80,8,"Vieux Pineau des Charentes",1,0,'L');
    $pdf->Cell(55,8,"",1,0,'C');
    $pdf->Cell(55,8,"",1,1,'C');

    $pdf->Cell(80,8,"Vin Charentais Rouge bouteille",1,0,'L');
    $pdf->Cell(55,8,"",1,0,'C');
    $pdf->Cell(55,8,"",1,1,'C');

    $pdf->Cell(80,8,"Vin Charentais Rouge Bag in Box",1,0,'L');
    $pdf->Cell(55,8,"",1,0,'C');
    $pdf->Cell(55,8,"",1,1,'C');

    
    $pdf->Cell(80,8,"Vin Charentais Blanc bouteille",1,0,'L');
    $pdf->Cell(55,8,"",1,0,'C');
    $pdf->Cell(55,8,"",1,1,'C');

    $pdf->Cell(80,8,"Vin Charentais Blanc Bag in Box",1,0,'L');
    $pdf->Cell(55,8,"",1,0,'C');
    $pdf->Cell(55,8,"",1,1,'C');

    
    $pdf->Cell(80,8,"Vin Charentais Rosé bouteille",1,0,'L');
    $pdf->Cell(55,8,"",1,0,'C');
    $pdf->Cell(55,8,"",1,1,'C');

    $pdf->Cell(80,8,"Vin Charentais Rosé Bag in Box",1,0,'L');
    $pdf->Cell(55,8,"",1,0,'C');
    $pdf->Cell(55,8,"",1,1,'C');

    $pdf->Cell(80,8,"Jus de raisin Pétillant (sans alcool)",1,0,'L');
    $pdf->Cell(55,8,"",1,0,'C');
    $pdf->Cell(55,8,"",1,1,'C');

    $pdf->Cell(80,8,"Méthode traditionnelle",1,0,'L');
    $pdf->Cell(55,8,"",1,0,'C');
    $pdf->Cell(55,8,"",1,1,'C');



    $pdf->Output();
    ?>