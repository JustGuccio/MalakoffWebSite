<?php
require_once __DIR__ .'/DBConnex.php';


class CommentaireDAO{

    public static function getAll(){
        $query = DBConnex::getInstance()->prepare("SELECT * FROM commentaire");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }



    public static function getByIdProduit($idProduit){
        $query = DBConnex::getInstance()->prepare("SELECT * FROM commentaire WHERE ID_Produit = :idProduit");

        $query->BindParam("idProduit" , $idProduit);

        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function AddCommentaire($idProduit, $NomPrenom, $Contenu, $date){
        $query = DBConnex::getInstance()->prepare("INSERT INTO `commentaire`(`Libelle`, `ID_Produit`, `NomPrenom`, `date`, `Statut`) VALUES (:content,:idProduit,:NomPrenom,:datte, 'En attente')");
        $query->BindParam("content", $Contenu);
        $query->BindParam("idProduit", $idProduit);
        $query->BindParam("NomPrenom", $NomPrenom);
        $query->BindParam("datte" , $date);

        $query->execute();
    }

    public static function getById($id){
        $sql = DBConnex::getInstance()->prepare("SELECT commentaire.* , produit.Nom FROM commentaire , produit WHERE commentaire.id = :id And commentaire.ID_Produit = produit.ID");
        $sql->BindParam("id",$id);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getByProductName($name){
        $sql = "SELECT commentaire.*, produit.Nom FROM `commentaire` , produit WHERE produit.Nom = :nom And produit.ID = commentaire.ID_Produit";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->BindParam("nom" , $name);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getByStatut($statut){
        $sql = "SELECT commentaire.*, produit.Nom FROM `commentaire` , produit WHERE commentaire.Statut = :statut And produit.ID = commentaire.ID_Produit; ";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->BindParam("statut" , $statut);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getByProductNameAStatut($name , $statut){
        $sql = "SELECT commentaire.*, produit.Nom FROM `commentaire` , produit WHERE produit.Nom = :nom And commentaire.Statut = :statut And produit.ID = commentaire.ID_Produit";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->BindParam("nom" , $name);
        $sql->BindParam("statut" , $statut);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function updateStatut($id, $statut){
        $sql = "UPDATE `commentaire` SET `Statut`= :statut WHERE id = :id";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->BindParam("id",$id);
        $sql->BindParam("statut",$statut);
        $sql->execute();
    }
}