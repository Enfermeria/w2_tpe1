<?php

require_once 'app/models/model.php';

class UsuariosModel extends Model {

    public function getByNombre($nombreUsuario) { //obtengo el nombre de usuario
        $query = $this->db->prepare("SELECT * FROM usuarios WHERE nombreusuario = ?");
        $query->execute([$nombreUsuario]);
        return $query->fetch(PDO::FETCH_OBJ); 
    } // getByNombre


    function getAll() { //devuelve todos los registros
        $query = $this->db->prepare('SELECT * FROM usuarios'); // 2. Ejecuto la consulta
        $query->execute();
     
        $usuarios = $query->fetchAll(PDO::FETCH_OBJ);  // 3. Obtengo los datos en un arreglo de objetos
     
        return $usuarios;
    } //getAll
     
     
    function get($idUsuario) {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE idusuario = ?');
        $query->execute([$idUsuario]);   
    
        $usuario = $query->fetch(PDO::FETCH_OBJ);
    
        return $usuario;
    } //get
    

    function insert($nombreUsuario, $passwordHash) {
        $query = $this->db->prepare('INSERT INTO usuarios (nombreusuario, passwordhash) VALUES (?, ?)');
        $query->execute([$nombreUsuario, $passwordHash]);
     
        $id = $this->db->lastInsertId();
     
        return $id;
    } // insert
     
     
    function delete($idUsuario) {
        $query = $this->db->prepare('DELETE FROM usuarios WHERE idusuario = ?');
        $query->execute([$idUsuario]);
    } //delete
     
     
    function update($idUsuario, $nombreUsuario, $passwordHash) { 
        $query = $this->db->prepare('UPDATE usuarios SET nombreusuario=?, passwordhash=? WHERE idusuario = ?');
        $query->execute([$nombreUsuario, $passwordHash, $idUsuario]);
    } //update
     

    function cantidadUsuarios(){ // me devuelve la cantidad de usuarios
        $query = $this->db->prepare('SELECT COUNT(*) AS cantidad FROM usuarios');
        $query->execute();

        $respuesta = $query->fetch(PDO::FETCH_OBJ);
        return $respuesta->cantidad;
    } //cantidadUsuarios

}// class UsuariosModel