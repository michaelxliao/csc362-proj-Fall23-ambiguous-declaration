CREATE OR REPLACE TABLE patrons(
    PRIMARY KEY(patron_id),
    patron_id           INT             AUTO_INCREMENT,
    patron_first_name   VARCHAR(256)    NOT NULL,
    patron_last_name    VARCHAR(256)    NOT NULL,
    
    patron_phone        CHAR(14),
    patron_email        VARCHAR(256),
        CHECK ((patron_phone IS NOT NULL) OR (patron_email IS NOT NULL)), -- Patron Email or Patron Phone Must Be Non-null business rule
    patron_is_active     BOOLEAN
);