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


    function insert($nombre, $biografia, $imagen=null) {
        $query = $this->db->prepare('INSERT INTO autor (nombre, biografia) VALUES (?, ?)'); // inserto autor SIN IMAGEN
        $query->execute([$nombre, $biografia]);
     
        $id = $this->db->lastInsertId(); //averiguo el id generado
        
        if ($imagen) { // si me pasaron un parámetro de imagen, actualizo la imagen con el id como parte del nombre
            $filepath = $this->moveFile($id, $imagen);
    
            $query = $this->db->prepare('UPDATE autor SET imagen=? WHERE idautor=?'); 
            $query->execute([$filepath, $id]);    
        }
     
        return $id;
    } // insert
     

    private function moveFile($id, $imagen) {
        $filepath = "images/autores/autor" . $id . "." . strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));  
        move_uploaded_file($imagen['tmp_name'], $filepath); //muevo la imagen del area temporal a su lugar definitivo.
        return $filepath;
    } //moveFile

    
    function delete($idAutor) {
        //borro la imagen asociada (si existe)
        $autor = $this->get($idAutor);
        if ($autor->imagen) 
            unlink($autor->imagen);

        //borro el registro
        $query = $this->db->prepare('DELETE FROM autor WHERE idautor = ?');
        $query->execute([$idAutor]);
    } //delete
     
     
    function update($idAutor, $nombre, $biografia, $imagen=null) { 
        if ($imagen) { // si me pasaron un parámetro de imagen, actualizo la imagen con el id como parte del nombre
            $filepath = $this->moveFile($idAutor, $imagen);
            
            $query = $this->db->prepare('UPDATE autor SET nombre=?, biografia=?, imagen=? WHERE idautor=?'); 
            $query->execute([$nombre, $biografia, $filepath, $idAutor]);    
        } else { //no me pasaron imagen, no actualizo imagen
            $query = $this->db->prepare('UPDATE autor SET nombre=?, biografia=? WHERE idAutor = ?');
            $query->execute([$nombre, $biografia, $idAutor]);
        }
    } //update
     
}