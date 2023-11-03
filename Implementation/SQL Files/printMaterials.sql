CREATE OR REPLACE TABLE print_materials (
    PRIMARY KEY (material_id),
    FOREIGN KEY (material_id) REFERENCES selection(material_id),
    FOREIGN KEY (print_type) REFERENCES print_types(print_type),

    material_id     INT,
    print_type      VARCHAR(32),
    page_count      INT NOT NULL,
    CHECK (page_count > 0) -- no negative page counts
);