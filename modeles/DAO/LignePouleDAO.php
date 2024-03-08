<?php
require_once __DIR__ .'/DBConnex.php';


class LignePouleDAO{


    public static function getAll(){
        $sql = "SELECT * FROM `ligneventepoule`";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getByIdProduit($id){
        $sql = "SELECT * FROM `ligneventepoule` WHERE id = :id";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->bindParam("id",$id);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getByIdPoule($id){
        $sql = "SELECT * FROM `ligneventepoule`WHERE id_VentePoules = :id";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->bindParam("id",$id);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function getByIdPoulePropre($id){
        $sql = "SELECT `nomClient`, `prenomClient`, `telephoneClient`, `mailClient`, `nbPouleClient` FROM `ligneventepoule`WHERE id_VentePoules = :id";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->bindParam("id",$id);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }




    public static function create($nomClient , $prenomClient , $telClient , $mailClient, $nbPouleClient, $idVentePoule){
        $sql = "INSERT INTO `ligneventepoule`(`nomClient`, `prenomClient`, `telephoneClient`, `mailClient`, `nbPouleClient`, `id_VentePoules`) VALUES (:nomClient , :prenomClient, :telephoneClient , :mailClient , :nbPoule , :idVente)";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->bindParam("nomClient",$nomClient);
        $sql->bindParam("prenomClient",$prenomClient);
        $sql->bindParam("telephoneClient",$telClient);
        $sql->bindParam("mailClient",$mailClient);
        $sql->bindParam("nbPoule",$nbPouleClient);
        $sql->bindParam("idVente",$idVentePoule);
        $sql->execute();
    }

    public static function update(){

    }

    public static function delete(){

    }

}

?>