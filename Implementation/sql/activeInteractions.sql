CREATE OR REPLACE VIEW active_interactions AS
SELECT *
  FROM patron_selection_interactions
 WHERE patron_selection_interactions.interaction_is_active = TRUE;