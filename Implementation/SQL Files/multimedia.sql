CREATE OR REPLACE TABLE multimedia (
    PRIMARY KEY (material_id),
    FOREIGN KEY (material_id) REFERENCES selection(material_id),
    FOREIGN KEY (multimedia_type_id) REFERENCES multimedia_types(multimedia_type_id),

    material_id         INT         AUTO_INCREMENT,
    multimedia_type     VARCHAR(32),
    duration            TIME        NOT NULL,
);