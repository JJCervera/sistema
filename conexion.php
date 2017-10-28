<?php
// archivo único de configuración de conexión a la base de datos mysql
$hostname="localhost";  
$username="root";  
$password="sistema";  
$db = "sistemadecontrol";  
$dbh = new PDO("mysql:host=$hostname;dbname=$db", $username, $password);
?>
