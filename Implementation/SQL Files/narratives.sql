CREATE OR REPLACE TABLE narratives (
    PRIMARY KEY (narrative_id),
    narrative_id            INT             AUTO_INCREMENT,
    narrative_name          VARCHAR(256)    NOT NULL,
    narrative_description   VARCHAR(1024)    NOT NULL,
    narrative_is_active     BOOLEAN         NOT NULL DEFAULT TRUE -- for DENY deletion rule
);