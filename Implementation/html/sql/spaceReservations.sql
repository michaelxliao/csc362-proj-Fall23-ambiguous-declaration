USE therpston;

CREATE OR REPLACE TABLE space_reservations (
    PRIMARY KEY (reservation_id),
    FOREIGN KEY (patron_id)
        REFERENCES patrons(patron_id),
    FOREIGN KEY (space_id)
        REFERENCES spaces(space_id),

    reservation_id          INT         AUTO_INCREMENT,
    patron_id               INT         NOT NULL,
    space_id                INT         NOT NULL,
    start_reservation       DATETIME    NOT NULL,
    end_reservation         DATETIME    NOT NULL,
        CHECK (end_reservation > start_reservation), -- Space Reservation End Date Must Be After Start Date business rule
    reservation_notes       VARCHAR(256)
);