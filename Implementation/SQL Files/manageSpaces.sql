DELIMITER //
CREATE OR REPLACE PROCEDURE add_space(title VARCHAR(256), room_number INT, capacity INT)
 BEGIN
 START TRANSACTION;
      INSERT INTO spaces(space_name, space_room_number, space_capacity)
      VALUES (title, room_number, capacity)
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE update_space(id INT, title VARCHAR(256), room_number INT, capacity INT)
 BEGIN
 START TRANSACTION;
      UPDATE spaces
         SET spaces.space_id = id,
         SET spaces.space_title = title,
         SET spaces.space_room_number = room_number,
         SET spaces.space_capacity = capacity

      WHERE space_id = id;
       
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE del_space(space_id INT)
 BEGIN
 START TRANSACTION;
   DELETE FROM TABLE spaces
   WHERE spaces.space_id = space_id;
   -- spaces table handles deny

COMMIT;
   END
//
DELIMITER ;