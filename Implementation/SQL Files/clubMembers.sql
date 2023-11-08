CREATE OR REPLACE TABLE club_members(
    PRIMARY KEY(club_name, patron_id),
    FOREIGN KEY (patron_id)
        REFERENCES patrons(patron_id)
        ON DELETE CASCADE;
    FOREIGN KEY (club_name)
        REFERENCES clubs(club_name)
        ON DELETE CASCADE;
    
    club_name           VARCHAR(256),
    patron_id           INT,
    member_info         VARCHAR(1024),
    member_is_leader    BOOLEAN         NOT NULL DEFAULT FALSE
);