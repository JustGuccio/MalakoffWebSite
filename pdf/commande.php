<?php
    require_once __DIR__ . '/PDF.php';
    require_once __DIR__ . '/../modeles/DAO/CommandeDAO.php';
    require_once __DIR__ . '/../modeles/DAO/LigneCommandeDAO.php';
    require_once __DIR__ . '/../modeles/DAO/DBConnex.php';
    require_once __DIR__ . '/../modeles/DAO/Param.php';

    header('Content-Type: text/html; charset=UTF-8');

$numCom = $_GET['nCom'];
$lignesCommande = LigneCommandeDAO::getByNumCommande($numCom);

// Instanciation de la classe dérivée
$pdf = new PDF($numCom);
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