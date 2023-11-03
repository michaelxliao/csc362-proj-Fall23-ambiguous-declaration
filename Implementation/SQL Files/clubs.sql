CREATE OR REPLACE clubs(
    PRIMARY KEY(club_id),
    club_id             INT AUTO_INCREMENT,
    club_name           VARCHAR(64),
    club_description    VARCHAR(250),
    club_isActive       BOOLEAN DEFUALT TRUE
);