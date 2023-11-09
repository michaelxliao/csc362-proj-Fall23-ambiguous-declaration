CREATE OR REPLACE TABLE holds (
    PRIMARY KEY (interaction_id),
    FOREIGN KEY (interaction_id) 
        REFERENCES patron_selection_interactions.interaction_id
        ON DELETE SET patron_selection_interactions.interaction_is_active = FALSE;
    interaction_id          INT,
    hold_date_requested     DATETIME    NOT NULL,
    hold_is_active          BOOLEAN     NOT NULL DEFAULT TRUE
);