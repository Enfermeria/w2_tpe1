<?php
require_once 'app/models/usuarios.model.php';
require_once 'app/views/login.view.php';

class LoginController{
    private $model;
    private $view;


    public function __construct() {
        $this->model = new UsuariosModel();
        $this->view = new LoginView();

        $this->iniciarSesion();
    } // constructor



    public function iniciarSesion(){
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start(); 
        }
    } // iniciarSesion



    public function showLogin() {
        $this->view->showLogin(); //muestro el formulario de login
    } // showLogin



    public function login() { 
         //verifico si todos los campos están
        if (!isset($_POST['nombreusuario']) || empty($_POST['nombreusuario']))
            return $this->view->showLogin('Falta completar el nombre de usuario');
        if (!isset($_POST['password']) || empty($_POST['password']))
            return $this->view->showLogin('Falta completar la contraseña');
        
        //obtengo los datos de los campos Posteados
        $nombreUsuario = $_POST['nombreusuario'];
        $password = $_POST['password'];

        //verifico si existe ese nombreUsuario en la bd
        $usuario = $this->model->getByNombre($nombreUsuario); // busco el usuario

        if ($usuario && password_verify($password, $usuario->passwordhash)) {
            // aca lo autentiqué
            $_SESSION['idusuario'] = $usuario->idusuario;
            $_SESSION['nombreusuario'] = $usuario->nombreusuario; 
            header('Location: ' . BASE_URL);
        } else {
            session_destroy(); // destruye todos los datos almacenados de la sesión
            session_start();   // inicia nueva sesión
            $this->view->showLogin('Usuario o contraseña inválidos');
        }
    } // login



    public function logout() { // cerrar sesión
       $this->verifyLogged(); // verifica que esté logueado, si no lo manda a loguearse

        session_destroy();
        header("Location: ". BASE_URL);
    } // logout



    public function isLogged() {
        $this->iniciarSesion(); //por las dudas inicia sesión
        if (isset($_SESSION['idusuario']))
            return true;
        else
            return false;
    } //estaLogueado



    public function verifyLogged() { // verifica que esté logueado, sino lo manda a loguearse
        if (!$this->isLogged()) {
            header('Location: ' . BASE_URL . 'showLogin');
            die();
        }
    }

}// class LoginController