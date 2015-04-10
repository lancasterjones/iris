<?php
	//conectar con magento
		include 'db_magento_connect.php';
	//traer información
		include 'includes/querymasvendidos.php';

    

		$query = "
		SELECT CONCAT(
          YEAR(sales_bestsellers_aggregated_daily.period),
          IF(MONTH(sales_bestsellers_aggregated_daily.period) < 10, '0', ''),
          MONTH(sales_bestsellers_aggregated_daily.period))
          AS mes,
               catalog_product_entity.sku,
               sales_bestsellers_aggregated_daily.product_price AS precio,
               catalog_product_entity_media_gallery.value AS foto,
               cataloginventory_stock_item.qty
          FROM (((((shop_production.sales_bestsellers_aggregated_daily sales_bestsellers_aggregated_daily
                    INNER JOIN
                    shop_production.catalog_product_entity catalog_product_entity
                       ON (sales_bestsellers_aggregated_daily.product_id =
                              catalog_product_entity.entity_id))
                   INNER JOIN
                   shop_production.catalog_product_relation catalog_product_relation
                      ON (catalog_product_entity.entity_id =
                             catalog_product_relation.child_id))
                  INNER JOIN
                  shop_production.catalog_product_entity catalog_product_entity_1
                     ON (catalog_product_relation.parent_id =
                            catalog_product_entity_1.entity_id))
                 INNER JOIN
                 shop_production.catalog_product_entity_media_gallery catalog_product_entity_media_gallery
                    ON (catalog_product_entity_1.entity_id =
                           catalog_product_entity_media_gallery.entity_id))
                INNER JOIN
                shop_production.catalog_product_entity_media_gallery_value catalog_product_entity_media_gallery_value
                   ON (catalog_product_entity_media_gallery.value_id =
                          catalog_product_entity_media_gallery_value.value_id))
               INNER JOIN
               shop_production.cataloginventory_stock_item cataloginventory_stock_item
                  ON (cataloginventory_stock_item.product_id =
                         catalog_product_entity.entity_id)
         WHERE     (YEARWEEK(sales_bestsellers_aggregated_daily.period) >
                       YEARWEEK(CURDATE()) - 12)
               AND (sales_bestsellers_aggregated_daily.qty_ordered > 1)
               AND (catalog_product_entity_media_gallery_value.position = 1)
        GROUP BY CONCAT(
                    YEAR(sales_bestsellers_aggregated_daily.period),
                    IF(MONTH(sales_bestsellers_aggregated_daily.period) < 10,
                       '0',
                       ''),
                    MONTH(sales_bestsellers_aggregated_daily.period)),
                 catalog_product_entity.sku
        ORDER BY 1 DESC, sales_bestsellers_aggregated_daily.qty_ordered DESC";
		

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