<?php
	$cliente = $_REQUEST['cliente'];
	$fecha   = $_REQUEST['fecha'];
    $visitas = $_REQUEST['visitas']; 
    $ticket  = $_REQUEST['ticket'];
    $conversion = $_REQUEST['conversion'];

    $server_vende  = "104.236.137.39";
	$usuario_vende = "admin_fotos";
	$pass_vende    = "9Fdvi3D4LR";
	$db_name_vende = "admin_sistemaproductos";

	$con_vende = new mysqli($server_vende, $usuario_vende, $pass_vende, $db_name_vende)
						or die("Error " . mysqli_error($con_tecnolite));

    $consulta = mysqli_query($con_vende, "INSERT INTO metricas(cliente, fecha, visitas, ticket, conversion) 
    										VALUES ('$cliente', '$fecha', '$visitas', '$ticket', '$conversion') 
    										   ON DUPLICATE KEY UPDATE visitas = '$visitas', ticket = '$ticket', conversion = '$conversion'");
?>