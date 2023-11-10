DELIMITER //
CREATE OR REPLACE PROCEDURE add_club(club_name VARCHAR(256), club_description VARCHAR(1024))
 BEGIN
 START TRANSACTION;
       INSERT INTO clubs (club_name, club_description)
       VALUES (club_name, club_description);
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE update_club(old_club_name VARCHAR(256), new_club_name VARCHAR(256), club_description VARCHAR(1024))
 BEGIN
 START TRANSACTION;
       UPDATE clubs
          SET club_name = new_club_name,
              club_description = club_description
       WHERE club_name = old_club_name;
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE del_club(deleted_club_name VARCHAR(256)) -- NEEDS WORK
 BEGIN
 START TRANSACTION;
   DELETE FROM clubs
   WHERE club_name = deleted_club_name;

COMMIT;
   END
//
DELIMITER ;
