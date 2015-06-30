<?php
$servername = "54.215.253.12";
$username = "databaseread";
$password = "N46g3ta6skXqbete";
$db = "shop_production";

// Conectar
$connm = new mysqli($servername, $username, $password, $db) 
or die("Error al conectar a Magento " . mysqli_error($connm));
// Check connection
if ($connm->connect_error) {
    die("Conexión a DB Sistema Productos falló: " . $connm->connect_error);
} 

?>