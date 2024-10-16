<?php

class LoginModel {
    private $db;

    public function __construct() {
        $this->db = $this->getConnection(); // abro la conexión
    } //__construct


    private function getConnection() {
        return new PDO('mysql:host=localhost;dbname=w2_tpe_libros;charset=utf8', 'root', ''); //1. Abro la conexión
    } //getConnection


    public function getUser($formUser) { //obtengo el usuario completo
        $query = $this->db->prepare("SELECT * FROM usuarios WHERE nombre = ?");
        $query->execute([$formUser]);
        return $query->fetch(PDO::FETCH_OBJ); 
    } // getUser

}// class LoginModel