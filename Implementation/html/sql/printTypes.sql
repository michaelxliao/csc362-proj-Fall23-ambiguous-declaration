CREATE OR REPLACE TABLE print_types (
    PRIMARY KEY (print_type),
    print_type              VARCHAR(256),
    print_type_is_active    BOOLEAN         NOT NULL DEFAULT TRUE -- for DENY
);
