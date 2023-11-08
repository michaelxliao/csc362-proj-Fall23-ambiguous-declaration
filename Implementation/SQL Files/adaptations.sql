CREATE OR REPLACE TABLE adaptations (
    PRIMARY KEY (narrative_id, material_id),
    FOREIGN KEY (narrative_id)
        REFERENCES narratives(narrative_id)
        ON DELETE CASCADE,
    FOREIGN KEY (material_id) 
        REFERENCES selection(material_id)
        ON DELETE CASCADE,
    
    narrative_id            INT,
    material_id             INT,
    material_is_source      BOOLEAN     NOT NULL
);