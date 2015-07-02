<?php
	$cliente = $_REQUEST['cliente'];
	$fecha   = $_REQUEST['periodo'];

	$server_vende  = "104.236.137.39";
	$usuario_vende = "admin_fotos";
	$pass_vende    = "9Fdvi3D4LR";
	$db_name_vende = "admin_sistemaproductos";

	$con_vende = new mysqli($server_vende, $usuario_vende, $pass_vende, $db_name_vende)
						or die("Error " . mysqli_error($con_tecnolite));

	$query    = "SELECT * FROM metricas WHERE cliente = '$cliente' AND fecha = $fecha";
	$consulta = mysqli_query($con_vende, $query);

		while($row = mysqli_fetch_array($consulta))
			{	
				echo $row['visitas'] . "***" . $row['conversion'] . "***" . $row['ticket'];
			}
?>