DELIMITER //
CREATE OR REPLACE PROCEDURE add_loan(material_id INT, patron_id INT, loan_start DATE, loan_return DATE, loan_renewal_tally INT)
 BEGIN
 START TRANSACTION;
    INSERT INTO patron_selection_interactions (material_id, patron_id)
    VALUES (material_id, patron_id);

    INSERT INTO loans (interaction_id, loan_start_date, loan_return_date, loan_renewal_tally)
    VALUES (LAST_INSERT_ID(), loan_start, loan_return, loan_renewal_tally);
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE add_hold(material_id INT, patron_id INT, hold_date DATETIME)
 BEGIN
 START TRANSACTION;
    INSERT INTO patron_selection_interactions (material_id, patron_id)
    VALUES (material_id, patron_id);

    INSERT INTO holds (interaction_id, hold_date_requested)
    VALUES (LAST_INSERT_ID(), hold_date);
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE del_interaction(id INT)
 BEGIN
 START TRANSACTION;
    DELETE FROM patron_selection_interactions
     WHERE interaction_id = id;
     -- table def handles deletion
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE update_loan(id INT, material_id INT, patron_id INT, loan_start DATE, loan_return DATE, loan_renewal_tally INT)
 BEGIN
 START TRANSACTION;
    UPDATE patron_selection_interactions
       SET patron_selection_interactions.material_id = material_id,
           patron_selection_interactions.patron_id = patron_id
    WHERE interaction_id = id;

    UPDATE loans
       SET loans.loan_start_date = loan_start,
           loans.loan_return_date = loan_return,
           loans.loan_renewal_tally = loan_renewal_tally
    WHERE interaction_id = id;
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE update_hold(id INT, material_id INT, patron_id INT, hold_date DATETIME)
 BEGIN
 START TRANSACTION;
    UPDATE patron_selection_interactions
       SET patron_selection_interactions.material_id = material_id,
           patron_selection_interactions.patron_id = patron_id
    WHERE interaction_id = id;

    UPDATE holds
       SET holds.hold_date_requested = hold_date
    WHERE interaction_id = id;
COMMIT;
   END
//
DELIMITER ;