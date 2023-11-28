DELIMITER //
CREATE OR REPLACE PROCEDURE add_patron(new_patron_first_name VARCHAR(256), new_patron_last_name VARCHAR(256), new_patron_email VARCHAR(256), new_patron_phone CHAR(14))
 BEGIN
 START TRANSACTION;
       INSERT INTO patrons(patron_first_name, patron_last_name, patron_email, patron_phone)
       VALUES (new_patron_first_name, new_patron_last_name, new_patron_email, new_patron_phone);
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE update_patron(id INT, new_patron_first_name VARCHAR(256), new_patron_last_name VARCHAR(256), new_patron_email VARCHAR(256), new_patron_phone CHAR(14))
 BEGIN
 START TRANSACTION;
       UPDATE patrons
       SET patrons.patron_first_name=new_patron_first_name,
           patrons.patron_last_name=new_patron_last_name,
           patrons.patron_email=new_patron_email,
           patrons.patron_phone=new_patron_phone
       WHERE patron_id=id;
 COMMIT;
   END

//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE del_patron(del_Patron_ID int)
 BEGIN
 START TRANSACTION;
   DELETE FROM patrons
   WHERE Patron_ID=del_Patron_ID;

COMMIT;
   END
//
DELIMITER ;
