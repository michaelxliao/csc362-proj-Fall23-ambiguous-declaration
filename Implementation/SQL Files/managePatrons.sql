DELIMITER //
CREATE OR REPLACE PROCEDURE add_patron(Patron_First_Name VARCHAR(256), Patron_Last_Name VARCHAR(256), Patron_Email VARCHAR(256), Patron_Phone VARCHAR(64))
 BEGIN
 START TRANSACTION;
       
COMMIT;
   END
//
DELIMITER ;