CREATE OR REPLACE VIEW AS active_selection
SELECT material_id,
       material_title,
       material_date_received,
       material_date_created
       material_is_pending,
       material_price
  FROM selection
 WHERE material_is_active = TRUE;