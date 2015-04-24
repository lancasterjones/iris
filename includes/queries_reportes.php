<?php

	//ventas y pedidos
	$query = "
			SELECT 
	            count(sales_flat_order.total_paid) Pedidos
	            ,sum(sales_flat_order.total_paid) Venta
	            ,WEEK(sales_flat_order.created_at) Semana
	            ,YEAR(sales_flat_order.created_at) Año
           FROM shop_production.sales_flat_order sales_flat_order
           WHERE     sales_flat_order.status IN ('complete', 'processing')
            AND YEAR(sales_flat_order.created_at) = YEAR(CURDATE())
            AND WEEK(sales_flat_order.created_at) = $semana";


     //query para fraudes

    $fraudes = "
			SELECT 
             COUNT(sales_flat_order.total_paid) AS Pedidos,
             SUM(sales_flat_order.total_paid) AS Venta,
             WEEK(sales_flat_order.created_at) AS Semana,
             YEAR(sales_flat_order.created_at) AS Año
            FROM shop_production.sales_flat_order sales_flat_order
            WHERE (    (    sales_flat_order.status IN ('riskified_declined')
              AND YEAR(sales_flat_order.created_at) = YEAR(CURDATE()))
              AND WEEK(sales_flat_order.created_at) = $semana)
          ";

?>