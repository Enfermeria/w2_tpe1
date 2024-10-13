<?php

require_once 'app/models/model.php';

class AutoresModel extends Model {

    function getAll() { //devuelve todos los registros
        $query = $this->db->prepare('SELECT * FROM autor'); // 2. Ejecuto la consulta
        $query->execute();
     
        $autores = $query->fetchAll(PDO::FETCH_OBJ);  // 3. Obtengo los datos en un arreglo de objetos
     
        return $autores;
    } //getAll
     
     
    function get($idAutor) {
        $query = $this->db->prepare('SELECT * FROM autor WHERE idautor = ?');
        $query->execute([$idAutor]);   
    
        $autor = $query->fetch(PDO::FETCH_OBJ);
    
        return $autor;
    } //get
    
    
    function getFiltradoPor($campo, $txtfiltro){
        $query = $this->db->prepare('SELECT * FROM autor WHERE ' . $campo . ' LIKE ?');
        $query->execute([$txtfiltro . "%"]);   
      
        $generos = $query->fetchAll(PDO::FETCH_OBJ);  // 3. Obtengo los datos en un arreglo de objetos
     
        return $generos;
    } // getFiltradoPor


    
    function getFiltradoPorNombre($txtfiltro){
        return $this->getFiltradoPor("nombre", $txtfiltro);
    } //getFiltradoPorNombre


    function getFiltradoPorBiografia($txtfiltro){
        return $this->getFiltradoPor("biografia", $txtfiltro);
    } //getFiltradoPorDuracionMayor


    function insert($nombre, $biografia) {
        $query = $this->db->prepare('INSERT INTO autor (nombre, biografia) VALUES (?, ?)');
        $query->execute([$nombre, $biografia]);
     
        $id = $this->db->lastInsertId();
     
        return $id;
    } // insert
     
     
    function delete($idAutor) {
        $query = $this->db->prepare('DELETE FROM autor WHERE idautor = ?');
        $query->execute([$idAutor]);
    } //delete
     
     
    function update($idAutor, $nombre, $biografia) { 
        $query = $this->db->prepare('UPDATE autor SET nombre=?, biografia=? WHERE idAutor = ?');
        $query->execute([$nombre, $biografia, $idAutor]);
    } //update
     
}