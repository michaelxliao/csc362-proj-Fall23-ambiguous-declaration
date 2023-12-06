CREATE OR REPLACE TABLE narratives (
    PRIMARY KEY (narrative_id),
    narrative_id            INT             AUTO_INCREMENT,
    narrative_name          VARCHAR(256)    UNIQUE NOT NULL,
    narrative_description   VARCHAR(1024),
    narrative_is_active     BOOLEAN         NOT NULL DEFAULT TRUE -- for DENY deletion rule
);