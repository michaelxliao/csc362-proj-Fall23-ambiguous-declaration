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
        
>>>>>>> fecf0c4ff9f1f0d6128697f28b49651113ea8971
    interaction_id          INT,
    hold_date_requested     DATETIME    NOT NULL,
    hold_is_active          BOOLEAN     NOT NULL DEFAULT TRUE
);