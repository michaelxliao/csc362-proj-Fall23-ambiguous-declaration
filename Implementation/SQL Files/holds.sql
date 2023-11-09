CREATE OR REPLACE TABLE holds (
    PRIMARY KEY (interaction_id),
<<<<<<< HEAD
    FOREIGN KEY (interaction_id) 
        REFERENCES patron_selection_interactions.interaction_id
        ON DELETE SET patron_selection_interactions.interaction_is_active = FALSE;
=======
    FOREIGN KEY (interaction_id)
        REFERENCES patron_selection_interactions(interaction_id)
        ON DELETE NO ACTION, -- DENY deletion rule implemented in manageInteractions.sql
        
>>>>>>> 1f1ab4defb9d9c43a709ba33b580b87445918543
    interaction_id          INT,
    hold_date_requested     DATETIME    NOT NULL,
    hold_is_active          BOOLEAN     NOT NULL DEFAULT TRUE
);