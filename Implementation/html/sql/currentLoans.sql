CREATE OR REPLACE VIEW active_loans AS
SELECT *
  FROM loans INNER JOIN patron_selection_interactions USING (interaction_id)
 WHERE interaction_is_active = TRUE;