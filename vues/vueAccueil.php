<main>
<div class="Accueil">
    <?php
    foreach($listeAcceuil as $untruc){
        echo '<div>';
        echo $untruc['titre'];
        echo '<br>';
        echo $untruc['Description'];
        if($untruc['img'] != null){
            echo '<img src = "'. $untruc['img'] .'">';
            
        }
        echo '</div>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
    }
    ?>
</div>
</main>