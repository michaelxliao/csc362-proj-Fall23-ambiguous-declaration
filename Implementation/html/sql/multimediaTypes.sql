CREATE OR REPLACE TABLE multimedia_types (
    PRIMARY KEY (multimedia_type),
    multimedia_type             VARCHAR(256),
    multimedia_type_is_active   BOOLEAN         NOT NULL DEFAULT TRUE -- for DENY deletion
);