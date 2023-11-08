CREATE OR REPLACE TABLE selection_genres(
    PRIMARY KEY (material_id, genre_name),
    FOREIGN KEY (material_id)
        REFERENCES selection(material_id)
        ON DELETE CASCADE,
    FOREIGN KEY (genre_name)
        REFERENCES genres(genre_name)
        ON DELETE CASCADE,

    material_id     INT,
    genre_name      VARCHAR(256)
);