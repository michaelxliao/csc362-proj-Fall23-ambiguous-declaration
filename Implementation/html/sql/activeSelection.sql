CREATE OR REPLACE VIEW active_selection AS -- NEED TO JOIN linking tables!!
SELECT *
  FROM selection
 WHERE material_is_active = TRUE;