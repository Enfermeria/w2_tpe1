<?php

/******************************************************************************************/
/***                                    PANTALLAS                                       ***/
/******************************************************************************************/
class GenerosView{

    function showGeneros($generos, $filtro) {  // Muestro la tabla con todas los generos
        $count = count($generos);  
        require_once 'templates/tabla_generos.phtml';
    } //showGeneros


    function showFormAddGenero(){ // muestro el formulario de alta de un genero
        require_once 'templates/form_add_genero.phtml';
    } //showFormAddGenero


    function showFormEditGenero($idGenero, $generos){ // Muestro la tabla con el formulario de edición de un genero
        require_once 'templates/form_edit_genero.phtml';
    } //shotFormEditGenero


    function showFormDeleteGenero($genero){ // muestro el formulario de confirmación de borrado de un genero
        require_once 'templates/form_delete_genero.phtml';
    } //showFormDeleteGenero

} //GenerosView