CREATE OR REPLACE VIEW active_selection AS -- NEED TO JOIN linking tables!!
SELECT material_id,
       material_title,
       material_date_received,
       material_date_created
       material_is_pending,
       material_price
  FROM selection
 WHERE material_is_active = TRUE;

CREATE OR REPLACE VIEW active_selection_pretty_librarians AS
SELECT material_title AS "Title",
       material_date_received AS "Date Selected into Library",
       material_date_created AS "Date Created",
       material_is_pending AS "Pending?",
       material_price AS "Cost"
  FROM active_selection

CREATE OR REPLACE VIEW active_selection_pretty_patrons AS
SELECT material_title AS "Title",
       material_date_created AS "Date Created",
  FROM active_selection
 WHERE material_is_pending = FALSE;