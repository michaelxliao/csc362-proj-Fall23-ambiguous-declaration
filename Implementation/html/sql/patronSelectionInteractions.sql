CREATE OR REPLACE TABLE patron_selection_interactions (
    PRIMARY KEY (interaction_id),
    FOREIGN KEY (material_id)
        REFERENCES selection(material_id)
        ON DELETE CASCADE,
    FOREIGN KEY (patron_id)
        REFERENCES patrons(patron_id)
        ON DELETE CASCADE,
        
    interaction_id          INT         AUTO_INCREMENT,
    material_id             INT,
    patron_id               INT
    -- interaction_is_active   BOOLEAN     NOT NULL DEFAULT TRUE
    -- found later that interaction is better as cascade 

);