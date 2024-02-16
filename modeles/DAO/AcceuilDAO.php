<?php
require_once __DIR__ .'/DBConnex.php';

class AcceuilDAO{

    public function getAll(){
        $query = DBConnex::getInstance()->prepare("SELECT * FROM `article`");

        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}