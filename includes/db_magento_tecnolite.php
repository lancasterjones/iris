<?php
 	$server_tecnolite  = "192.241.212.235";
    $usuario_tecnolite = "iris";
    $pass_tecnolite    = "iris";
    $db_name_tecnolite = "magento";

   /* $con_tecnolite = new mysqli($server_tecnolite, $usuario_tecnolite, $pass_tecnolite, $db_name_tecnolite)
              or die("Error " . mysqli_error($con_tecnolite));


    if ($con_tecnolite->connect_error) {
          die("Conexion a DB Tecnolite fallo: " . $con_tecnolite->connect_error);
      } else echo "Conexion Tecnolite OK.";
*/

try {
    $conn = new PDO("mysql:host=$server_tecnolite;dbname=$db_name_tecnolite", $usuario_tecnolite, $pass_tecnolite);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>