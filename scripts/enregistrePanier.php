<?php
/*
// Récupère le panier envoyé depuis JavaScript
$panierData = file_get_contents('php://input');
$panier = json_decode($panierData, true);

// Vérifie si le décodage JSON a réussi
if ($panier === null && json_last_error() !== JSON_ERROR_NONE) {
    header('HTTP/1.1 400 Bad Request', true, 400);
    echo "Erreur lors du décodage JSON.";
    exit;
}

// Démarrage de la session
session_start();

// Enregistre le panier dans la session
$_SESSION['Panier'] = $panier;

// Affiche le panier pour vérification


// Réponds à la requête AJAX
echo "Enregistrement du panier côté serveur réussi !";*/
?>
 