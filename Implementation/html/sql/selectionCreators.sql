CREATE OR REPLACE TABLE selection_creators(
    PRIMARY KEY (material_id, creator_id, creator_role),
    FOREIGN KEY (material_id)
        REFERENCES selection(material_id)
        ON DELETE CASCADE,
    FOREIGN KEY (creator_id)
        REFERENCES creators(creator_id)
        ON DELETE CASCADE,
    FOREIGN KEY (creator_role)
        REFERENCES creator_roles(creator_role)
        ON DELETE CASCADE,

    material_id     INT,
    creator_id      INT,   
    creator_role    VARCHAR(256)
);