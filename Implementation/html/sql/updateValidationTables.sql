/* Multimedia Types */
DELIMITER //
CREATE OR REPLACE PROCEDURE add_multimedia_type(multimedia_type VARCHAR(256))
 BEGIN
 START TRANSACTION;
       INSERT INTO multimedia_types (multimedia_type)
       VALUES (multimedia_type);
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE del_multimedia_type(multimedia_type VARCHAR(256))
 BEGIN
 START TRANSACTION;
       DELETE FROM multimedia_types
        WHERE multimedia_types.multimedia_type = multimedia_type;
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE update_multimedia_type(old_multimedia_type VARCHAR(256), new_multimedia_type VARCHAR(256))
 BEGIN
 START TRANSACTION;
       UPDATE multimedia_types
          SET multimedia_type = new_multimedia_type
        WHERE multimedia_types.multimedia_type = old_multimedia_type;
COMMIT;
   END
//
DELIMITER ;


/* Print Types */
DELIMITER //
CREATE OR REPLACE PROCEDURE add_print_type(print_type VARCHAR(256))
 BEGIN
 START TRANSACTION;
       INSERT INTO print_types (print_type)
       VALUES (print_type);
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE del_print_type(print_type VARCHAR(256))
 BEGIN
 START TRANSACTION;
       DELETE FROM print_types
        WHERE print_types.print_type = print_type;
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE update_print_type(old_print_type VARCHAR(256), new_print_type VARCHAR(256))
 BEGIN
 START TRANSACTION;
       UPDATE print_types
          SET print_type = new_print_type
        WHERE print_types.print_type = old_mult_type;
COMMIT;
   END
//
DELIMITER ;


/* Languages */
DELIMITER //
CREATE OR REPLACE PROCEDURE add_language(language_name VARCHAR(256))
 BEGIN
 START TRANSACTION;
       INSERT INTO languages (language_name)
       VALUES (language_name);
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE del_language(language_name VARCHAR(256))
 BEGIN
 START TRANSACTION;
       DELETE FROM languages
        WHERE language_name.language_name = language_name;
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE update_language(old_language VARCHAR(256), new_language VARCHAR(256))
 BEGIN
 START TRANSACTION;
       UPDATE languages
          SET language_name = new_language
        WHERE languages.language_name = old_language;
COMMIT;
   END
//
DELIMITER ;


/* Genres */
DELIMITER //
CREATE OR REPLACE PROCEDURE add_genre(genre_name VARCHAR(256))
 BEGIN
 START TRANSACTION;
       INSERT INTO genres (genre_name)
       VALUES (genre_name);
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE del_genre(genre_name VARCHAR(256))
 BEGIN
 START TRANSACTION;
       DELETE FROM genres
        WHERE genre_name.genre_name = genre_name;
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE update_genre(old_genre VARCHAR(256), new_genre VARCHAR(256))
 BEGIN
 START TRANSACTION;
       UPDATE genres
          SET genre_name = new_genre
        WHERE genres.genre_name = old_genre;
COMMIT;
   END
//
DELIMITER ;


/* Narratives */
DELIMITER //
CREATE OR REPLACE PROCEDURE add_narrative(narrative_name VARCHAR(256), narrative_description VARCHAR(1024))
 BEGIN
 START TRANSACTION;
       INSERT INTO narratives (narrative_name, narrative_description)
       VALUES (narrative_name, narrative_description);
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE del_narrative(narrative_id INT)
 BEGIN
 START TRANSACTION;
       DELETE FROM narratives
        WHERE narrative.narrative_id = narrative_id;
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE update_narrative(id INT, new_name VARCHAR(256), new_desc VARCHAR(1024))
 BEGIN
 START TRANSACTION;
       UPDATE narratives
          SET narratives.narrative_name = new_name,
              narratives.narrative_description = new_desc
        WHERE narratives.narrative_id = id;
COMMIT;
   END
//
DELIMITER ;

/* Creator Roles */
DELIMITER //
CREATE OR REPLACE PROCEDURE add_creator_role(creator_role VARCHAR(256))
 BEGIN
 START TRANSACTION;
       INSERT INTO creator_roles (creator_role)
       VALUES (creator_role);
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE del_creator_role(creator_role VARCHAR(256))
 BEGIN
 START TRANSACTION;
       DELETE FROM creator_roles
        WHERE creator_roles.creator_role = creator_role;
COMMIT;
   END
//
DELIMITER ;