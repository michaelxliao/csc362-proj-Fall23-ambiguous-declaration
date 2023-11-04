CREATE OR REPLACE TABLE selection_genres(
    PRIMARY KEY (material_id, genre_id),
    FOREIGN KEY material_id
        REFERENCES selection(material_id)
        ON DELETE CASCADE,
    FOREIGN KEY genre_id
        REFERENCES genres(genre_id)
        ON DELETE CASCADE,

    material_id     INT,
    genre_id        INT,
);