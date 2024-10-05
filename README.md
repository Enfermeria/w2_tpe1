# w2_tpe1: Biblioteca

# Integrantes
  * John David Molina Velarde
  * Mateo Fleites

# Descripción
Primer entrega del Trabajo Práctico Especial de Web 2 Tudai Grupo 66 Biblioteca.
Es una base de datos con su tabla de libros, autores y los géneros de dichos libros. Hay 2 relaciones 1 a N, tanto entre géneros y los libros y entre los autores y los libros.

# Tablas
La tabla libro contiene:
  * idlibro (que es la clave Primaria, es autoincremental)
  * titulo
  * idautor (clave foránea que se vincula con la tabla de autores)
  * idgenero (clave foránea que se vincula con la tabla de géneros)
  * edicion
  * argumento

La tabla autor contiene:
  * idautor (que es la clave Primaria, es autoincremental). A esta clave primaria hace referencia la clave foránea libro.idautor
  * nombre
  * biografia

La tabla genero contiene:
  * idgenero (que es la clave Primaria, es autoincremental). A esta clave primaria hace referencia la clave foránea libro.idgenero
  * genero

# Archivos incluidos
  * DER_libros.pdf: Diagrama de Entidad Relación (también se incluye la imagen del mismo al final de este readme.
  * w2_tpe_libros.sql: Script sql con la generación de la base de datos, tablas y relaciones respectivas.

# Diagrama Entidad Relación (con relaciones 1 a N)
![DER_libros](https://github.com/user-attachments/assets/86f9bdd5-c3d0-4e7d-8ca5-3bbc74afcb5e)
