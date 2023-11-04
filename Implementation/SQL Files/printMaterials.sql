CREATE OR REPLACE TABLE print_materials (
    PRIMARY KEY (material_id),
    FOREIGN KEY (material_id)
        REFERENCES selection(material_id)
        ON DELETE CASCADE,
    FOREIGN KEY (print_type)
        REFERENCES print_types(print_type)
        ON DELETE SET print_types.print_type_is_active = FALSE, -- DENY deletion rule

    material_id     INT,
    print_type      VARCHAR(256),
    page_count      INT             NOT NULL,
        CHECK (page_count > 0) -- no negative page counts
);