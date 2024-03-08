<main>

<?php
    echo $retour;
    if(!empty($formPanier)){
        $formPanier->afficherFormulaire();
    }
       

    if(isset($formValidationPanier)){
        $formValidationPanier->afficherFormulaire();
    }
?>
</main>