# w2_tpe1: Biblioteca

# Integrantes
  * John David Molina Velarde
  * Mateo Fleites

# Descripción
Segunda entrega del Trabajo Práctico Especial de Web 2 Tudai Grupo 66 Biblioteca.
Es una base de datos con su tabla de libros, autores y los géneros de dichos libros. Hay 2 relaciones 1 a N, tanto entre géneros y los libros y entre los autores y los libros. Además se usa una tabla de usuarios para los accesos (login).

Se muestran los datos de los libros, mostrando también los correspondientes datos del nombre del autor y del género al que el libro pertenece. En la tabla, junto a cada libro se muestran los íconos de Edición y de Borrado de dicho libro (esto sólamente se muestra si se ha logueado correctemente un usuario). Al pulsar el botón de Edición, permite editar directamente en la tabla los datos del libro, permitiendo cambiar los datos como el título y edición y permitiendo seleccionar un Género y Autor de los disponibles en la base de datos.Cuando se está editando los botones de la derecha se transforman en botones de Aceptar los cambios o Cancelar los cambios. El botón de borrado no borra directamente, sino que nos redirige a una pantalla de confirmación de dicho borrado (para evitar pulsar accidentalmente dicho botón y perder datos). En la parte inferior de la lista de libros podemos observar una barra de filtros y ordenamiento, que permite elegir en qué orden se muestra la lista, y permite filtrar la lista en base al título, autor, género y edición, funcionando ésto como un sistema de búsqueda más completo. Por último, en la parte inferior se muestra un botón para Altas de nuevos libros (este botón solo se muestra si un usuario está correctamente logueado) que nos redirige a una pantalla de ingreso de datos para el alta. 

Si hacemos click en un autor, nos redirige a una pantalla con los datos del autor y la lista de libros de dicho autor. Similarmente, si hacemos click en un género, nos filtra la lista mostrando sólamente los libros correspondientes a dicho género.

Este funcionamiento es consistente y homogéneo a todas las tablas que se muestran en el menú superior: Libros, Géneros, Autores y Usuarios (este último sólo aparece si hay un usuario correctamente logueado). Además hay una opción del menú para hacer Login (o si un usuario ya estuviera loguedaado, la opción Logout, además de aparecer el nombre del usuario logueado a la derecha).

Al hacer click en el menú Autores se visualiza la lista de autores y su respectiva biografía. Si además hacemos click en un autor en particular, se visualiza los datos respectivos del mismo, junto con su foto (si la tuviera) y la lista de libros escritos por el mismo. El funcionamiento de la Edición, Borrado, Alta de nuevos autores y Filtrado de la tabla es similar a lo ya explicado para la lista de libros. Debe tenerse en cuenta que al borrar un autor, se verifica que no haya libros que pertenezcan a dicho autor, sino no lo permite hasta que se eliminen dichos libros o se les cambie el autor. Cuando se da de alta un autor o se modifica los datos del mismo, se puede cargar una imagen de dicho autor.

La opción Géneros del menú superior muestra la lista de géneros respectivos. Al hacer click en un género en particular, muestra la lista de libros correspondientes a dicho género. La Edición, Borrado y Alta de nuevos géneros es similar a lo ya explicado para los libros. Debe tenerse en cuenta que para el borrado de un género se verifica que no haya libros que pertenezcan a dicho género, sino no lo permite hasta que se borren dichos libros o se les cambie el género. 

La opción Usuario del menú superior sólo aparece si hay un usuario logueado. Esto muestra la lista de usuarios, permitiendo borrar usuarios, dar de alta nuevos usuarios o cambiar la clave de alguno de ellos. Debe tomarse en cuenta que no se permite borrar el último usuario (porque no habría usuarios que se pudieran loguear) ni borrar el usuario que se encuentra actualmente logueado.

  * Se incluye la opción de Config.php y AutoDeploy. 
  * Todo el sistema usa el patrón MVC. 
  * Los HTML se muestran con plantillas PHTML. 
  * Las url son semánticas. 
  * Se incluye el SQL para la instalación de la base de datos (si no se desa usar el AutoDeploy)
  * Se incluye un usario "webadmin" con clave "admin"

# Tablas
La tabla libro contiene:
  * idlibro (que es la clave Primaria, es autoincremental)
  * titulo
  * idautor (clave foránea que se vincula con la tabla de autores)
  * idgenero (clave foránea que se vincula con la tabla de géneros)
  * edicion

La tabla autor contiene:
  * idautor (que es la clave Primaria, es autoincremental). A esta clave primaria hace referencia la clave foránea libro.idautor
  * nombre
  * biografia

La tabla genero contiene:
  * idgenero (que es la clave Primaria, es autoincremental). A esta clave primaria hace referencia la clave foránea libro.idgenero
  * genero

La tabla usuarios contiene:
  * idusuario (que es la clave Primaria, autoincrmenteal)
  * nombreusuario (es el nombre del usuario, usado para identificarse)
  * passwordhash (es el password_hash($password, PASSWORD_DEFAULT) que se almacena, no almacenamos el password por motivos de seguridad)

# Archivos incluidos
  * DER_libros.pdf: Diagrama de Entidad Relación (también se incluye la imagen del mismo al final de este readme.
  * w2_tpe_libros.sql: Script sql con la generación de la base de datos, tablas y relaciones respectivas.

# Diagrama Entidad Relación (con relaciones 1 a N)
![DER_libros](https://github.com/user-attachments/assets/86f9bdd5-c3d0-4e7d-8ca5-3bbc74afcb5e)


