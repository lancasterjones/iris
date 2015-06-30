<?php
 	$server_tecnolite  = "192.241.212.235";
    $usuario_tecnolite = "iris";
    $pass_tecnolite    = "iris";
    $db_name_tecnolite = "magento";

    $con_tecnolite = new mysqli($server_tecnolite, $usuario_tecnolite, $pass_tecnolite, $db_name_tecnolite)
              or die("Error " . mysqli_error($con_tecnolite));


    if ($con_tecnolite->connect_error) {
          die("Conexion a DB Tecnolite fallo: " . $con_tecnolite->connect_error);
      } else echo "Conexion Tecnolite OK.";
?>