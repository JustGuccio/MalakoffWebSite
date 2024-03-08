<?php
require_once __DIR__ .'/DBConnex.php';

class ContactDAO{

    public static function getAll(){
        $query = DBConnex::getInstance()->prepare("SELECT * FROM `contact`");

        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getById($id){
        $query = DBConnex::getInstance()->prepare("SELECT * FROM `contact` WHERE id = :id");
        $query->BindParam("id",$id);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function update($id, $nom, $prenom , $mail , $tel, $message){
        //Pas besoin normalement
    }

    public static function create($nom, $prenom , $mail ,$telephone , $message ){
        $sql = "INSERT INTO `contact`(`Nom`, `Prénom`, `Mail`, `Telephone`, `Message`) VALUES (:nom , :prenom , :mail , :telephone , :messag)";
        $sql = DBConnex::getInstance()->prepare($sql);

        $sql->bindParam("nom", $nom);
        $sql->bindParam("prenom",$prenom);
        $sql->bindParam("mail", $mail);
        $sql->bindParam("telephone", $telephone);
        $sql->bindParam("messag", $message);

        $sql->execute();
    }

    public static function delete($id){
        $sql = "DELETE FROM `contact` WHERE ID = :id";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->bindParam("id",$id);
        $sql->execute();
    }
}