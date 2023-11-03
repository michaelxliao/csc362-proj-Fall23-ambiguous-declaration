CREATE OR REPLACE TABLE adaptations (
    PRIMARY KEY (narrative_id, material_id),
    FOREIGN KEY (narrative_id) REFERENCES narratives(narrative_id),
    FOREIGN KEY (material_id) REFERENCES selection(material_id),
    
    narrative_id            INT         NOT NULL,
    material_id             INT         NOT NULL,
    material_is_source      BOOLEAN     NOT NULL
);