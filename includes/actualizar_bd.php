<?php

	//conectar con magento
		include 'db_magento_connect.php';

	//traer información
		include 'querymasvendidos.php';
    include 'querymasvistos.php';
    include 'queries_reportes.php';

		
	//almacenar esa info en arreglo
		$contenedor = array(array());
    //query mas vendidos
		$result = mysqli_query($connm,$query);		
    //query mas vistos
    $result_masvistos = mysqli_query($connm, $sql);

    //resultado de query reportes
    $result_reportes = mysqli_query($connm, $query_reportes);
    $contador = 0;

    //ciclo para almacenar mas vendidos
		
		while ($consulta = mysqli_fetch_array($result)) {
			$contenedor[$contador][0] = $consulta['sku'];
      $contenedor[$contador][1] = $consulta['mes'];
      $contenedor[$contador][2] = $consulta['precio'];
      $contenedor[$contador][3] = $consulta['foto'];
      $contenedor[$contador][4] = $consulta['qty'];
      $contador++;
		}
    //contador del ciclo
		$c = 0;
    //ciclo para almacenar mas vistos
    while($row_vistos = mysqli_fetch_array($result_masvistos)){
      $contenedor[$c][5] = $row_vistos['modelo'];
      $contenedor[$c][6] = $row_vistos['mes'];
      $contenedor[$c][7] = $row_vistos['precio'];
      $contenedor[$c][8] = $row_vistos['vistas'];
      $contenedor[$c][9] = $row_vistos['qty'];
      $contenedor[$c][10] = $row_vistos['foto'];
      $c++;
    }

    $z = 0; //contador de ciclo
    while($row_reportes = mysqli_fetch_array($result_reportes)){
      $contenedor[$z][11] = $row_reportes['Pedidos'];
      $contenedor[$z][12] = $row_reportes['Venta'];
      $contenedor[$z][13] = $row_reportes['Semana'];
      $z++;
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

    //Se elimina información en tabla masVendidos y masVistos server VENDE 
    mysqli_query($con,"TRUNCATE TABLE mas_vendidos");
    mysqli_query($con,"TRUNCATE TABLE mas_vistos");
    mysqli_query($con, "TRUNCATE TABLE magento_venta");

	 //llenar tabla vende con arreglo
      foreach ($contenedor as list($sku, $mes, $precio, $foto, $cantidad, $modelo, $month, $price, $vistas, $qty, $pic, $pedidos, $venta, $semana))
    {
        mysqli_query($con,"INSERT INTO mas_vendidos(sku, mes, precio, foto, cantidad) VALUES ('$sku', '$mes', '$precio', '$foto', '$cantidad')");
        mysqli_query($con, "INSERT INTO mas_vistos(modelo, mes, precio, vistas, qty, foto) VALUES ('$modelo', '$month', '$price', '$vistas', '$qty', '$pic') ");
        mysqli_query($con, "INSERT INTO magento_venta(pedidos) VALUES ('$pedidos')" );
    }

	
?>