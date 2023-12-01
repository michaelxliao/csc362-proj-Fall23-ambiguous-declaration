CREATE OR REPLACE TABLE loans (
    PRIMARY KEY (interaction_id),
    FOREIGN KEY (interaction_id)
        REFERENCES patron_selection_interactions(interaction_id)
        ON DELETE CASCADE,
        
    interaction_id          INT,

    loan_start_date         DATE        NOT NULL,
    loan_return_date        DATE, -- to be clear: this is the day the material is actually returned; the due date of book is calculated
        CHECK (loan_return_date >= loan_start_date), -- loan times cannot be nonsensical
    loan_renewal_tally      INT         NOT NULL DEFAULT 0
        -- need to implement checks based on membership in table
    -- deny deletion is in interactions
);

-- Loan Return Date Cannot Be In Future business rule
DELIMITER //
CREATE OR REPLACE TRIGGER loans_no_future_returns_insert
BEFORE INSERT ON loans
FOR EACH ROW
BEGIN 
    IF (NEW.loan_return_date > CURDATE()) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Return date cannot be in the future';
    END IF;
  END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE TRIGGER loans_no_future_returns_update 
BEFORE UPDATE ON loans
FOR EACH ROW
BEGIN 
    IF (NEW.loan_return_date > CURDATE()) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Return date cannot be in the future';
    END IF;
  END
//
DELIMITER ;

-- Can Only Renew Loan For Print Material Four Times,
-- Can Only Renew Loan For Multimedia Material Two Times business rules
DELIMITER //
CREATE OR REPLACE TRIGGER loans_renewal_cap_insert
BEFORE INSERT ON loans
FOR EACH ROW
BEGIN 
    SET @relevant_material_id = (SELECT material_id
                                   FROM patron_selection_interactions
                                        LEFT OUTER JOIN loans USING(interaction_id)
                                  WHERE interaction_id = NEW.interaction_id);
    
    -- print
    IF @relevant_material_id IN (SELECT material_id
                                   FROM print_materials)
    THEN 
        IF NEW.loan_renewal_tally > 4 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Can only renew a print material up to 4 times';
        END IF;

    -- multimedia
    ELSE 
        IF NEW.loan_renewal_tally > 2 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Can only renew a multimedia material up to 2 times';
        END IF;

    END IF;
  END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE TRIGGER loans_renewal_cap_update
BEFORE UPDATE ON loans
FOR EACH ROW
BEGIN 
    SET @relevant_material_id = (SELECT material_id
                                   FROM patron_selection_interactions
                                        LEFT OUTER JOIN loans USING(interaction_id)
                                  WHERE interaction_id = NEW.interaction_id);
    
    -- print
    IF @relevant_material_id IN (SELECT material_id
                                   FROM print_materials)
    THEN 
        IF NEW.loan_renewal_tally > 4 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Can only renew a print material up to 4 times';
        END IF;

    -- multimedia
    ELSE 
        IF NEW.loan_renewal_tally > 2 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Can only renew a multimedia material up to 2 times';
        END IF;
        
    END IF;
  END
//
DELIMITER ;


-- patron can have at max ten print materials business rule
DELIMITER //
CREATE OR REPLACE TRIGGER loans_max_print_material_insert
BEFORE INSERT ON loans
FOR EACH ROW
BEGIN
    IF ((SELECT COUNT(material_id) FROM
            (
                SELECT *
                FROM loans
                    LEFT OUTER JOIN patron_selection_interactions USING (interaction_id)
                    INNER JOIN print_materials USING (material_id)
                    
                WHERE ((patron_id = (SELECT patron_id
                                       FROM patron_selection_interactions
                                      WHERE interaction_id = NEW.interaction_id)) 
                    AND 
                    (loan_return_date IS NULL))
            ) AS print_loans
        GROUP BY (patron_id) ) > 10)
    THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Can only check out max 10 print materials';

    END IF;
END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE TRIGGER loans_max_print_material_update
BEFORE UPDATE ON loans
FOR EACH ROW
BEGIN
    IF ((SELECT COUNT(material_id) FROM
            (
                SELECT *
                FROM loans
                    LEFT OUTER JOIN patron_selection_interactions USING (interaction_id)
                    INNER JOIN print_materials USING (material_id)
                    
                WHERE ((patron_id = (SELECT patron_id
                                       FROM patron_selection_interactions
                                      WHERE interaction_id = NEW.interaction_id)) 
                    AND 
                    (loan_return_date IS NULL))
            ) AS print_loans
        GROUP BY (patron_id) ) > 10)
    THEN
        -- SELECT COUNT(material_id) FROM
        --     (
        --         SELECT *
        --         FROM loans
        --             LEFT OUTER JOIN patron_selection_interactions USING (interaction_id)
        --             INNER JOIN print_materials USING (material_id)
                    
        --         WHERE ((patron_id = (SELECT patron_id
        --                                FROM patron_selection_interactions
        --                               WHERE interaction_id = NEW.interaction_id)) 
        --             AND 
        --             (loan_return_date IS NULL))
        --     ) AS print_loans
        -- GROUP BY (patron_id);
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Can only check out max 10 print materials';

    END IF;
END
//
DELIMITER ;

-- patron can have at max four multimedia materials business rule
DELIMITER //
CREATE OR REPLACE TRIGGER loans_max_multimedia_material_insert
BEFORE INSERT ON loans
FOR EACH ROW
BEGIN
    IF ((SELECT COUNT(material_id) FROM
            (
                SELECT *
                FROM loans
                    LEFT OUTER JOIN patron_selection_interactions USING (interaction_id)
                    INNER JOIN multimedia USING (material_id)
                    
                WHERE ((patron_id = (SELECT patron_id
                                       FROM patron_selection_interactions
                                      WHERE interaction_id = NEW.interaction_id)) 
                    AND 
                    (loan_return_date IS NULL))
            ) AS multimedia_loans
        GROUP BY (patron_id) ) > 4)
    THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Can only check out max 10 print materials';

    END IF;
END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE TRIGGER loans_max_multimedia_material_update
BEFORE UPDATE ON loans
FOR EACH ROW
BEGIN
    IF ((SELECT COUNT(material_id) FROM
            (
                SELECT *
                FROM loans
                    LEFT OUTER JOIN patron_selection_interactions USING (interaction_id)
                    INNER JOIN multimedia USING (material_id)
                    
                WHERE ((patron_id = (SELECT patron_id
                                       FROM patron_selection_interactions
                                      WHERE interaction_id = NEW.interaction_id)) 
                    AND 
                    (loan_return_date IS NULL))
            ) AS multimedia_loans
        GROUP BY (patron_id) ) > 4)
    THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Can only check out max 10 print materials';

    END IF;
END
//
DELIMITER ;