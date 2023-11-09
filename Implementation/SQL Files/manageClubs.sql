DELIMITER //
<<<<<<< HEAD
CREATE OR REPLACE PROCEDURE add_Club(new_club_name VARCHAR(256), new_club_description)
 BEGIN
 START TRANSACTION;
       INSERT INTO clubs( club_name, club_description)
       VALUES(new_club_name, new_club_description);
=======
CREATE OR REPLACE PROCEDURE add_club(club_name VARCHAR(256), club_description VARCHAR(1024))
 BEGIN
 START TRANSACTION;
       INSERT INTO clubs (club_name, club_description)
       VALUES (club_name, club_description);
>>>>>>> 1f1ab4defb9d9c43a709ba33b580b87445918543
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
              clubs.club_description = club_description
       WHERE club_id = id;
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
