<?php
require_once "app/models/usuarios.model.php";
require_once "app/views/usuarios.view.php";
require_once "app/views/general.view.php";
define ("URL_USUARIOS", "showUsuarios");

class UsuariosController{
    private $modelUsuarios;
    private $view;
    private $generalView;

    public function __construct() {
        $this->modelUsuarios = new UsuariosModel();
        $this->view  = new UsuariosView();
        $this->generalView = new GeneralView();
    } //__construct


    /******************************************************************************************/
    /***                                    LOGICA                                          ***/
    /******************************************************************************************/
    function addRegister() {
        //verifico si todos los campos están
        if (!isset($_POST['nombreusuario']) || empty($_POST['nombreusuario']))
            return $this->generalView->showError('Falta completar el nombre de usuario');
        if (!isset($_POST['password']) || empty($_POST['password']))
            return $this->generalView->showError('Falta completar la contraseña');
        
        //obtengo los datos de los campos Posteados
        $nombreUsuario = $_POST['nombreusuario'];
        $password = $_POST['password'];
    
        //verifico que ese usuario no esté en la bd
        $usuario = $this->modelUsuarios->getByNombre($nombreUsuario);
        if ($usuario)  //si el registro no existe, devuelve un false, sino devuelve el objeto con el usuario
            return $this->generalView->showError("Ya existe un usuario con ese nombre =$nombreUsuario");
    
        //inserto los datos en la bd.
        $id = $this->modelUsuarios->insert($nombreUsuario, password_hash($password, PASSWORD_DEFAULT));
    
        //redirijo al home
        header('Location: ' . BASE_URL . '/' . URL_USUARIOS);
    } //addRegister
    
    
    function editRegister($idUsuario) {
        //verifico si todos los campos están
        if (!isset($_POST['nombreusuario']) || empty($_POST['nombreusuario']))
            return $this->generalView->showError('Falta completar el nombre de usuario');
        if (!isset($_POST['password']) || empty($_POST['password']))
            return $this->generalView->showError('Falta completar la contraseña');
        
        //obtengo los datos de los campos Posteados
        $nombreUsuario = $_POST['nombreusuario'];
        $password = $_POST['password'];
            
        //verifico si existe ese nombreUsuario en la bd
        $usuario = $this->modelUsuarios->getByNombre($nombreUsuario); 
        if (!$usuario)  //si el registro no existe, devuelve un false, sino devuelve el objeto con la materia
            return $this->generalView->showError("No existe el usuario con el nombreUsuario=$nombreUsuario");
    
    
        //modifico ese registro en la bd
        $id = $this->modelUsuarios->update($idUsuario, $nombreUsuario,  password_hash($password, PASSWORD_DEFAULT));
    
        //redirijo al home
        header('Location: ' . BASE_URL . '/' . URL_USUARIOS);
    } //editRegister
    
    
    function deleteRegister($idUsuario) {
        // verifico si existe ese id en la bd
        $usuario = $this->modelUsuarios->get($idUsuario);// obtengo el registro por id
        if (!$usuario) // si el registro no existe, devuelve un false, sino devuelve el objeto con la materia
            return $this->generalView->showError("No existe el usuario con el idusuario=$idUsuario");

        // verifico si no es el último usuario existente de la BD (sino no se puede borrar)
        $cantUsuarios = $this->modelUsuarios->cantidadUsuarios();
        if ($cantUsuarios==1)
            return $this->generalView->showError("No se puede borrar el usuario porque es el último que queda");

        // verifico si no es el usuario logueado (sino no se puede borrar)
        if ($_SESSION['idusuario']==$idUsuario)
            return $this->generalView->showError("No se puede borrar el usuario activo (logueado)");
        
        // borro ese registro en la bd
        $this->modelUsuarios->delete($idUsuario);
    
        //redirijo al home
        header('Location: ' . BASE_URL . '/' . URL_USUARIOS);
    } //deleteRegister

    
    /******************************************************************************************/
    /***                                    PANTALLAS                                       ***/
    /******************************************************************************************/
    
    function showUsuarios(){ // Muestro la tabla con las usuarios según el filtro
        //obtengo los campos POST del filtro
        $usuarios = $this->modelUsuarios->getAll();
        return $this->view->showUsuarios($usuarios); 
    } // showUsuarios


    function showAddUsuario(){ // muestro un formulario para ingresar el alta de un usuario
        return $this->view->showFormAddUsuario();    //muestro el formulario de alta
    } // showAddUsuario


    function showEditUsuario($idUsuario){ // muestro un formulario para editar un usuario
        $usuario = $this->modelUsuarios->get($idUsuario); //verifico si existe ese id en la bd
        if (!$usuario)  //si el registro no existe, devuelve un false, sino devuelve el objeto con el registro
            return $this->generalView->showError("No existe el usuario con el idusuario=$idUsuario");
        
        return $this->view->showFormEditUsuario($usuario);  //muestro el formulario de edicion
    } // showEditUsuario


    function showDeleteUsuario($idUsuario){ // muestro un formulario para confirmar el borrado de un género
        $usuario = $this->modelUsuarios->get($idUsuario); 
        if (!$usuario)  // si el registro no existe, devuelve un false, sino devuelve el objeto con el registro
            return $this->generalView->showError("No existe el usuario con el idusuario=$idUsuario");
        
        // verifico el último usuario (sino no se puede borrar)
        $cantUsuarios = $this->modelUsuarios->cantidadUsuarios();
        if ($cantUsuarios==1)
            return $this->generalView->showError("No se puede borrar el usuario porque es el último que queda");
        
        return $this->view->showFormDeleteUsuario($usuario); //muestro el formulario de borrado
    } //showDeleteUsuario


} //class UsuariosController





