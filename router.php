<?php
/* 
                                TPE - Parte 2
Consigna
    Para la segunda etapa del trabajo, se dará continuidad al desarrollo del sitio web dinámico
    basado en el modelo de datos propuesto en la primera entrega.
    El sitio debe cumplir con los siguientes requerimientos:


                         Requerimientos Funcionales
                         ==========================
                                                
Acceso público
--------------
    Deben existir diferentes secciones donde se muestre el contenido dinámicamente
    generado desde la base de datos. Estas secciones pueden ser accedidas de manera
    pública, no es necesario loguearse.
        ● (A) Listado de ítems: Se debe poder visualizar todos los ítems cargados
        ● (A) Detalle de ítem: Se debe poder navegar y visualizar cada ítem particularmente
        ● (B) Listado de categorías: Se debe poder visualizar un listado con todas las
              categorías cargadas
        ● (B) Listado de ítems por categoría: Se debe poder visualizar los ítems
              perteneciente a una categoría seleccionada

    Importante: En cada ítem siempre se debe mostrar el nombre de la categoría a la que
    pertenece.


Acceso administrador de datos
-----------------------------
    Debe existir una sección para la administración de datos, la cual es accedida solo a
    usuarios administradores del sitio.
        ● (A) El usuario administrador debe loguearse con usuario y contraseña.
            ○ Debe exisitir al menos un administrador con usuario “webadmin” y
              contraseña “admin” para pruebas.
        ● (B) El usuario debe poder desloguearse (logout)
        ● Solo los usuarios logueados pueden modificar las categorías y los ítems.


    Se debe crear servicios de ABM (alta/baja/modificación) para administrar los datos:
        (A) Administrar Ítems (entidad del lado N de la relación).
            ● Lista de Items (Noticias/Productos/…)
            ● Agregar Items (Noticias/Productos/…)
            ● Eliminar Items (Noticias/Productos/…)
            ● Editar Items (Noticias/Productos/…)

    Importante: Al agregar Items (Noticias/Productos/…) se debe poder elegir la
    categoría a la que pertenecen utilizando un select que muestre el nombre de la
    misma.

        (B) Administrar Categorías (entidad del lado 1 de la relación)
            ● Lista de Categorías
            ● Agregar Categorías
            ● Eliminar Categorias
            ● Editar Categorías.
            ● Se puede subir una foto cuando se crea el ítem o categoría.


Base de datos
-------------
    El sistema debe acceder a la base de datos a partir de las constantes definidas en un
    config.php. Si la base no existe debe crearse y llenarse con datos iniciales
    automáticamente. (Ver Config & Auto deploy )


                        Requerimientos Técnicos (no funcionales)
                        ========================================

        ● Todos los HTML deben mostrarse utilizando plantillas (phtml o Smarty)**.
        ● Todas las acciones realizadas en la página deben estar manejadas utilizando el
        patrón MVC.
        ● Las URL deben ser semánticas.
        ● El sitio debe incluir el archivo sql para instalar la base de datos.
        
        
Notas
    *   Autenticación y seguridad: Se recomienda comenzar con la sección “privada” sin
        autenticación. Una vez dada la clase de seguridad es muy sencillo protegerlo con usuario y
        contraseña.
    **  Vistas: Se recomienda mantener una UI muy sencilla hasta que se dé la clase de
        Templates.


                            Pautas de corrección
                            ====================

IMPORTANTE: Los estudiantes serán evaluados individualmente según se cumplan los
            criterios que le fueron asignados según la planilla de la Libro en los requisitos marcados
            como (A) o (B). Si la primera entrega se realizó individualmente, el estudiante debe hacer el
            trabajo completo

            Se considera fundamental la aplicación de buenas prácticas, y la elección apropiada de
            cada tecnología para cada punto a resolver. Hacer prácticas marcadas como malas se
            considera motivo de pérdida de promoción y de puntaje de cursada. Se evaluará la correcta
            división de responsabilidades en las clases, no repetición de código, identificadores
            (nombres de clases, variables, etc) descriptivos, etc.

Entrega:    18 DE OCTUBRE
            La entrega se realizará utilizando el mismo repositorio público GIT de la entrega
            anterior. Solo se tomarán en cuenta commits previos al día de la entrega.

            Se debe agregar al README.md una breve explicación de cómo desplegar el sitio en
            un servidor con Apache y MySQL, como también cualquier información necesaria para
            su uso, como pueden ser usuarios y contraseñas de administrador.

*/

