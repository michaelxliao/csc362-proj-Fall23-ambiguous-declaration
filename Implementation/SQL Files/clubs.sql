CREATE OR REPLACE clubs(
    PRIMARY KEY (club_id),
    club_id             INT             AUTO_INCREMENT,
    club_name           VARCHAR(256),
    club_description    VARCHAR(1024),
    club_is_active      BOOLEAN         DEFAULT TRUE
);