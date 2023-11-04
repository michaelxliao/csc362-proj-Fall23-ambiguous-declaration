CREATE OR REPLACE TABLE loans (
    PRIMARY KEY (interaction_id),
    FOREIGN KEY (interaction_id)
        REFERENCES patron_selection_interactions(interaction_id)
        ON DELETE SET patron_selection_interactions.interacton_is_active = FALSE;

    interaction_id          INT,
    loan_start_date         DATE        NOT NULL,
    loan_return_date        DATE,
    loan_renewal_tally      INT         NOT NULL DEFAULT 0,
    loan_is_active          BOOLEAN     NOT NULL DEFAULT TRUE
);