CREATE OR REPLACE VIEW active_holds AS
SELECT *
  FROM holds INNER JOIN patron_selection_interactions USING (interaction_id)
 WHERE interaction_is_active = TRUE;