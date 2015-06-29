<?php

$query_tecnolite_venta = "SELECT sales_flat_order.total_paid,
			       sales_flat_order.created_at,
			       WEEK(sales_flat_order.created_at, 7) AS semana,
			       LEFT(YEARWEEK(sales_flat_order.created_at, 7), 4) AS `year`,
			       COUNT(sales_flat_order.total_paid) AS pedidos,
			       SUM(sales_flat_order.total_paid) AS monto,
			       sales_flat_order.status
			       FROM magento.sales_flat_order sales_flat_order
			       WHERE (sales_flat_order.status = 'complete')
			       GROUP BY WEEK(sales_flat_order.created_at, 7)";

			       
$query_tecnolite_fraudes = "";
$query_tecnolite_vendidos = "";
$query_tecnolite_vistos = "SELECT report_viewed_product_aggregated_monthly.views_num,
			       report_viewed_product_aggregated_monthly.product_id,
			       report_viewed_product_aggregated_monthly.period,
			       cataloginventory_stock_item.qty,
			       catalog_product_entity.sku,
			       catalog_product_entity_media_gallery.value,
			       MONTH(report_viewed_product_aggregated_monthly.period) AS mes,
			       YEAR(report_viewed_product_aggregated_monthly.period) AS `year`,
			       report_viewed_product_aggregated_monthly.rating_pos
			       FROM ((magento.cataloginventory_stock_item cataloginventory_stock_item
			       INNER JOIN magento.catalog_product_entity catalog_product_entity
			       ON (cataloginventory_stock_item.product_id = catalog_product_entity.entity_id))
			       INNER JOIN
			       magento.report_viewed_product_aggregated_monthly report_viewed_product_aggregated_monthly
			       ON     (report_viewed_product_aggregated_monthly.product_id = catalog_product_entity.entity_id)
			       AND (cataloginventory_stock_item.product_id = report_viewed_product_aggregated_monthly.product_id))
			       INNER JOIN
			       magento.catalog_product_entity_media_gallery catalog_product_entity_media_gallery
			       ON (catalog_product_entity_media_gallery.entity_id = catalog_product_entity.entity_id)
			       WHERE (`report_viewed_product_aggregated_monthly`.`rating_pos` < 11)
			       GROUP BY report_viewed_product_aggregated_monthly.product_id
			       ORDER BY 7 ASC, report_viewed_product_aggregated_monthly.rating_pos ASC";

?>