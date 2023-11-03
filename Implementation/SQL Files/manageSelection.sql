DELIMITER //
CREATE OR REPLACE PROCEDURE add_print_material(title VARCHAR(256), date_received DATE, date_created DATE, is_pending BOOLEAN, price DECIMAL(10,2), num_pages INT, print_type VARCHAR(256))
 BEGIN
 START TRANSACTION;
       
COMMIT;
   END
//
DELIMITER ;

CREATE OR REPLACE PROCEDURE add_multimedia_material()
