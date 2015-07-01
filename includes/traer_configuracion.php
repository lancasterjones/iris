<?php
	$cliente = $_REQUEST['cliente'];

	$server_vende  = "104.236.137.39";
	$usuario_vende = "admin_fotos";
	$pass_vende    = "9Fdvi3D4LR";
	$db_name_vende = "admin_sistemaproductos";

	$con_vende = new mysqli($server_vende, $usuario_vende, $pass_vende, $db_name_vende)
						or die("Error " . mysqli_error($con_tecnolite));

	$query    = "SELECT * FROM sistema_multicliente WHERE cliente = '$cliente'";
	$consulta = mysqli_query($con_vende, $query);

		while($row = mysqli_fetch_array($consulta))
			{	
				$url_logo = $row['url_logo'];
				$url_foto = $row['url_foto'];
				$col_pedi = $row['color_pedidos'];
				$col_frau = $row['color_fraudes'];
				$col_vent = $row['color_ventas'];
			}
		echo $url_logo ."***" . $url_foto ."***" . $url_pedi ."***" . $url_frau ."***" . $url_vent;
?>