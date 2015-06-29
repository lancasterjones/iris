<?php

	$server_tecnolite  = "192.241.212.235";
	$usuario_tecnolite = "root";
	$pass_tecnolite    = "u8eJ[R?5dynf9@j";
	$db_name_tecnolite = "magento";

	$con_tecnolite = new mysqli($server_tecnolite, $usuario_tecnolite, $pass_tecnolite, $db_name_tecnolite)
						or die("Error " . mysqli_error($con_tecnolite));

	if ($con_tecnolite->connect_error) {
    	die("Conexión a DB Tecnolite falló: " . $con_tecnolite->connect_error);
	} else echo "Conexión Tecnolite OK.";
?>