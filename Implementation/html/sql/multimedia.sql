CREATE OR REPLACE TABLE multimedia (
    PRIMARY KEY (material_id),
    FOREIGN KEY (material_id)
        REFERENCES selection(material_id)
        ON DELETE CASCADE,
    FOREIGN KEY (multimedia_type)
        REFERENCES multimedia_types(multimedia_type)
        ON DELETE NO ACTION, -- DENY deletion rule implemented in manageSelection.sql

    material_id         INT,
    multimedia_type     VARCHAR(256),
    duration            TIME            NOT NULL
);

-- implement deny trigger here