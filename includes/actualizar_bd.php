<?php

	//conectar con magento
		include 'db_magento_connect.php';
    //include 'db_magento_tecnolite.php';

	//traer información
		include 'querymasvendidos.php';
    include 'querymasvistos.php';
    include 'queries_reportes.php';
    include 'query_tecnolite_venta.php';

		
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
      $contenedor[$z][14] = $row_reportes['Year'];
      $contenedor[$z][15] = $row_reportes['fraudes'];
      $z++;
    }

	//imprimir esa información
		/*print_r($contenedor);
		echo $contenedor;*/

	 //conectar bd vende
    $con = mysqli_connect("104.236.137.39","admin_fotos","9Fdvi3D4LR","admin_sistemaproductos");

    // Log de Errores
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }else{ echo "Conexion MySql Vende Ok";}

    $year_act = date('Y');
    $week_act = date('W')-5;

    //Se elimina información en tabla masVendidos y masVistos server VENDE 
    mysqli_query($con,"TRUNCATE TABLE mas_vendidos");
    mysqli_query($con,"TRUNCATE TABLE mas_vistos");

    mysqli_query($con, "DELETE FROM magento_venta 
                        WHERE year = $year_act AND week > $week_act");

	 //--------------------------------Actualizar LOB---------------------------------------------------------
      foreach ($contenedor as list($sku, $mes, $precio, $foto, $cantidad, 
        $modelo, $month, $price, $vistas, $qty, $pic, 
        $pedidos, $venta, $semana, $year, $fraudes))
    {
        mysqli_query($con,"INSERT INTO mas_vendidos(sku, mes, precio, foto, cantidad, cliente) 
                            VALUES ('$sku', '$mes', '$precio', '$foto', '$cantidad', 'LOB')");

        mysqli_query($con, "INSERT INTO mas_vistos(modelo, mes, precio, vistas, qty, foto, cliente) 
                            VALUES ('$modelo', '$month', '$price', '$vistas', '$qty', '$pic', 'LOB') ");

        mysqli_query($con, "INSERT INTO magento_venta(pedidos, cantidad, week, cliente, year, fraudes) 
                            VALUES ('$pedidos', '$venta', '$semana', 'LOB', '$year', '$fraudes')");
       
    }

    // -----------------------------Actualizar Tecnolite---------------------------------------------------

    $server_tecnolite  = "192.241.212.235";
  $usuario_tecnolite = "iris";
  $pass_tecnolite    = "iris";
  $db_name_tecnolite = "magento";

  $con_tecnolite = new mysqli($server_tecnolite, $usuario_tecnolite, $pass_tecnolite, $db_name_tecnolite)
            or die("Error " . mysqli_error($con_tecnolite));


if ($con_tecnolite->connect_error) {
      die("Conexion a DB Tecnolite fallo: " . $con_tecnolite->connect_error);
  } else echo "Conexion Tecnolite OK.";

    $consulta_tecnolite = mysqli_query($con_tecnolite, $query_tecnolite_venta);
    while($row_tecnolite = mysqli_fetch_array($consulta_tecnolite))
    {
        $year  = $row_tecnolite['year'];
        $sem   = $row_tecnolite['semana'];;
        $qty   = $row_tecnolite['pedidos'];;
        $monto = $row_tecnolite['monto'];;
        echo "Tecnolite " . $year . " " . $sem . " " . $monto . " -- " ; 
        mysqli_query($con, "INSERT INTO magento_venta(pedidos, cantidad, week, cliente, year)
                            VALUES ('$qty', '$monto', '$sem', 'TECNOLITE', '$year')");
    }

    /*$consulta_tecnolite_vistos   = mysqli_query($con_tecnolite, $query_tecnolite_vistos);
    while($row_tecnolite_vistos = mysqli_fetch_array($consulta_tecnolite_vistos))
    {
        $year  = $row_tecnolite['year'];
        $sem   = $row_tecnolite['semana'];;
        $qty   = $row_tecnolite['pedidos'];;
        $monto = $row_tecnolite['monto'];;
        echo "Tecnolite " . $year . " " . $sem . " " . $monto . " -- " ; 
        mysqli_query($con, "INSERT INTO mas_vistos(modelo, mes, precio, vistas, qty, foto, cliente) 
                            VALUES ('$qty', '$monto', '$sem', 'TECNOLITE', '$year')");
    }

    $consulta_tecnolite_fraudes  = mysqli_query($con_tecnolite, $query_tecnolite_fraudes);

    $consulta_tecnolite_vendidos = mysqli_query($con_tecnolite, $query_tecnolite_vendidos);
    while($row_tecnolite_vendidos = mysqli_fetch_array($consulta_tecnolite_vendidos))
    {
        $year  = $row_tecnolite['year'];
        $sem   = $row_tecnolite['semana'];;
        $qty   = $row_tecnolite['pedidos'];;
        $monto = $row_tecnolite['monto'];;
        echo "Tecnolite " . $year . " " . $sem . " " . $monto . " -- " ; 
        mysqli_query($con, "INSERT INTO mas_vendidos(sku, mes, precio, foto, cantidad, cliente) 
                            VALUES ('$qty', '$monto', '$sem', 'TECNOLITE', '$year')");
    }*/
    

	
?>