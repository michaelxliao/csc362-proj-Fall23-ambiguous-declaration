CREATE OR REPLACE TABLE patrons(
    PRIMARY KEY(Patron_ID),
    Patron_ID           INT AUTO_INCREMENT,
    Patron_First_Name   VARCHAR(256) NOT NULL,
    Patron_Last_Name    VARCHAR(256) NOT NULL,
    Patron_Phone        VARCHAR(64),
    Patron_Email        VARCHAR(256)
);