CREATE OR REPLACE VIEW active_loans AS
SELECT *
  FROM loans
 WHERE loans.loan_is_active = TRUE;