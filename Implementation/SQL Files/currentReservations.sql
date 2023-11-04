-- current == END DATE is in the future. 

CREATE OR REPLACE VIEW current_reservations AS
SELECT *
  FROM space_reservations
 WHERE end_reservation > CURDATE();