CREATE OR REPLACE clubs(
    PRIMARY KEY(club_name),
    club_name           UNIQUE VARCHAR(256) NOT NULL,
    club_description    VARCHAR(1000),
    club_isActive       BOOLEAN DEFUALT TRUE
);