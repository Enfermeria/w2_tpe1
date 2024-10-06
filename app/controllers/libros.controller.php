<?php
require_once "app/models/libros.model.php";
require_once "app/models/autores.model.php";
require_once "app/models/generos.model.php";
require_once "app/views/libros.view.php";
require_once "app/views/general.view.php";

class LibrosController{
    private $modelLibro;
    private $modelGenero;
    private $modelAutor;
    private $view;
    private $generalView;

    public function __construct() {
        $this->modelLibro = new LibrosModel();
        $this->modelGenero = new GenerosModel();
        $this->modelAutor = new AutoresModel();
        $this->view  = new LibrosView();
        $this->generalView = new GeneralView();
    } //__construct


    /******************************************************************************************/
    /***                                    LOGICA                                          ***/
    /******************************************************************************************/
    function addRegister() {
        //verifico si todos los campos están
        if (!isset($_POST['titulo']) || empty($_POST['titulo']))
            return $this->generalView->showError('Falta completar el título del libro');
        if (!isset($_POST['idautor']) || empty($_POST['idautor']))
            return $this->generalView->showError('Falta completar el idautor del libro');
        if (!isset($_POST['idgenero']) || empty($_POST['idgenero'])) 
            return $this->generalView->showError('Falta completar el idgenero del libro');
        if (!isset($_POST['edicion']) || empty($_POST['edicion'])) 
            return $this->generalView->showError('Falta completar la edición del libro');
    
        //obtengo los datos de los campos Posteados
        $titulo = $_POST['titulo'];
        $idAutor = $_POST['idautor'];
        $idGenero = $_POST['idgenero'];
        $edicion = $_POST['edicion'];

        //verifico si existe ese idgenero en la bd
        $genero = $this->modelGenero->get($idGenero); //obtengo el genero por id
        if (!$genero)  //si el registro no existe, devuelve un false, sino devuelve el objeto con el genero
            return $this->generalView->showError("No existe el género con el idgenero=$idGenero");
    
        //verifico si existe ese idautor en la bd
        $autor = $this->modelAutor->get($idAutor); //obtengo el autor por id
        if (!$autor)  //si el registro no existe, devuelve un false, sino devuelve el objeto con el genero
            return $this->generalView->showError("No existe el autor con el idautor=$idAutor");
    
        //inserto los datos en la bd.
        $id = $this->modelLibro->insert($titulo, $idAutor, $idGenero, $edicion);
    
        //redirijo al home
        header('Location: ' . BASE_URL);
    } //addRegister
    
    
    function editRegister($idLibro) {
        //verifico si todos los campos están
        if (!isset($_POST['titulo']) || empty($_POST['titulo']))
            return $this->generalView->showError('Falta completar el título del libro');
        if (!isset($_POST['idautor']) || empty($_POST['idautor']))
            return $this->generalView->showError('Falta completar el idautor del libro');
        if (!isset($_POST['idgenero']) || empty($_POST['idgenero'])) 
            return $this->generalView->showError('Falta completar el idgenero del libro');
        if (!isset($_POST['edicion']) || empty($_POST['edicion'])) 
            return $this->generalView->showError('Falta completar la edición del libro');
    
        //obtengo los datos de los campos Posteados
        $titulo = $_POST['titulo'];
        $idAutor = $_POST['idautor'];
        $idGenero = $_POST['idgenero'];
        $edicion = $_POST['edicion'];

        //verifico si existe ese idgenero en la bd
        $genero = $this->modelGenero->get($idGenero); //obtengo el genero por id
        if (!$genero)  //si el registro no existe, devuelve un false, sino devuelve el objeto con el genero
            return $this->generalView->showError("No existe el género con el idgenero=$idGenero");
    
        //verifico si existe ese idautor en la bd
        $autor = $this->modelAutor->get($idAutor); //obtengo el autor por id
        if (!$autor)  //si el registro no existe, devuelve un false, sino devuelve el objeto con el genero
            return $this->generalView->showError("No existe el autor con el idautor=$idAutor");
    
        //verifico si existe ese idlibro en la bd
        $libro = $this->modelLibro->get($idLibro); //obtengo el libro por id
        if (!$libro)  //si el registro no existe, devuelve un false, sino devuelve el objeto con el libro
            return $this->generalView->showError("No existe el libro con el idlibro=$idLibro");
    
    
        //modifico ese registro en la bd
        $id = $this->modelLibro->update($idLibro, $titulo, $idAutor, $idGenero, $edicion);
    
        //redirijo al home
        header('Location: ' . BASE_URL);
    } //editRegister
    
    
    function deleteRegister($idLibro) {
        // verifico si existe ese id en la bd
        $libro = $this->modelLibro->get($idLibro);// obtengo la tarea por id
        if (!$libro) // si el registro no existe, devuelve un false, sino devuelve el objeto con la libro
            return $this->generalView->showError("No existe el libro con el idlibro=$idLibro");
        
        // borro ese registro en la bd
        $this->modelLibro->delete($idLibro);
    
        //redirijo al home
        header('Location: ' . BASE_URL);
    } //deleteRegister

    
    /******************************************************************************************/
    /***                                    PANTALLAS                                       ***/
    /******************************************************************************************/

