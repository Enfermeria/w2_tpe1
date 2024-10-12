<?php

/******************************************************************************************/
/***                                    PANTALLAS                                       ***/
/******************************************************************************************/
class UsuariosView{

    function showUsuarios($usuarios) {  // Muestro la tabla con todas los usuarios
        $count = count($usuarios);  
        require_once 'templates/tabla_usuarios.phtml';
    } //showUsuarios


    function showFormAddUsuario(){ // muestro el formulario de alta de un usuario
        require_once 'templates/form_add_usuario.phtml';
    } //showFormAddUsuario


    function showFormEditUsuario($usuario){ // Muestro la tabla con el formulario de edición de un usuario
        require_once 'templates/form_edit_usuario.phtml';
    } //shotFormEditGenero


    function showFormDeleteUsuario($usuario){ // muestro el formulario de confirmación de borrado de un usuario
        require_once 'templates/form_delete_usuario.phtml';
    } //showFormDeleteGenero

} //UsuariosView