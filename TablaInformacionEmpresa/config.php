<?php
/* Generamos las variables de la conexion a la base de datos (user 'root' sin password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'sistemaap');
 
/* Generamos la cadena de conexion a la base de datos */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Se checa la cadena de conexion a la base de datos, en caso de un error de conexion, se nos informara 
if($link === false){
    die("ERROR: Error de conexion " . mysqli_connect_error());
}
?>