<?php
require_once "app/models/generos.model.php";
require_once "app/models/libros.model.php";
require_once "app/views/generos.view.php";
require_once "app/views/general.view.php";
define ("URL_GENEROS", "showGeneros");

class GenerosController{
    private $modelGenero;
    private $modelLibro;
    private $view;
    private $generalView;

    public function __construct() {
        $this->modelGenero = new GenerosModel();
        $this->modelLibro = new LibrosModel();
        $this->view  = new GenerosView();
        $this->generalView = new GeneralView();
    } //__construct


    /******************************************************************************************/
    /***                                    LOGICA                                          ***/
    /******************************************************************************************/
    function addRegister() {
        //verifico si todos los campos están
        if (!isset($_POST['genero']) || empty($_POST['genero']))
            return $this->generalView->showError('Falta completar el género');
        
    
        //obtengo los datos de los campos Posteados
        $genero = $_POST['genero'];
    
        //inserto los datos en la bd.
        $id = $this->modelGenero->insert($genero);
    
        //redirijo al home
        header('Location: ' . BASE_URL . '/' . URL_GENEROS);
    } //addRegister
    
    
    function editRegister($idGenero) {
        //verifico si todos los campos están
        if (!isset($_POST['genero']) || empty($_POST['genero']))
            return $this->generalView->showError('Falta completar el género');
    
        //obtengo los datos de los campos Posteados
        $nombreGenero = $_POST['genero'];
            
        //verifico si existe ese idGenero en la bd
        $genero = $this->modelGenero->get($idGenero); 
        if (!$genero)  //si el registro no existe, devuelve un false, sino devuelve el objeto con la materia
            return $this->generalView->showError("No existe el género con el idgenero=$idGenero");
    
    
        //modifico ese registro en la bd
        $id = $this->modelGenero->update($idGenero, $nombreGenero);
    
        //redirijo al home
        header('Location: ' . BASE_URL . '/' . URL_GENEROS);
    } //editRegister
    
    
    function deleteRegister($idGenero) {
        // verifico si existe ese id en la bd
        $genero = $this->modelGenero->get($idGenero);// obtengo el registro por id
        if (!$genero) // si el registro no existe, devuelve un false, sino devuelve el objeto con la materia
            return $this->generalView->showError("No existe el género con el idgenero=$idGenero");

        // verifico si no hay libros que tengan ese idGenero (sino no se puede borrar)
        $cantLibros = $this->modelLibro->cantidadConIdGenero($idGenero);
        if ($cantLibros>0)
            return $this->generalView->showError("No se puede borrar el género con el idgenero=$idGenero porque existen libros de ese género");
        
        // borro ese registro en la bd
        $this->modelGenero->delete($idGenero);
    
        //redirijo al home
        header('Location: ' . BASE_URL . '/' . URL_GENEROS);
    } //deleteRegister

    
    /******************************************************************************************/
    /***                                    PANTALLAS                                       ***/
    /******************************************************************************************/
    
    function showGeneros(){ // Muestro la tabla con las generos según el filtro
        //obtengo los campos POST del filtro
        $filtro = new stdClass();
        if (!isset($_POST['cbfiltrar']) || empty($_POST['cbfiltrar']))
            $filtro->cbfiltrar = "no filtrar";
        else
            $filtro->cbfiltrar = $_POST['cbfiltrar'];

        if (!isset($_POST['txtfiltro']) || empty($_POST['txtfiltro']))
            $filtro->txtfiltro = "";
        else
            $filtro->txtfiltro = $_POST['txtfiltro']; 

        switch ($filtro->cbfiltrar){
            case 'no filtrar':
                $generos = $this->modelGenero->getAll();
                return $this->view->showGeneros($generos, $filtro); 
                break;
            case 'por genero':
                $generos = $this->modelGenero->getFiltradoPorGenero($filtro->txtfiltro);
                return $this->view->showGeneros($generos, $filtro);
                break;
            default:
                $this->generalView->showError('cb filtrar con valor no válido');
                break;
        }
    } // showGeneros


    function showAddGenero(){ // muestro un formulario para ingresar el alta de un genero
        return $this->view->showFormAddGenero();    //muestro el formulario de alta
    } // showAddGenero


    function showEditGenero($idGenero){ // muestro un formulario para editar un genero
        $genero = $this->modelGenero->get($idGenero); //verifico si existe ese id en la bd
        if (!$genero)  //si el registro no existe, devuelve un false, sino devuelve el objeto con el registro
            return $this->generalView->showError("No existe el género con el idgenero=$idGenero");
        
        
        $generos = $this->modelGenero->getAll();
        return $this->view->showFormEditGenero($idGenero, $generos);  //muestro el formulario de edicion
    } // showEditGenero


    function showDeleteGenero($idGenero){ // muestro un formulario para confirmar el borrado de un género
        $genero = $this->modelGenero->get($idGenero); 
        if (!$genero)  // si el registro no existe, devuelve un false, sino devuelve el objeto con el registro
            return $this->generalView->showError("No existe la genero con el idgenero=$idGenero");
        
        // verifico si no hay libros que tengan ese idGenero (sino no se puede borrar)
        $cantLibros = $this->modelLibro->cantidadConIdGenero($idGenero);
        if ($cantLibros>0)
            return $this->generalView->showError("No se puede borrar el género con el idgenero=$idGenero porque existen libros de ese género");
        
        return $this->view->showFormDeleteGenero($genero); //muestro el formulario de borrado
    } //showDeleteGenero


} //class GenerosController





