CREATE OR REPLACE VIEW activeLoans AS
SELECT *
  FROM loans
 WHERE loans.loan_is_active = TRUE;