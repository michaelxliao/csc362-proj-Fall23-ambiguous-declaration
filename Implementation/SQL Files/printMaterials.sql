CREATE OR REPLACE TABLE print_materials (
    PRIMARY KEY (material_id),
    FOREIGN KEY (print_type)
        REFERENCES print_types(print_type)
        ON DELETE NO ACTION, -- DENY deletion rule implemented in manageSelection.sql

    material_id     INT,
    print_type      VARCHAR(256),
    page_count      INT             NOT NULL,
        CHECK (page_count > 0) -- no negative page counts
);