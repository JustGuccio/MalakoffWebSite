<main>

<?php
    echo $retour;
        $formPanier->afficherFormulaire();

    if(isset($formValidationPanier)){
        $formValidationPanier->afficherFormulaire();
    }
?>
</main>