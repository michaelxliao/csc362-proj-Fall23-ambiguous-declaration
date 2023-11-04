USE therpston;

CREATE OR REPLACE TABLE spaces (
    PRIMARY KEY         (space_id),
    space_id            INT             AUTO_INCREMENT,
    space_name          VARCHAR(256)    NOT NULL,
    space_room_number   INT             NOT NULL,
    space_capacity      INT             NOT NULL,
    space_is_active     BOOLEAN         DEFAULT TRUE

    ON DELETE SET space_is_active TO FALSE; -- needs work
);