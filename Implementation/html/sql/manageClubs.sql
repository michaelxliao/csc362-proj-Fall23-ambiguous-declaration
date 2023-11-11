DELIMITER //
CREATE OR REPLACE PROCEDURE add_club(new_club_name VARCHAR(256), new_club_description VARCHAR(1024))
 BEGIN
 START TRANSACTION;
       INSERT INTO clubs (club_name, club_description)
       VALUES (new_club_name, new_club_description);
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE update_club(id INT, new_club_name VARCHAR(256), club_description VARCHAR(1024))
 BEGIN
 START TRANSACTION;
       UPDATE clubs
          SET club_name = new_club_name,
              club_description = club_description
       WHERE club_id = id;
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE del_club(id INT) -- NEEDS WORK
 BEGIN
 START TRANSACTION;
   DELETE FROM clubs
   WHERE club_id = id;

COMMIT;
   END
//
DELIMITER ;
