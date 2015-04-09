<?php
	//conectar con magento
		include 'includes/db_magento_connect.php';
	//traer información
		include 'includes/querymasvendidos.php';


		$servername = "54.215.253.12";
$username = "databaseread";
$password = "N46g3ta6skXqbete";
$db = "shop_production";

// Conectar
$connm = new mysqli($servername, $username, $password, $db) or die("Error al conectar a Magento " . mysqli_error($connm));
// Check connection
if ($connm->connect_error) {
    die("Conexión a DB Sistema Productos falló: " . $connm->connect_error);
} else
{
	echo "conexión correcta!";
}


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
		$contenedor = array();
		$result = mysqli_query($connm,$query);		
		$consulta = mysqli_fetch_array($result);
		while ($consulta) {
			$contenedor = $consulta;
		}
		

	//imprimir esa información
		print_r($contenedor);
		echo $contenedor;

	//conectar bd vende



	//llenar tabla vende con arreglo
	
?>