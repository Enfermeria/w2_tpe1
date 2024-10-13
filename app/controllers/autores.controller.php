<?php
require_once "app/models/autores.model.php";
require_once "app/models/libros.model.php";
require_once "app/views/autores.view.php";
require_once "app/views/general.view.php";
define ("URL_AUTORES", "showAutores");

class AutoresController{
    private $modelAutor;
    private $modelLibro;
    private $view;
    private $generalView;

    public function __construct() {
        $this->modelAutor = new AutoresModel();
        $this->modelLibro = new LibrosModel();
        $this->view  = new AutoresView();
        $this->generalView = new GeneralView();
    } //__construct


    /******************************************************************************************/
    /***                                    LOGICA                                          ***/
    /******************************************************************************************/
    function addRegister() {
        //verifico si todos los campos están y obtengo los datos posteados
        if (!isset($_POST['nombre']) || empty($_POST['nombre']))
            return $this->generalView->showError('Falta completar el nombre del autor');
        else
            $nombre = $_POST['nombre'];

        if (!isset($_POST['biografia']) || empty($_POST['biografia']))
            //return $this->generalView->showError('Falta completar la biografía del autor');
            $biografia = ''; // como no es obligatorio, si no está, se permite en blanco
        else
            $biografia = $_POST['biografia'];

        // Verifico si subió la imagen (en Files)
        if ($_FILES['imagen']['name']) { //subio imagen, si todo ok, inserto datos con imagen
            if ($_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/png") {    
                $id = $this->modelAutor->insert($nombre, $biografia, $_FILES['imagen']); //inserto los datos con imagen en la bd
            }
            else {
                $this->generalView->showError("Formato de imagen no aceptado");
                die();
            }
        }
        else { // no subio la imagen, inserto datos sin imagen
            $id = $this->modelAutor->insert($nombre, $biografia); //inserto los datos en la bd.
        }
        
        //redirijo al home
        header('Location: ' . BASE_URL . '/' . URL_AUTORES);
    } //addRegister
    
    
    function editRegister($idAutor) {
        //verifico si todos los campos están y obtengo los datos posteados
        if (!isset($_POST['nombre']) || empty($_POST['nombre']))
            return $this->generalView->showError('Falta completar el nombre del autor');
        else
            $nombre = $_POST['nombre'];

        if (!isset($_POST['biografia']) || empty($_POST['biografia']))
            //return $this->generalView->showError('Falta completar la biografía del autor');
            $biografia = ''; // como no es obligatorio, si no está, se permite en blanco
        else
            $biografia = $_POST['biografia'];
            
        //verifico si existe ese idAutor en la bd
        $autor = $this->modelAutor->get($idAutor); 
        if (!$autor)  //si el registro no existe, devuelve un false, sino devuelve el objeto con la libro
            return $this->generalView->showError("No existe el autor con el idautor=$idAutor");
        
        //verfico si subió alguna imagen (en Files)
        if ($_FILES['imagen']['name']) { //subio imagen, si todo ok, edito datos con imagen
            if ($_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/png") 
                $id = $this->modelAutor->update($idAutor, $nombre, $biografia, $_FILES['imagen']); //modifico los datos e imagen en la bd
            else {
                $this->generalView->showError("Formato de imagen no aceptado");
                die();
            }
        } else { // no subió imagen
            $id = $this->modelAutor->update($idAutor, $nombre, $biografia); // modifico los datos, dejando la imagen anterior
        }

        //modifico ese registro en la bd
        
    
        //redirijo al home
        header('Location: ' . BASE_URL . '/' . URL_AUTORES);
    } //editRegister
    
    
    function deleteRegister($idAutor) {
        // verifico si existe ese id en la bd
        $autor = $this->modelAutor->get($idAutor);// obtengo la tarea por id
        if (!$autor) // si el registro no existe, devuelve un false, sino devuelve el objeto con la libro
            return $this->generalView->showError("No existe el autor con el idautor=$idAutor");

        // verifico si no hay libros que tengan ese idAutor (sino no se puede borrar)
        $cantLibros = $this->modelLibro->cantidadConIdAutor($idAutor);
        if ($cantLibros>0)
            return $this->generalView->showError("No se puede borrar el autor con el idautor=$idAutor porque existen libros de ese autor");
        
        // borro ese registro en la bd
        $this->modelAutor->delete($idAutor);
    
        //redirijo al home
        header('Location: ' . BASE_URL . '/' . URL_AUTORES);
    } //deleteRegister

    
    /******************************************************************************************/
    /***                                    PANTALLAS                                       ***/
    /******************************************************************************************/
    
    function showAutores(){ // Muestro la tabla con las autores según el filtro
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
                $autores = $this->modelAutor->getAll();
                return $this->view->showAutores($autores, $filtro); 
                break;
            case 'por nombre':
                $autores = $this->modelAutor->getFiltradoPorNombre($filtro->txtfiltro);
                return $this->view->showAutores($autores, $filtro);
                break;
            case 'por biografia':
                $autores = $this->modelAutor->getFiltradoPorBiografia($filtro->txtfiltro);
                return $this->view->showAutores($autores, $filtro);
                break;
            default:
                $this->generalView->showError('cb filtrar con valor no válido');
                break;
        }
    } // showAutores



    function showAddAutor(){ // muestro un formulario para ingresar el alta de un autor
        return $this->view->showFormAddAutor();    //muestro el formulario de alta
    } // showAddAutor


    function showEditAutor($idAutor){ // muestro un formulario para editar un autor
        $autor = $this->modelAutor->get($idAutor); //verifico si existe ese id en la bd
        if (!$autor)  //si el registro no existe, devuelve un false, sino devuelve el objeto con el registro
            return $this->generalView->showError("No existe el autor con el idautor=$idAutor");
        
        
        // $autores = $this->modelAutor->getAll();
        return $this->view->showFormEditImagenAutor($autor);  //muestro el formulario de edicion
    } // showEditLibro


    function showDeleteAutor($idAutor){ // muestro un formulario para confirmar el borrado de un autor
        $autor = $this->modelAutor->get($idAutor); 
        if (!$autor)  // si el registro no existe, devuelve un false, sino devuelve el objeto con el registro
            return $this->generalView->showError("No existe el autor con el idautor=$idAutor");
        
        // verifico si no hay libros que tengan ese idAutor (sino no se puede borrar)
        $cantLibros = $this->modelLibro->cantidadConIdAutor($idAutor);
        if ($cantLibros>0)
            return $this->generalView->showError("No se puede borrar el autor con el idautor=$idAutor porque existen libros de ese autor");
        
        return $this->view->showFormDeleteAutor($autor); //muestro el formulario de borrado
    } //showDeleteAutor


} //class AutoresController





