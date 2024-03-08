<?php

require_once __DIR__ .'/../modeles/DAO/ArticleDAO.php';


$listeArticle = ArticleDAO::getAllOrderByDatee();



include_once 'vues/vueMenuHaut.php' ;
include_once 'vues/vueActualite.php' ;
include_once 'vues/vueBas.php' ;