CREATE OR REPLACE VIEW current_loans AS
SELECT *
  FROM loans
       LEFT OUTER JOIN patron_selection_interactions USING(interaction_id)
 WHERE loan_return_date IS NULL;