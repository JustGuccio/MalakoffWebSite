<?php


$filepath = 'VentePoule.csv';

// Vérifier si le fichier existe
if(file_exists($filepath)) {
    // Indiquer le type de contenu et forcer le téléchargement du fichier
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="VentePoule'.date('d-m-Y').'.csv"');
    header('Content-Length: ' . filesize($filepath));

    // Lire le contenu du fichier et le renvoyer au client
    readfile($filepath);

    // Arrêter l'exécution du script après le téléchargement du fichier
    exit();
} else {
    // Si le fichier n'existe pas, afficher un message d'erreur
    echo "Le fichier CSV n'existe pas.";
}


?>