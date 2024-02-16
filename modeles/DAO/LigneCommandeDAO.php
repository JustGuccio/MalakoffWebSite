<?php
require_once __DIR__ .'/DBConnex.php';


class LigneCommandeDAO{


    public static function getAll(){
        $sql = "SELECT * FROM `lignecommande`";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getByIdProduit($id){
        $sql = "SELECT * FROM `lignecommande` WHERE ID = :id";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->bindParam("id",$id);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getByNumCommande($num){
        $sql = "SELECT * FROM `lignecommande`WHERE Num = :num";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->bindParam("num",$num);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getInfoByIdProduit($id,$num){
        $sql = "SELECT produit.Nom , produit.Prix , lignecommande.Quantite FROM `lignecommande` , produit WHERE lignecommande.ID = produit.ID AND lignecommande.ID = :id AND lignecommande.Num = :num";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->BindParam("id",$id);
        $sql->BindParam("num",$num);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function create($num,$id,$qtt){
        $sql = "INSERT INTO `lignecommande`(`ID`, `Num`,`Quantite`) VALUES (:id,:num,:qtt)";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->bindParam("id",$id);
        $sql->bindParam("num",$num);
        $sql->bindParam("qtt",$qtt);
        $sql->execute();
    }

    public static function update(){

    }

    public static function delete(){

    }

}

?>