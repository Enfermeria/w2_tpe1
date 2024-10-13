<?php

require_once 'app/models/model.php';

class GenerosModel extends Model {

    function getAll() { //devuelve todos los registros
        $query = $this->db->prepare('SELECT * FROM genero'); // 2. Ejecuto la consulta
        $query->execute();
     
        $generos = $query->fetchAll(PDO::FETCH_OBJ);  // 3. Obtengo los datos en un arreglo de objetos
     
        return $generos;
    } //getAll
     
     
    function get($idGenero) {
        $query = $this->db->prepare('SELECT * FROM genero WHERE idgenero = ?');
        $query->execute([$idGenero]);   
    
        $genero = $query->fetch(PDO::FETCH_OBJ);
    
        return $genero;
    } //get
    


    function getFiltradoPor($campo, $txtfiltro){
        $query = $this->db->prepare('SELECT * FROM genero WHERE ' . $campo . ' LIKE ?');
        $query->execute([$txtfiltro . "%"]);   
      
        $generos = $query->fetchAll(PDO::FETCH_OBJ);  // 3. Obtengo los datos en un arreglo de objetos
     
        return $generos;
    }

    
    function getFiltradoPorGenero($txtfiltro){
        return $this->getFiltradoPor("genero ", $txtfiltro);
    } //getFiltradoPorGenero

    

    function insert($genero) {
        $query = $this->db->prepare('INSERT INTO genero (genero) VALUES (?)');
        $query->execute([$genero]);
     
        $id = $this->db->lastInsertId();
     
        return $id;
    } // insert
     
     
    function delete($idGenero) {
        $query = $this->db->prepare('DELETE FROM genero WHERE idgenero = ?');
        $query->execute([$idGenero]);
    } //delete
     
     
    function update($idGenero, $genero) { 
        $query = $this->db->prepare('UPDATE genero SET genero=? WHERE idGenero = ?');
        $query->execute([$genero, $idGenero]);
    } //update
     
}