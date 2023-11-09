DELIMITER //
CREATE OR REPLACE PROCEDURE add_patron(patron_first_name VARCHAR(256), patron_last_name VARCHAR(256), patron_email VARCHAR(256), patron_phone CHAR(14))
 BEGIN
 START TRANSACTION;
       INSERT INTO patrons
       VALUES(new_Patron_First_Name, new_Patron_Last_Name, new_Patron_Email, new_Patron_Phone);
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE update_patron(id INT, new_patron_first_name VARCHAR(256), new_patron_last_name VARCHAR(256), new_ptron_email VARCHAR(256), new_patron_phone CHAR(14))
 BEGIN
 START TRANSACTION;
       UPDATE patrons
       SET patron_first_name=new_patron_first_name,
           patron_last_name=new_patron_last_namem,
           patron_email=new_patron_email,
           patron_phone=new_patron_phone
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
