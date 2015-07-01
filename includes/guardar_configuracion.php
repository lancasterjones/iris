<?php
	$cliente = $_REQUEST['cliente'];
	$logo    = $_REQUEST['logo'];
    $foto    = $_REQUEST['foto']; 
    $pedidos = $_REQUEST['pedidos'];
    $fraudes = $_REQUEST['fraudes'];
    $ventas  = $_REQUEST['ventas'];

    $server_vende  = "104.236.137.39";
	$usuario_vende = "admin_fotos";
	$pass_vende    = "9Fdvi3D4LR";
	$db_name_vende = "admin_sistemaproductos";

	$con_vende = new mysqli($server_vende, $usuario_vende, $pass_vende, $db_name_vende)
						or die("Error " . mysqli_error($con_tecnolite));

    $consulta = mysqli_query($con_vende, "INSERT INTO sistema_multicliente(cliente, url_logo, url_foto, color_pedidos, color_fraudes, color_ventas) 
    										VALUES ('$cliente', '$logo', '$foto', '$pedidos', '$fraudes', '$ventas') 
    										   ON DUPLICATE KEY UPDATE url_logo = $logo, url_foto = $foto");
?>