CREATE OR REPLACE VIEW current_holds AS
SELECT *
  FROM holds
       LEFT OUTER JOIN patron_selection_interactions USING(interaction_id)
       LEFT OUTER JOIN loans USING(interaction_id)
 WHERE loan_return_date IS NOT NULL;