CREATE OR REPLACE TABLE club_members(
    PRIMARY KEY(club_id, patron_id),
    FOREIGN KEY (patron_id)
        REFERENCES patrons(patron_id)
        ON DELETE CASCADE;
    FOREIGN KEY (club_id)
        REFERENCES clubs(club_id)
        ON DELETE CASCADE;
    
    club_id             INT,
    patron_id           INT,
    member_info         VARCHAR(1024),
    member_is_leader    BOOLEAN         NOT NULL DEFAULT FALSE
);