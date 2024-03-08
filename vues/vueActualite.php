<main>
<div class="actualite">
    <?php
    foreach($listeArticle as $untruc){
        echo '<div class = "article">';
        //echo '<h2 class="titreArticle">'.$untruc['titre'].'</h2>';
        //echo '<br>';
        //echo '<p class="descriptionArticle">'.$untruc['Description'].'</p>';
        //if($untruc['img'] != null){
            //echo '<img src = "'. $untruc['img'] .'" class = "imgArticle">';
            
        //}
        echo $untruc['source'];
        echo '</div>';
    }
    ?>
</div>
</main>