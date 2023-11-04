CREATE OR REPLACE TABLE selection_languages
(
    PRIMARY KEY (material_id, language_name),
    FOREIGN KEY (material_id) 
        REFERENCES selection(material_id) 
        ON DELETE CASCADE,
    FOREIGN KEY (language_name) 
        REFERENCES languages (language_name) 
        ON DELETE CASCADE,

    material_id         INT,
    language_name       VARCHAR(256)
);