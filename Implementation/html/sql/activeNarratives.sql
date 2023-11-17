CREATE OR REPLACE VIEW active_narratives AS
SELECT *
  FROM narratives
 WHERE narrative_is_active = TRUE;