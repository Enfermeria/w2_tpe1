<?php

require_once 'app/models/model.php';

class LibrosModel extends Model {

    /*
    function getAll() { //devuelve todos las Libros
        $query = $this->db->prepare('SELECT * FROM libro'); // 2. Ejecuto la consulta
        $query->execute();
     
        $Libros = $query->fetchAll(PDO::FETCH_OBJ);  // 3. Obtengo los datos en un arreglo de objetos
     
        return $Libros;
    } //getAll
    */

     
    function get($idLibro) {
        $query = $this->db->prepare('SELECT idlibro, titulo, edicion, libro.idautor, autor.nombre as nombre, libro.idgenero, genero.genero as genero FROM libro, autor, genero WHERE  idLibro = ? AND libro.idautor=autor.idautor AND libro.idgenero=genero.idgenero');
        $query->execute([$idLibro]);   
      
        $libro = $query->fetch(PDO::FETCH_OBJ);
      
        return $libro;
    } //get
    

    function getAll($orden = 'idlibro') { //devuelve todos las Libros con el nombre del autor y su género
        $query = $this->db->prepare('SELECT idlibro, titulo, edicion, libro.idautor, autor.nombre as nombre, libro.idgenero, genero.genero as genero FROM libro, autor, genero WHERE libro.idautor=autor.idautor AND libro.idgenero=genero.idgenero ORDER BY ' . $orden); 
        $query->execute();
     
        $Libros = $query->fetchAll(PDO::FETCH_OBJ);  // 3. Obtengo los datos en un arreglo de objetos
     
        return $Libros;
    } //getAll


    function getPorAutor($idAutor, $orden = 'idlibro') {
        $query = $this->db->prepare('SELECT idlibro, titulo, edicion, libro.idautor, autor.nombre as nombre, libro.idgenero, genero.genero as genero FROM libro, autor, genero WHERE  libro.idautor = ? AND libro.idautor=autor.idautor AND libro.idgenero=genero.idgenero ORDER BY ' . $orden);
        $query->execute([$idAutor]);   
      
        $libros = $query->fetchAll(PDO::FETCH_OBJ);
      
        return $libros;
    } //getPorAutor
    

    function getFiltradoPor($campoYOperador, $txtfiltro, $orden){
        $query = $this->db->prepare('SELECT idLibro, titulo, edicion, libro.idautor, autor.nombre as nombre, libro.idgenero, genero.genero as genero FROM libro, autor, genero WHERE libro.idautor=autor.idautor AND libro.idgenero=genero.idgenero AND ' . $campoYOperador . ' ? ORDER BY ' . $orden);
        $query->execute([$txtfiltro]);   
    
        $libros = $query->fetchAll(PDO::FETCH_OBJ);  // 3. Obtengo los datos en un arreglo de objetos
    
        return $libros;
    }

    
    function getFiltradoPorTitulo($txtfiltro, $orden = 'idlibro'){
        return $this->getFiltradoPor("titulo LIKE ", $txtfiltro . "%", $orden);
    } //getFiltradoPorTitulo


    function getFiltradoPorAutor($txtfiltro, $orden = 'idlibro'){
        return $this->getFiltradoPor("nombre LIKE ", $txtfiltro . "%", $orden);
    } //getFiltradoPorAutor


    function getFiltradoPorGenero($txtfiltro, $orden = 'idlibro'){
        return $this->getFiltradoPor("genero LIKE ", $txtfiltro . "%", $orden);
    } //getFiltradoPorGenero

    
    function getFiltradoPorEdicionMayor($txtfiltro, $orden = 'idlibro'){
        return $this->getFiltradoPor("edicion > ", $txtfiltro, $orden);
    } //getFiltradoPorEdicionMayor


    function getFiltradoPorEdicionMenor($txtfiltro, $orden = 'idlibro'){
        return $this->getFiltradoPor("edicion < ", $txtfiltro, $orden);
    } //getFiltradoPorEdicionMenor


    function getFiltradoPorEdicionIgual($txtfiltro, $orden = 'idlibro'){
        return $this->getFiltradoPor("edicion = ", $txtfiltro, $orden);
    } //getFiltradoPorIgual


    function getFiltradoPorEdicionMayorOIgual($txtfiltro, $orden = 'idlibro'){
        return $this->getFiltradoPor("edicion >= ", $txtfiltro, $orden);
    } //getFiltradoPorEdicionMayorOIgual


    function getFiltradoPorEdicionMenorOIgual($txtfiltro, $orden = 'idlibro'){
      return $this->getFiltradoPor("edicion <= ", $txtfiltro, $orden);
    } //getFiltradoPorEdicionMayorOIgual




    function insert($titulo, $idAutor, $idGenero, $edicion) { // agrega un nuevo registro a la tabla libros
        $query = $this->db->prepare('INSERT INTO libro (titulo, idautor, idgenero, edicion) VALUES (?, ?, ?, ?)');
        $query->execute([$titulo, $idAutor, $idGenero, $edicion]);
      
        $id = $this->db->lastInsertId();
      
        return $id;
    } // insert
    
    
    function delete($idLibro) { // borra el registro de la tabla libros
        $query = $this->db->prepare('DELETE FROM libro WHERE idLibro = ?');
        $query->execute([$idLibro]);
    } //delete
    
    
    function update($idLibro, $titulo, $idAutor, $idGenero, $edicion) { // actualiza la tabla libros con los parámetros dados
        $query = $this->db->prepare('UPDATE libro SET titulo=?, idautor=?, idgenero=?, edicion=? WHERE idLibro = ?');
        $query->execute([$titulo, $idAutor, $idGenero, $edicion, $idLibro]);
    } //update


    function cantidadConIdGenero($idGenero){ // me devuelve la cantidad de libros con ese idGenero
        $query = $this->db->prepare('SELECT COUNT(*) AS cantidad FROM libro WHERE idgenero=?');
        $query->execute([$idGenero]);

        $respuesta = $query->fetch(PDO::FETCH_OBJ);
        return $respuesta->cantidad;
    } //cantidadConIdGenero

    
    function cantidadConIdAutor($idAutor){ // me devuelve la cantidad de libros con ese idAutor
        $query = $this->db->prepare('SELECT COUNT(*) AS cantidad FROM libro WHERE idautor=?');
        $query->execute([$idAutor]);

        $respuesta = $query->fetch(PDO::FETCH_OBJ);
        return $respuesta->cantidad;
    } //cantidadConIdAutor

}