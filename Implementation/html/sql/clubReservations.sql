CREATE OR REPLACE TABLE club_reservations (
    PRIMARY KEY (reservation_id),
    FOREIGN KEY (reservation_id) 
        REFERENCES space_reservations(reservation_id)
        ON DELETE NO ACTION, -- DENY deletion rule implemented in manageReservations.sql
    FOREIGN KEY (club_id)
        REFERENCES clubs(club_id)
        ON DELETE NO ACTION, -- DENY deletion rule implemented in manageReservations.sql

    reservation_id      INT,
    club_id             INT
);