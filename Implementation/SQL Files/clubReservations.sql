USE therpston;

CREATE OR REPLACE TABLE club_reservations (
    PRIMARY KEY (reservation_id),
    FOREIGN KEY (reservation_id) 
        REFERENCES space_reservations(reservation_id),
    FOREIGN KEY (club_name)
        REFERENCES clubs(club_name),

    reservation_id      INT,
    club_name             INT
);