<main>

<?php



echo $retour;

echo "<div class='Produit'>";
echo "<img src='". $infoProduit[0]['Photo']."' class='ImageProduit'>";
echo "<div class='infoProduit'>";
echo "<p class='NomProduit'>".$infoProduit[0]['Nom']."</p>";
echo "<hr class='barreProduit'>";
echo "<br>";
echo "<p class='DescriptionProduit' id='DescriptionCourte'>".$descriptionCourte."</p>";
echo "<p class='DescriptionProduit hidden' id='DescriptionFull'> ".$infoProduit[0]['Description']."</p>";
if(strlen($infoProduit[0]['Description']) > 512){
    echo "<button id='btnVoirPlus' class='btnVoirPlus'>Voir plus ⏷</button>";
}
echo "<br>";
echo "<hr class='barreProduit'>";
echo "<p class='PrixProduit'>".$infoProduit[0]['Prix']." €</p>";
echo "<hr class='barreProduit'>";
echo "</div>";


$btnCommander->afficherFormulaire();
//echo $btnCommander;
echo $ajouterPanier;

echo "</div>";


echo "<div class='Commentaires'><p>Commentaire :</p><br>"; 

$fromCommentaire->afficherFormulaire();




foreach($commentairesProduit as $unCommentaire){
    if($unCommentaire['Statut'] == "Validé"){
        date("Y-m-d", strtotime($unCommentaire['date']));
        echo "<span class='ComTitre'>".$unCommentaire['NomPrenom']."     le  ".$unCommentaire['date']."</span>";
        echo "<br>";
        echo "<p class='ComLibel'>".$unCommentaire['Libelle']."</p>";
    }

}

echo "</div>";

?>
</main>