DELIMITER //
CREATE OR REPLACE PROCEDURE add_patron(patron_first_name VARCHAR(256), patron_last_name VARCHAR(256), patron_email VARCHAR(256), patron_phone CHAR(14))
 BEGIN
 START TRANSACTION;
       
COMMIT;
   END
//
DELIMITER ;

