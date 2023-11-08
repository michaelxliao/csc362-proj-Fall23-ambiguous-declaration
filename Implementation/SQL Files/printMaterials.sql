CREATE OR REPLACE TABLE print_materials (
    PRIMARY KEY (material_id),

    material_id     INT,
    print_type      VARCHAR(256),
        FOREIGN KEY (print_type)
            REFERENCES print_types(print_type)
            ON DELETE NO ACTION, -- DENY deletion rule implemented in manageSelection.sql
    page_count      INT             NOT NULL,
        CHECK (page_count > 0) -- no negative page counts
);