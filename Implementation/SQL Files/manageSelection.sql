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

       INSERT INTO multimedia_materials (material_id, multimedia_type, duration)
       VALUES (LAST_INSERT_ID(), multimedia_type, duration);
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE del_print_material()
 BEGIN
 START TRANSACTION;
       
COMMIT;
   END
//
DELIMITER ;
