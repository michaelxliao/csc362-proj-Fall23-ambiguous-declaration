USE therpston;

CREATE OR REPLACE TABLE spaces (
    PRIMARY KEY         (space_id),
    space_id            INT AUTO_INCREMENT,
    space_name          VARCHAR(64) NOT NULL,
    space_room_number   INT NOT NULL,
    space_capacity      INT NOT NULL,
    space_is_active      BOOLEAN
);