    function showLibros(){ //muestro las libros según el filtro
        //obtengo los campos POST del filtro
        $filtro = new stdClass();               
        if (!isset($_POST['cbordenar']) || empty($_POST['cbordenar']))
            $filtro->cbordenar = "sin orden";
        else 
            $filtro->cbordenar = $_POST['cbordenar'];

        // verifico el orden
        switch ($filtro->cbordenar){
            case 'sin orden':
                $filtro->orden = 'idlibro';
            case 'por titulo':
                $filtro->orden = "titulo";
                break;
            case 'por autor':
                $filtro->orden = 'nombre';
                break;
            case 'por genero':
                $filtro->orden = 'genero';
                break;
            default:
                return $this->generalView->showError('cb ordenar con valor no válido');
                break;
        }
    
        if (!isset($_POST['cbfiltrar']) || empty($_POST['cbfiltrar']))
            $filtro->cbfiltrar = "no filtrar";
        else
            $filtro->cbfiltrar = $_POST['cbfiltrar'];

        if (!isset($_POST['txtfiltro']) || empty($_POST['txtfiltro']))
            $filtro->txtfiltro = "";
        else
            $filtro->txtfiltro = $_POST['txtfiltro']; 


        //aplico filtro
        switch ($filtro->cbfiltrar){  // veo que filtro aplico
            case 'no filtrar':
                $libros = $this->modelLibro->getAll($filtro->orden);
                return $this->view->showLibros($libros, $filtro); 
                break;
            case 'por titulo':
                $libros = $this->modelLibro->getFiltradoPorTitulo($filtro->txtfiltro, $filtro->orden);
                return $this->view->showLibros($libros, $filtro);
                break;
            case 'por autor':
                $libros = $this->modelLibro->getFiltradoPorAutor($filtro->txtfiltro, $filtro->orden);
                return $this->view->showLibros($libros, $filtro);
                break;
            case 'por genero':
                $libros = $this->modelLibro->getFiltradoPorGenero($filtro->txtfiltro, $filtro->orden);
                return $this->view->showLibros($libros, $filtro);
                break;
            case 'edicion mayor':
                $libros = $this->modelLibro->getFiltradoPorEdicionMayor($filtro->txtfiltro, $filtro->orden);
                return $this->view->showLibros($libros, $filtro);
                break;
            case 'edicion igual':
                $libros = $this->modelLibro->getFiltradoPorEdicionIgual($filtro->txtfiltro, $filtro->orden);
                return $this->view->showLibros($libros, $filtro);
                break;
            case 'edicion menor':
                $libros = $this->modelLibro->getFiltradoPorEdicionMenor($filtro->txtfiltro, $filtro->orden);
                return $this->view->showLibros($libros, $filtro);
                break;
            case 'edicion menor o igual':
                $libros = $this->modelLibro->getFiltradoPorEdicionMenorOIgual($filtro->txtfiltro, $filtro->orden);
                return $this->view->showLibros($libros, $filtro);
                break;
            case 'edicion mayor o igual':
                $libros = $this->modelLibro->getFiltradoPorEdicionMayorOIgual($filtro->txtfiltro, $filtro->orden);
                return $this->view->showLibros($libros, $filtro);
                break;
            default:
                $this->generalView->showError('cb filtrar con valor no válido');
                break;
        }
    } // showLibros


    function showLibrosxGenero($idGenero){ //muestra los libros de ese género usando el filtro respectivo
        $genero = $this->modelGenero->get($idGenero); //verifico si existe ese id en la bd
        if (!$genero) { // si el registro no existe, devuelve un false, sino devuelve el objeto con el registro
            return $this->generalView->showError("No existe el género con el idGenero=$idGenero");
        }
             
        //armo el filtro
        $filtro = new stdClass();
        $filtro->cbfiltrar = "por genero";
        $filtro->txtfiltro = $genero->genero;
        $filtro->cbordenar = "sin orden";
        $filtro->orden = "idlibro";

        // obtengo la lista de libros y la muestro
        $libros = $this->modelLibro->getFiltradoPorGenero($filtro->txtfiltro, $filtro->orden);
        return $this->view->showLibros($libros, $filtro);
    } //showLibrosxGenero


    function showLibrosXAutor($idAutor) {
        $autor = $this->modelAutor->get($idAutor);
        if (!$autor)  //si el registro no existe, devuelve un false, sino devuelve el objeto con el registro
            return $this->generalView->showError("No existe el autor con el idAutor=$idAutor");

        // obtengo la lista de libros y la muestro
        $libros = $this->modelLibro->getPorAutor($idAutor);

        return $this->view->showLibrosXAutor($libros, $autor);
    } //showUnAutor
    


    function showAddLibro(){ // muestro un formulario para ingresar el alta de una libro
        $libros  = $this->modelLibro->getAll();     //obtengo las libros
        $autores = $this->modelAutor->getAll(); 
        $generos = $this->modelGenero->getAll();   
        return $this->view->showFormAddLibro($autores, $generos);    //muestro el formulario de alta
    } // showAddLibro


    function showEditLibro($idLibro){ // muestro un formulario para editar una libro
        $libro = $this->modelLibro->get($idLibro); //verifico si existe ese id en la bd
        if (!$libro) { //si el registro no existe, devuelve un false, sino devuelve el objeto con el registro
            return $this->generalView->showError("No existe el libro con el idlibro=$idLibro");
        }
        
        $libros = $this->modelLibro->getAll();                //obtengo las libros de la DB
        $autores = $this->modelAutor->getAll();
        $generos = $this->modelGenero->getAll();
        return $this->view->showFormEditLibro($idLibro, $libros, $autores, $generos);  //muestro el formulario de edicion
    } // showEditLibro


    function showDeleteLibro($idLibro){ // muestro un formulario para confirmar el borrado de una libro
        $libro = $this->modelLibro->get($idLibro); //verifico si existe ese id en la bd
        if (!$libro) { // si el registro no existe, devuelve un false, sino devuelve el objeto con el registro
            return $this->generalView->showError("No existe la libro con el idlibro=$idLibro");
        }
             
        return $this->view->showFormDeleteLibro($libro); //muestro el formulario de borrado
    } //showDeleteLibro


} // class LibrosController




