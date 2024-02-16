<?php

require_once __DIR__ .'/DBConnex.php';

class UtilisateurDAO{
        
    public static function verification($unlogin, $unMdp){
        
        //$mdp = hash('sha256', $unMdp);


        $requetePrepa = DBConnex::getInstance()->prepare("select * from utilisateur where login = :login and  mdp = :mdp");
        $requetePrepa->bindParam( ":login", $unlogin);
        $requetePrepa->bindParam( ":mdp" ,  $unMdp);
        
       $requetePrepa->execute();

       $login = $requetePrepa->fetch(PDO::FETCH_ASSOC);
       return $login;
    }
    
    
}