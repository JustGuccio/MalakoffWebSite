<?php

require_once __DIR__ .'/../modeles/DAO/ArticleDAO.php';


$listeAcceuil = ArticleDAO::getAllOrderByDate();


include_once 'vues/vueMenuHaut.php' ;
include_once 'vues/vueAccueil.php' ;