require_once './app/controllers/libros.controller.php';
require_once './app/controllers/generos.controller.php';
require_once './app/controllers/autores.controller.php';
require_once './app/controllers/login.controller.php';

session_start(); //inicia la sesión para manejar el login/logout

// base_url para redirecciones y base tag
define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

$action = 'showLibros'; // accion por defecto si no se envia ninguna
if (!empty( $_GET['action'])) {
    $action = $_GET['action'];
}


//                          TABLA DE RUTEO
//======================================================================================
//           URL                                LLAMADO
//======================================================================================
// showLibros                       LibrosController->showLibros();
// showLibrosxGenero/:idGenero      LibrosController->showLibrosxGenero($idGenero);
// showLibrosxAutor/:idAutor        LibrosController->showLibrosxAutor($idAutor);
// showAddLibro                     LibrosController->showAddLibro();
// addLibro                         LibrosController->addRegister();
// showEditLibro/:idLibro           LibrosController->showEditLibro($idLibro);
// editLibro/:idLibro               LibrosController->editRegister($idLibro);
// showDeleteLibro/:idLibro         LibrosController->showDeleteLibro($idLibro);
// deleteLibro:/:idLibro            LibrosController->deleteRegistro($idLibro);
//======================================================================================
// showGeneros                      GenerosController->showGeneros();
// showAddGenero                    GenerosController->showAddGenero();
// addGenero                        GenerosController->addRegister();
// showEditGenero/:idGenero         GenerosController->showEditGenero($idGenero);
// editGenero/:idGenero             GenerosController->editRegister($idGenero);
// showDeleteGenero/:idGenero       GenerosController->showDeleteGenero($idGenero);
// deleteGenero/:idGenero           GenerosController->deleteRegistro($idGenero);
//======================================================================================
// showAutores                      AutoresController->showAutores();
// showAddAutor                     AutoresController->showAddAutor();
// addAutor                         AutoresController->addRegister();
// showEditAutor/:idAutor           AutoresController->showEditAutor($idAutor);
// editAutor/:idAutor               AutoresController->editRegister($idAutor);
// showDeleteAutor/:idAutor         AutoresController->showDeleteAutor($idAutor);
// deleteAutor/:idAutor             AutoresController->deleteRegistro($idAutor);
//======================================================================================



// parsea la accion para separar accion real de parametros
$params = explode('/', $action);

