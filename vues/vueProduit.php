<main>

<?php



echo $retour;

echo "<div class='Produit'>";
echo "<img src='". $infoProduit[0]['Photo']."' class='ImageProduit'>";
echo "<p class='NomProduit'>".$infoProduit[0]['Nom']."</p>";
echo "<br>";
echo "<p class='DescriptionProduit' id='DescriptionCourte'>".$descriptionCourte."</p>";
echo "<p class='DescriptionProduit hidden' id='DescriptionFull'> ".$infoProduit[0]['Description']."</p>";
echo "<button id='btnVoirPlus' class='btnVoirPlus'>Afficher la description complète</button>";
echo "<br>";
echo "<p class='PrixProduit'>".$infoProduit[0]['Prix']." €</p>";

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