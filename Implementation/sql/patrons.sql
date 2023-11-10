CREATE OR REPLACE TABLE patrons(
    PRIMARY KEY(patron_id),
    patron_id           INT             AUTO_INCREMENT,
    patron_first_name   VARCHAR(256)    NOT NULL,
    patron_last_name    VARCHAR(256)    NOT NULL,
    patron_phone        CHAR(14),
    patron_email        VARCHAR(256),
    patron_isActive     BOOLEAN SET DEFAULT TRUE
);