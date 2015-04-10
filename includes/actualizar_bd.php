<?php
	//conectar con magento
		include 'db_magento_connect.php';
	//traer información
		include 'querymasvendidos.php';
    include 'querymasvistos.php';

		
	//almacenar esa info en arreglo
		$contenedor = array(array());
		$result = mysqli_query($connm,$query);		
    $contador = 0;
		
		while ($consulta = mysqli_fetch_array($result)) {
			$contenedor[$contador][0] = $consulta['sku'];
      $contenedor[$contador][1] = $consulta['mes'];
      $contenedor[$contador][2] = $consulta['precio'];
      $contenedor[$contador][3] = $consulta['foto'];
      $contenedor[$contador][4] = $consulta['qty'];
      $contador++;
		}
		

	//imprimir esa información
		print_r($contenedor);
		echo $contenedor;

	//conectar bd vende
    $con=mysqli_connect("104.236.137.39","admin_fotos","9Fdvi3D4LR","admin_sistemaproductos");

    // Log de Errores
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }else{ echo "Conexion MySql Ok";}

    //Se elimina información en tabla envios server VENDE 
    mysqli_query($con,"TRUNCATE TABLE mas_vendidos");

	 //llenar tabla vende con arreglo
      foreach ($contenedor as list($sku, $mes, $precio, $foto, $cantidad))
    {
        mysqli_query($con,"INSERT INTO mas_vendidos(sku, mes, precio, foto, cantidad) VALUES ('$sku', '$mes', '$precio', '$foto', '$cantidad')");
    }

	
?>