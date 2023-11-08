CREATE OR REPLACE TABLE selection_genres(
    PRIMARY KEY (material_id, genre_id),

    material_id     INT,
        FOREIGN KEY (material_id)
            REFERENCES selection(material_id)
            ON DELETE CASCADE,
    genre_id        INT
        FOREIGN KEY (genre_id)
            REFERENCES genres(genre_id)
            ON DELETE CASCADE,
);