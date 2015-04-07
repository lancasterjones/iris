<?php
	$db_host = '104.236.137.39';
    $db_usuario = 'admin_fotos';
    $db_password = "9Fdvi3D4LR";
    $db_basedatos = 'admin_sistemaproductos';
    $db_tabla = 'usuarios';
    //conexión a base de datos
    define("CAN_REGISTER", "any");
	define("DEFAULT_ROLE", "member");
	define("SECURE", FALSE);    // FOR DEVELOPMENT ONLY!!!!
	// Conectar
	$conn = new mysqli($db_host, $db_user, $db_password, $db_basedatos) or die("Some error occurred during connection " . mysqli_error($conn));
	// Check connection
	if ($conn->connect_error) {
	    die("Conexión a Shampions DB falló: " . $conn->connect_error);
	}

?>