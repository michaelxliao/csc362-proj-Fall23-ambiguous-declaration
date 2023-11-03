CREATE OR REPLACE VIEW activeLoans AS
SELECT *
FROM loans
WHERE loans.Loan_isActive=TRUE;