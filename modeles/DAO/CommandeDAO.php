<?php
require_once __DIR__ .'/DBConnex.php';


class CommandeDAO{

    public static function getAll(){
        $sql = "SELECT * FROM `commande`";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getByNum($num){
        $sql = "SELECT * FROM `commande` WHERE Num = :num";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->BindParam("num",$num);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function create($nomClient, $prenomClient, $mailClient, $telephoneClient, $LieuReception, $DateReception){
        $sql = "INSERT INTO `commande`(`NomClient`, `PrenomClient`, `MailClient`, `TelephoneClient`, `LieuReception`, `DateReception`, `Statut`) VALUES (:nomClient, :prenomClient, :mailClient, :telephoneClient, :lieuReception, :dateReception, 'En attente')";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->bindParam("nomClient",$nomClient);
        $sql->bindParam("prenomClient",$prenomClient);
        $sql->bindParam("mailClient",$mailClient);
        $sql->bindParam("telephoneClient",$telephoneClient);
        $sql->bindParam("lieuReception",$LieuReception);
        $sql->bindParam("dateReception",$DateReception);
        $sql->execute();
    }

    public static function updateStatut($num, $statut){
        $sql = "UPDATE `commande` SET `Statut`= :statut WHERE Num = :num";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->bindParam("num",$num);
        $sql->bindParam("statut",$statut);
        $sql->execute();
    }

    public static function delete($num){
        $sql = "DELETE FROM `commande` WHERE Num = :num";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->bindParam("num",$num);
        $sql->execute();
    }

    public static function getLastNum(){
        $sql = "SELECT MAX(Num) FROM `commande`";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getByStatut($statut){
        $sql = "SELECT * FROM `commande` WHERE Statut = :statut";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->BindParam("statut",$statut);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}