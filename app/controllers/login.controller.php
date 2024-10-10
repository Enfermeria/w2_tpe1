<?php
require_once './app/models/login.model.php';
require_once './app/models/login.view.php';
require_once '.app/views/general.view.php';

class LoginController{
    private $model;
    private $view;
    private $generalView;

    public function __construct() {

        session_start(); //inicio la sesion para poder controlar desde cualquier pagina del sistema si el usuario esta logueado

        $this->model = new LoginModel();
        $this->view = new LoginView();
        $this->generalView = new GeneralView();
    }
    public function showLogin() {

        $this->view->displayLogin(); //muestro el formulario de login
    }

    // iniciar sesion

    public function login() {
        if(!empty($_POST['username']) && !empty($_POST['password'])) { //compruebo que el usuario haya rellenado los campos necesarios
            $formUser = $_POST['username'];
            $formPassword = $_POST['password'];

            $dbUser = $this->model->getUsername($formUser);
            $dbPassword = $this->model->getPassword($formPassword);

            if(($dbUser == $formUser) && ($dbPassword == $formPassword)) { //verifico que los datos sean correctos
                $_SESSION['idusuario'] = $dbUser->id;
                $_SESSION['nombre'] = $dbUser->username;

                header("Location: ".BASE_URL."showLibros");

            } else {
                //si los datos no coinciden
                $this->generalView->showError("Usuario o contraseña incorrectos");
            }
        }
    } //iniciar sesion

    //cerrar sesion

    public function logout() {

        session_destroy();
        header("Location: ". BASE_URL . "login");

    } //cerrar sesion

}// class LoginController