CREATE OR REPLACE TABLE clubs (
    PRIMARY KEY(club_name),
    club_name           VARCHAR(256)    UNIQUE NOT NULL,
    club_description    VARCHAR(1024),
    club_is_active      BOOLEAN         DEFAULT TRUE
);