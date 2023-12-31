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
CREATE OR REPLACE PROCEDURE update_club(id INT, new_club_name VARCHAR(256), new_club_description VARCHAR(1024))
 BEGIN
 START TRANSACTION;
       UPDATE clubs
          SET clubs.club_name = new_club_name,
              clubs.club_description = new_club_description
       WHERE club_id = id;
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE del_club(id INT)
 BEGIN
 START TRANSACTION;
   UPDATE clubs
      SET club_is_active = FALSE
   WHERE clubs.club_id = id;

COMMIT;
   END
//
DELIMITER ;
