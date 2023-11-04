CREATE OR REPLACE TABLE multimedia (
    PRIMARY KEY (material_id),
    FOREIGN KEY (material_id)
        REFERENCES selection(material_id)
        ON DELETE CASCADE,
    FOREIGN KEY (multimedia_type)
        REFERENCES multimedia_types(multimedia_type)
        ON DELETE SET multimedia_types.multimedia_type_is_active = FALSE,

    material_id         INT             AUTO_INCREMENT,
    multimedia_type     VARCHAR(256),
    duration            TIME            NOT NULL
);