<?php 
require_once __DIR__ .'/DBConnex.php';


class ProduitDAO{


    public static function getAll(){

        $sql = "SELECT * FROM produit";

        $queryprepare = DBConnex::getInstance()->prepare($sql);

        $queryprepare->execute();

        $result = $queryprepare->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    public static function getAllAfficher(){

        $sql = "SELECT * FROM produit WHERE affichage = true";

        $queryprepare = DBConnex::getInstance()->prepare($sql);

        $queryprepare->execute();

        $result = $queryprepare->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    public static function getById($id){

        $sql = "SELECT * FROM produit WHERE ID = :id";

        $queryprepare = DBConnex::getInstance()->prepare($sql);

        $queryprepare->BindParam("id", $id);

        $queryprepare->execute();

        $result = $queryprepare->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    public static function update($id, $nom, $prix , $description , $photo ){
        $sql = "UPDATE `produit` SET `Nom`= :nom,`Prix`= :prix,`Description`= :descrition,`Photo`= :photo WHERE ID = :id";
        $sql = DBConnex::getInstance()->prepare($sql);

        $sql->BindParam(":nom" , $nom);
        $sql->BindParam(":prix" , $prix);
        $sql->BindParam(":descrition" , $description);
        $sql->BindParam(":photo" , $photo);
        $sql->BindParam(":id" , $id);

        $sql->execute();
    }

    public static function create($nom, $prix , $description , $photo ){
        $sql = "INSERT INTO `produit`(`Nom`, `Prix`, `Description`, `Photo`) VALUES (:nom,:prix,:descrition,:photo)";
        $sql = DBConnex::getInstance()->prepare($sql);

        $sql->bindParam("nom", $nom);
        $sql->bindParam("prix",$prix);
        $sql->bindParam("descrition", $description);
        $sql->bindParam("photo", $photo);

        $sql->execute();
    }

    public static function delete($id){
        $sql = "DELETE FROM produit WHERE ID = :id";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->bindParam("id",$id);
        $sql->execute();
    }
    
    public static function getAllNomBoth(){
        $sql = DBConnex::getInstance()->prepare("SELECT Nom From produit");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_BOTH);
        return $result;
    }

    public static function setTrue($id){
        $sql = "UPDATE `produit` SET `affichage`= 1 WHERE id = :id";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->bindParam("id",$id);
        $sql->execute();
    }

    public static function setFalse($id){
        $sql = "UPDATE `produit` SET `affichage`= 0 WHERE id = :id";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->bindParam("id",$id);
        $sql->execute();
    }
}