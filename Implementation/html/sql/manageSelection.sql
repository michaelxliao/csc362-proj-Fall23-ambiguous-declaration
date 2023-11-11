DELIMITER //
CREATE OR REPLACE PROCEDURE add_print_material(title VARCHAR(256), date_received DATE, date_created DATE, is_pending BOOLEAN, price DECIMAL(10,2), print_type VARCHAR(256), num_pages INT)
 BEGIN
 START TRANSACTION;
       INSERT INTO selection (material_title, material_date_received, material_date_created, material_is_pending, material_price)
       VALUES (title, date_received, date_created, is_pending, price);

       INSERT INTO print_materials (material_id, print_type, page_count)
       VALUES (LAST_INSERT_ID(), print_type, num_pages);
COMMIT;
   END
//
DELIMITER ; -- technically unneccessary but just for the sake of ease of moving blocks around

DELIMITER //
CREATE OR REPLACE PROCEDURE add_multimedia_material(title VARCHAR(256), date_received DATE, date_created DATE, is_pending BOOLEAN, price DECIMAL(10,2), multimedia_type VARCHAR(256), duration TIME)
 BEGIN
 START TRANSACTION;
       INSERT INTO selection (material_title, material_date_received, material_date_created, material_is_pending, material_price)
       VALUES (title, date_received, date_created, is_pending, price);

       INSERT INTO multimedia (material_id, multimedia_type, duration)
       VALUES (LAST_INSERT_ID(), multimedia_type, duration);
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE del_material(material_id INT)
 BEGIN
 START TRANSACTION;
       DElETE FROM selection
       WHERE selection.material_id = material_id;
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE update_print_material(material_id INT, title VARCHAR(256), date_received DATE, date_created DATE, is_pending BOOLEAN, price DECIMAL(10,2), print_type VARCHAR(256), num_pages INT)
 BEGIN
 START TRANSACTION;
       UPDATE selection
          SET selection.material_title = title,
              selection.material_date_received = date_received,
              selection.material_date_created = date_created,
              selection.material_is_pending = is_pending,
              selection.material_price = price
       WHERE selection.material_id = material_id;

       UPDATE print_materials
          SET print_materials.print_type = print_type,
              print_materials.page_count = num_pages
        WHERE print_materials.material_id = material_id;
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE update_multimedia_material(material_id INT, title VARCHAR(256), date_received DATE, date_created DATE, is_pending BOOLEAN, price DECIMAL(10,2), multimedia_type VARCHAR(256), duration TIME)
 BEGIN
 START TRANSACTION;
       UPDATE selection
          SET selection.material_title = title,
              selection.material_date_received = date_received,
              selection.material_date_created = date_created,
              selection.material_is_pending = is_pending,
              selection.material_price = price
       WHERE selection.material_id = material_id;

       UPDATE multimedia
          SET multimedia.multimedia_type = multimedia_type,
              multimedia.duration = duration
        WHERE multimedia.material_id = material_id;
COMMIT;
   END
//
DELIMITER ;