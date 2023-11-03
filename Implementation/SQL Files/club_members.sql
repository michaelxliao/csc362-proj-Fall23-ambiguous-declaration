CREATE OR REPLACE TABLE club_members(
    PRIMARY KEY(club_id,Patron_ID),
    club_id             INT,
    Patron_ID           INT,
    Member_Info         VARCHAR(100),
    Member_isLeader     BOOLEAN
);