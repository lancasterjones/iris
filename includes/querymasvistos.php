<?php
sql= "SELECT CONCAT(
          YEAR(report_viewed_product_aggregated_monthly.period),
          IF(MONTH(report_viewed_product_aggregated_monthly.period) < 10,
             '0',
             ''),
          MONTH(report_viewed_product_aggregated_monthly.period))
          AS mes,
       catalog_product_entity.sku AS modelo,
       report_viewed_product_aggregated_monthly.product_price AS precio,
       AVG(report_viewed_product_aggregated_monthly.views_num) AS vistas,
       SUM(cataloginventory_stock_item.qty) AS qty,
       catalog_product_entity_media_gallery.value AS foto
  FROM (((((shop_production.catalog_product_entity catalog_product_entity_1
            INNER JOIN
            shop_production.cataloginventory_stock_item cataloginventory_stock_item
               ON (catalog_product_entity_1.entity_id =
                      cataloginventory_stock_item.product_id))
           INNER JOIN
           shop_production.catalog_product_relation catalog_product_relation
              ON (catalog_product_relation.child_id =
                     catalog_product_entity_1.entity_id))
          INNER JOIN
          shop_production.catalog_product_entity catalog_product_entity
             ON (catalog_product_entity.entity_id =
                    catalog_product_relation.parent_id))
         INNER JOIN
         shop_production.report_viewed_product_aggregated_monthly report_viewed_product_aggregated_monthly
            ON (report_viewed_product_aggregated_monthly.product_id =
                   catalog_product_entity.entity_id))
        INNER JOIN
        shop_production.catalog_product_entity_media_gallery catalog_product_entity_media_gallery
           ON (catalog_product_entity.entity_id =
                  catalog_product_entity_media_gallery.entity_id))
       INNER JOIN
       shop_production.catalog_product_entity_media_gallery_value catalog_product_entity_media_gallery_value
          ON (catalog_product_entity_media_gallery_value.value_id =
                 catalog_product_entity_media_gallery.value_id)
 WHERE     (report_viewed_product_aggregated_monthly.rating_pos < 11)
       AND (catalog_product_entity_media_gallery_value.position = 1)
GROUP BY report_viewed_product_aggregated_monthly.period,
         catalog_product_entity.sku
ORDER BY report_viewed_product_aggregated_monthly.period DESC, 4 DESC";
?>