CREATE OR REPLACE TABLE multimedia (
    PRIMARY KEY (material_id),

    material_id         INT,
        FOREIGN KEY (material_id)
            REFERENCES selection(material_id)
            ON DELETE CASCADE,
    multimedia_type     VARCHAR(256),
        FOREIGN KEY (multimedia_type)
            REFERENCES multimedia_types(multimedia_type)
            ON DELETE NO ACTION, -- DENY deletion rule implemented in manageSelection.sql
    duration            TIME            NOT NULL
);