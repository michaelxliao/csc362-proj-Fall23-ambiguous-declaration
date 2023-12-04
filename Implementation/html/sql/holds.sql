CREATE OR REPLACE TABLE holds (
    PRIMARY KEY (interaction_id),
    FOREIGN KEY (interaction_id)
        REFERENCES patron_selection_interactions(interaction_id)
        ON DELETE CASCADE, 
        
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
    IF (NEW.hold_date_requested > CURRENT_TIMESTAMP()) THEN
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
    IF (NEW.hold_date_requested > CURRENT_TIMESTAMP()) THEN
       SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Hold request date cannot be in the future';
  END IF;
  END
//
DELIMITER ;

-- cannot place a hold if it hasn't been loaned out
DELIMITER //
CREATE OR REPLACE TRIGGER no_hold_if_not_loaned 
BEFORE INSERT ON holds
FOR EACH ROW
BEGIN 
    DECLARE new_material_id INT;
    SELECT UNIQUE material_id INTO new_material_id
        FROM patron_selection_interactions
        WHERE interaction_id = NEW.interaction_id;
    IF new_material_id NOT IN (SELECT material_id 
                            FROM loans
                                LEFT OUTER JOIN patron_selection_interactions USING (interaction_id)
                            WHERE loan_return_date IS NULL
                            AND material_id = new_material_id)
    THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Cannot hold a book that isn't checked out";

    END IF;
  END
//
DELIMITER ;

-- can't hold if YOU have it yourself
DELIMITER //
CREATE OR REPLACE TRIGGER no_hold_if_your_own_loan 
BEFORE INSERT ON holds
FOR EACH ROW
BEGIN 
    DECLARE new_material_id INT;
    DECLARE new_patron_id INT;
    
    SELECT UNIQUE material_id INTO new_material_id
        FROM patron_selection_interactions
        WHERE interaction_id = NEW.interaction_id; -- get the new material
    SELECT UNIQUE patron_id INTO new_patron_id
        FROM patron_selection_interactions
        WHERE interaction_id = NEW.interaction_id; -- get the new patron

    IF new_material_id IN (SELECT material_id 
                            FROM loans
                                LEFT OUTER JOIN patron_selection_interactions USING (interaction_id)
                            WHERE loan_return_date IS NULL
                            AND material_id = new_material_id
                            AND patron_id = new_patron_id)
    THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Cannot hold a book that you have checked out";

    END IF;
  END
//
DELIMITER ;

-- can't hold if you ALREADY have a hold
DELIMITER //
CREATE OR REPLACE TRIGGER no_hold_if_already_held
BEFORE INSERT ON holds
FOR EACH ROW
BEGIN 
    DECLARE new_material_id INT;
    DECLARE new_patron_id INT;
    
    SELECT UNIQUE material_id INTO new_material_id
        FROM patron_selection_interactions
        WHERE interaction_id = NEW.interaction_id; -- get the new material
    SELECT UNIQUE patron_id INTO new_patron_id
        FROM patron_selection_interactions
        WHERE interaction_id = NEW.interaction_id; -- get the new patron

    IF new_material_id IN (SELECT material_id 
                            FROM holds
                                LEFT OUTER JOIN patron_selection_interactions USING (interaction_id)
                            WHERE material_id = new_material_id
                            AND patron_id = new_patron_id)
    THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "You already have a hold on this book!";

    END IF;
  END
//
DELIMITER ;
