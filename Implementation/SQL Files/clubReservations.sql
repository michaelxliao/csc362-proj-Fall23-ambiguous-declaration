USE therpston;

CREATE OR REPLACE TABLE club_reservations (
    PRIMARY KEY (reservation_id),
    FOREIGN KEY (reservation_id) 
        REFERENCES space_reservations(reservation_id),
    FOREIGN KEY (club_id)
        REFERENCES clubs(club_id),

    reservation_id      INT,
    club_id             INT
);