<?php

/******************************************************************************************/
/***                                    PANTALLAS                                       ***/
/******************************************************************************************/
class LibrosView{

    function showLibros($libros, $filtro) {  // Las libros vienen con autor y genero. Muestro la tabla con todos los libros
        $count = count($libros);  
        require_once 'templates/tabla_libros.phtml';
    } //showLibros


    function showLibrosXAutor($libros, $autor) {
        $count = count($libros);  
        require_once 'templates/form_libros_x_autor.phtml';
    } //showLibrosXAutor



    function showFormAddLibro($autores, $generos){ // muestro el formulario de alta
        require_once 'templates/form_add_libro.phtml';
    } //showFormAddLibro


    function showFormEditLibro($idLibro, $libros, $autores, $generos){ // Las libros vienen con nombreCarrera. Muestro la tabla con el formulario de edición de una libro
        require_once 'templates/form_edit_libro.phtml';
    } //shotFormEditLibro


    function showFormDeleteLibro($libro){ // muestro el formulario de confirmación de borrado de una libro
        require_once 'templates/form_delete_libro.phtml';
    } //showFormDeleteLibro

} //LibrosView