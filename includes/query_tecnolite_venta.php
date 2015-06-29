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

?>