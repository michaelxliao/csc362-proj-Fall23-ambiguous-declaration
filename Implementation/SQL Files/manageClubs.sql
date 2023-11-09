DELIMITER //
CREATE OR REPLACE PROCEDURE add_Club(new_club_name VARCHAR(256), new_club_description)
 BEGIN
 START TRANSACTION;
       INSERT INTO clubs( club_name, club_description)
       VALUES(new_club_name, new_club_description);
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE del_Club(deleted_club_name VARCHAR(256))
 BEGIN
 START TRANSACTION;
   DELETE FROM clubs
   WHERE club_name=deleted_club_name;

COMMIT;
   END
//
DELIMITER ;
