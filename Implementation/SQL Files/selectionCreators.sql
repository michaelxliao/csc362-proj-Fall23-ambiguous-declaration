CREATE OR REPLACE TABLE selection_creators(
    PRIMARY KEY (material_id, creator_id, creator_role),

    material_id     INT,
        FOREIGN KEY (material_id)
            REFERENCES selection(material_id)
            ON DELETE CASCADE,
    creator_id      INT,   
        FOREIGN KEY (creator_id)
            REFERENCES creators(creator_id)
            ON DELETE NO ACTION, -- DENY deletion rule implemented in updateValidationTables.sql
    creator_role    VARCHAR(256),
        FOREIGN KEY (creator_role)
            REFERENCES creators(creator_role)
            ON DELETE NO ACTION -- DENY deletion rule implemented in updateValidationTables.sql
);