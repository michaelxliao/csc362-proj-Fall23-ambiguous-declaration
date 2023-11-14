CREATE OR REPLACE TABLE creators
(
    PRIMARY KEY (creator_id),
    creator_id              INT             AUTO_INCREMENT,
    creator_first_name      VARCHAR(256),
    creator_last_name       VARCHAR(256)
);