<?php

	//ventas y pedidos
	$query_reportes = "
			SELECT 
	            count(sales_flat_order.total_paid) Pedidos
	            ,sum(sales_flat_order.total_paid) Venta
	            ,WEEK(sales_flat_order.created_at, 2) Semana
	            ,YEAR(sales_flat_order.created_at) Year
           FROM shop_production.sales_flat_order sales_flat_order
           GROUP BY Semana, Year";


     //query para fraudes

    $fraudes = "
			SELECT 
             COUNT(sales_flat_order.total_paid) AS Pedidos,
             WEEK(sales_flat_order.created_at, 1) AS Semana,
             YEAR(sales_flat_order.created_at) AS Year
            FROM shop_production.sales_flat_order sales_flat_order
            WHERE (    sales_flat_order.status IN ('riskified_declined')         )
            GROUP BY Semana, Year";

?>