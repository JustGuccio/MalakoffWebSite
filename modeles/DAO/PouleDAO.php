<?php
require_once __DIR__ .'/DBConnex.php';


class PouleDAO{

    public static function getAll(){
        $sql = "SELECT * FROM `ventepoules`";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getById($id){
        $sql = "SELECT * FROM `ventepoules` WHERE id = :id";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->BindParam("id",$id);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function create($dateDebut, $dateFin , $nbPoule){
        $sql = "INSERT INTO `ventepoules`(`dateDebut`, `dateFin`, `nbPoule`) VALUES (:dateDebut , :dateFin , :nbPoule)";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->bindParam("dateDebut",$dateDebut);
        $sql->bindParam("dateFin",$dateFin);
        $sql->bindParam("nbPoule",$nbPoule);
        $sql->execute();
    }

    public static function updateStatut($id, $statut){
        $sql = "UPDATE `ventepoules` SET `statut`= :statut WHERE id = :id";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->bindParam("id",$id);
        $sql->bindParam("statut",$statut);
        $sql->execute();
    }

    public static function delete($id){
        $sql = "DELETE FROM `ventepoules` WHERE id = :id";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->bindParam("id",$id);
        $sql->execute();
    }

    public static function getLastId(){
        $sql = "SELECT MAX(id) FROM `ventepoules`";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getByStatut($statut){
        $sql = "SELECT * FROM `ventepoules` WHERE statut = :statut";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->BindParam("statut",$statut);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}