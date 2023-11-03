CREATE OR REPLACE TABLE loans (
    PRIMARY KEY (Interaction_ID),
    Interaction_ID          INT,
    Loan_Start_Date         DATE,
    Loan_End_Date           DATE,
    Loan_Return_Date        DATE,
    Loan_Renewal_Date_Tally INT,
    Loan_isActive           BOOLEAN DEFUALT TRUE
);