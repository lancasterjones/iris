<?php

	$server  = "192.241.212.235";
	$usuario = "root";
	$pass    = "u8eJ[R?5dynf9@j";
	$db_name = "magento";

	$con_tecnolite = new mysqli($server, $usuario, $pass, $db_name)
						or die("Error " . mysqli_error($con_tecnolite));

?>