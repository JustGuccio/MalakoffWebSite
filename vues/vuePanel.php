<?php


  echo $menuPanel;

?>

<div class="main-content">
    <?php
    if (isset($_GET['menuPanel'])) {
        if ($_GET['menuPanel'] == "panelProduit") {
            echo $menuProduit;
            $formCreerProduit->afficherFormulaire();
            if (isset($_GET['produit'])) {
                $formInfoProduit->afficherFormulaire();
            }
            if ($formAjoutProduit) {
                $formAjoutProduit->afficherFormulaire();
            }
        }
        if ($_GET['menuPanel'] == "panelCommande") {
            $formSelectCommande->afficherFormulaire();
            echo $menuCommandes;
            if(isset($formInfoCommande)){
                $formInfoCommande->afficherFormulaire();
            }

        }
        if ($_GET['menuPanel'] == "panelArticle") {
            echo $menuArticle;
            $formCreerArticle->afficherFormulaire();

            if (isset($formArticle)) {
                $formArticle->afficherFormulaire();
            }
        }
        if ($_GET['menuPanel'] == "panelCommentaire") {
            $formSelect->afficherFormulaire();
            if (isset($menuCom)) {
                echo $menuCom;
            }

            if (isset($formCommentaire)) {
                $formCommentaire->afficherFormulaire();
            }
        }
        if ($_GET['menuPanel'] == "panelDeco") {
            $_SESSION['authentification'] == null;
            header("Location: index.php?menuPrincipal=accueil");
            exit();
        }
    }

    ?>
</div>
