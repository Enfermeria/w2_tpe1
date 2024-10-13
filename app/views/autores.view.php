<?php

/******************************************************************************************/
/***                                    PANTALLAS                                       ***/
/******************************************************************************************/
class AutoresView{

    function showAutores($autores, $filtro) {  // Muestro la tabla con todos los autores
        $count = count($autores);  
        require_once 'templates/tabla_autores.phtml';
    } //showAutores


    function showFormAddAutor(){ // muestro el formulario de alta de un autor
        require_once 'templates/form_add_autor.phtml';
    } //showFormAddAutor


    function showFormEditAutor($idAutor, $autores){ // Muestro la tabla con el formulario de edición de un autor
        require_once 'templates/form_edit_autor.phtml';
    } //showFormEditAutor


    function showFormEditImagenAutor($autor){ // Muestro el formulario de edición de un autor
        require_once 'templates/form_edit_imagen_autor.phtml';
    } //showFormEditAutor


    function showFormDeleteAutor($autor){ // muestro el formulario de confirmación de borrado de un autor
        require_once 'templates/form_delete_autor.phtml';
    } //showFormDeleteAutor

} //AutoresView