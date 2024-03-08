<?php
require_once __DIR__ .'/DBConnex.php';


class ArticleDAO{

    public static function getAll(){
        $query = DBConnex::getInstance()->prepare("SELECT * FROM `article`");

        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getAllOrderByDate(){
        $query = DBConnex::getInstance()->prepare("SELECT * FROM `article` ORDER BY Date DESC;");

        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getAllOrderByDatee(){
        $query = DBConnex::getInstance()->prepare("SELECT * FROM `articles` ORDER BY id DESC;");

        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function getById($id){
        $query = DBConnex::getInstance()->prepare("SELECT * FROM `article` WHERE id = :id");
        $query->bindParam("id",$id);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function create($description,$titre,$image){
        $datee = date("j/m/Y", time());
        $sql = "INSERT INTO `article`(`Description`, `titre`,`Date`,`img`) VALUES (:descp , :titre, :datee , :img)";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->BindParam("descp",$description);
        $sql->BindParam("titre",$titre);
        $sql->BindParam("datee",$datee);
        $sql->BindParam("img",$image);
        $sql->execute();
    }

    public static function update($id,$description,$titre){
        $sql = "UPDATE `article` SET `Description`= :descp,`titre`= :titre WHERE id = :id";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->bindParam("descp",$description);
        $sql->bindParam("titre",$titre);
        $sql->bindParam("id",$id);
        $sql->execute();
    }

    public static function delete($id){
        $sql = "DELETE FROM `article` WHERE id = :id";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->bindParam("id",$id);
        $sql->execute();
    }

    public static function createArticle($source){
        $sql = "INSERT INTO `articles`(`source`) VALUES (:src)";
        $sql = DBConnex::getInstance()->prepare($sql);
        $sql->BindParam("src",$source);
        $sql->execute();
    }
}