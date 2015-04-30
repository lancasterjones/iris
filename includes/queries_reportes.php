<?php

	//ventas y pedidos
	$query_reportes = "
			SELECT COUNT(sales_flat_order.total_paid) AS Pedidos,
       SUM(sales_flat_order.total_paid) AS Venta,
       WEEK(sales_flat_order.created_at, 7) AS Semana,
       LEFT(YEARWEEK(sales_flat_order.created_at, 7), 4) AS `Year`,
       Subquery.fraudes
  FROM shop_production.sales_flat_order sales_flat_order
       LEFT OUTER JOIN
       (SELECT COUNT(DISTINCT sales_flat_order.increment_id) AS fraudes,
               WEEK(sales_flat_order.created_at, 7) AS semana,
               LEFT(YEARWEEK(sales_flat_order.created_at, 7), 4)
                  AS ```year```
          FROM shop_production.sales_flat_order_status_history sales_flat_order_status_history
               INNER JOIN shop_production.sales_flat_order sales_flat_order
                  ON (sales_flat_order_status_history.parent_id =
                         sales_flat_order.entity_id)
         WHERE sales_flat_order_status_history.comment LIKE '%declined%'
        GROUP BY WEEK(sales_flat_order.created_at, 7),
                 LEFT(YEARWEEK(sales_flat_order.created_at, 7), 4)) Subquery
          ON     (LEFT(YEARWEEK(sales_flat_order.created_at, 7), 4) =
                     Subquery.```year```)
             AND (WEEK(sales_flat_order.created_at, 7) = Subquery.semana)
 WHERE sales_flat_order.status IN ('complete', 'processing') ";


     //query para fraudes

   /* $fraudes = "
			SELECT 
             COUNT(sales_flat_order.total_paid) AS Pedidos,
             WEEK(sales_flat_order.created_at, 1) AS Semana,
             YEAR(sales_flat_order.created_at) AS Year
            FROM shop_production.sales_flat_order sales_flat_order
            WHERE (    sales_flat_order.status IN ('riskified_declined')         )
            GROUP BY Semana, Year"; */
?>