CREATE OR REPLACE TABLE holds (
    PRIMARY KEY (interaction_id),
    FOREIGN KEY (interaction_id)
        REFERENCES patron_selection_interactions(interaction_id)
        ON DELETE NO ACTION, -- DENY deletion rule implemented in manageInteractions.sql
        
    interaction_id          INT,
    hold_date_requested     DATETIME    NOT NULL
    -- deny deletion is through interaction_id
);

-- Hold Date Requested Cannot Be In Future business rule
DELIMITER //
CREATE OR REPLACE TRIGGER holds_no_future_requests_insert
BEFORE INSERT ON holds
FOR EACH ROW
BEGIN 
    IF (NEW.hold_date_requested > CURDATE()) THEN
       SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Hold request date cannot be in the future';
  END IF;
  END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE TRIGGER holds_no_future_requests_update
BEFORE UPDATE ON holds
FOR EACH ROW
BEGIN 
    IF (NEW.hold_date_requested > CURDATE()) THEN
       SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Hold request date cannot be in the future';
  END IF;
  END
//
DELIMITER ;