switch ($params[0]) {
    /******************* Libros ********************/
    case 'showLibros':
        $controllerLibro = new LibrosController();
        $controllerLibro -> showLibros();
        break;
    case 'showLibrosxGenero':
        $controllerLibro = new LibrosController();
        $controllerLibro -> showLibrosxGenero($params[1]);
        break;
    case 'showLibrosxAutor':
        $controllerLibro = new LibrosController();
        $controllerLibro -> showLibrosXAutor($params[1]);
        break;

    case 'showAddLibro':
        $controllerLibro = new LibrosController();
        $controllerLibro -> showAddLibro();
        break;
    case 'addLibro':
        if(isset($_SESSION['idusuario'])) {
             $controllerLibro = new LibrosController();
            $controllerLibro -> addRegister();
        }
        else{
            header("Location: ".BASE_URL."login");
        }
        break;
    
    case 'showEditLibro':
        $controllerLibro = new LibrosController();
        $controllerLibro->showEditLibro($params[1]);
        break; 
    case 'editLibro':
        if(isset($_SESSION['idusuario'])) {
            $controllerLibro = new LibrosController();
            $controllerLibro->editRegister($params[1]);
        }
        else{
            header("Location: ".BASE_URL."login");
        }
        break; 

    case 'showDeleteLibro':
        $controllerLibro = new LibrosController();
        $controllerLibro->showDeleteLibro($params[1]);
        break;
    case 'deleteLibro':
        if(isset($_SESSION['idusuario'])) {
            $controllerLibro = new LibrosController();
            $controllerLibro->deleteRegister($params[1]);
        }
        else{
            header("Location: ".BASE_URL."login");
        }
        break;


    /******************* Autores ********************/
    case 'showAutores':
        $controllerAutor = new AutoresController();
        $controllerAutor -> showAutores();
        break;

    case 'showAddAutor':
        $controllerAutor = new AutoresController();
        $controllerAutor -> showAddAutor();
        break;
    case 'addAutor':
        if(isset($_SESSION['idusuario'])) {
            $controllerAutor = new AutoresController();
            $controllerAutor -> addRegister();
        }
        else{
            header("Location: ".BASE_URL."login");
        }
        break;
    
    case 'showEditAutor':
        $controllerAutor = new AutoresController();
        $controllerAutor->showEditAutor($params[1]);
        break; 
    case 'editAutor':
        if(isset($_SESSION['idusuario'])) {
            $controllerAutor = new AutoresController();
            $controllerAutor->editRegister($params[1]);
        }
        else{
            header("Location: ".BASE_URL."login");
        }
        break; 

    case 'showDeleteAutor':
        $controllerAutor = new AutoresController();
        $controllerAutor->showDeleteAutor($params[1]);
        break;
    case 'deleteAutor':
        if(isset($_SESSION['idusuario'])) {
            $controllerAutor = new AutoresController();
            $controllerAutor->deleteRegister($params[1]);
        }
        else{
            header("Location: ".BASE_URL."login");
        }
        break;

        
    /******************* Generos ********************/
    case 'showGeneros':
        $controllerGenero = new GenerosController();
        $controllerGenero -> showGeneros();
        break;

    case 'showAddGenero':
        $controllerGenero = new GenerosController();
        $controllerGenero -> showAddGenero();
        break;
    case 'addGenero':
        if(isset($_SESSION['idusuario'])) {
            $controllerGenero = new GenerosController();
            $controllerGenero -> addRegister();
        }
        else{
            header("Location: ".BASE_URL."login");
        }
        break;
    
    case 'showEditGenero':
        $controllerGenero = new GenerosController();
        $controllerGenero->showEditGenero($params[1]);
        break; 
    case 'editGenero':
        if(isset($_SESSION['idusuario'])) {
            $controllerGenero = new GenerosController();
            $controllerGenero->editRegister($params[1]);
        }
        else{
            header("Location: ".BASE_URL."login");
        }
        break; 

    case 'showDeleteGenero':
        $controllerGenero = new GenerosController();
        $controllerGenero->showDeleteGenero($params[1]);
        break;
    case 'deleteGenero':
        if(isset($_SESSION['idusuario'])) { //verifica que el usuario este logueado
            $controllerGenero = new GenerosController();
            $controllerGenero->deleteRegister($params[1]);
        }
        else { //si no lo está, lo lleva al login
            header("Location: ".BASE_URL."login");
        }
        break;
    
    /******************* LOGIN **************/

    case 'login':
        $controllerLogin = new LoginController();
        $controllerLogin->showLogin();
        break;

    case 'validarlogin':
        $controllerLogin = new LoginController();
        $controllerLogin->validateLogin();
        break;

    case 'logout':
        $controllerLogin = new LoginController();
        $controllerLogin->logOut();
        break;

    default: 
        echo "404 Page Not Found";
        break;
}