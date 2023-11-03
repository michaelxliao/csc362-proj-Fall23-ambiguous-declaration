CREATE OR REPLACE VIEW active_narratives AS
SELECT narrative_id,
       narrative_name,
       narrative_description
  FROM narratives
 WHERE narrative_is_active = TRUE;