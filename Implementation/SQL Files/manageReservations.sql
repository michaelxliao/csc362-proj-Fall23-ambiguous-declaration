DELIMITER //
CREATE OR REPLACE PROCEDURE add_reservation(patronid INT, spaceid INT, start_time DATETIME, end_time DATETIME, notes VARCHAR(256))
 BEGIN
 START TRANSACTION;
    INSERT INTO space_reservations(patron_id, space_id, start_reservation, end_reservation, reservation_notes)
    VALUES (patronid, spaceid, start_time, end_time, notes);
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE update_reservation(id INT, patronid INT, spaceid INT, start_time DATETIME, end_time DATETIME, notes VARCHAR(256))
 BEGIN
 START TRANSACTION;
    UPDATE space_reservations
        SET space_reservations.space_id = spaceid,
            space_reservations.patron_id = patronid,
            space_reservations.start_reservation = start_time,
            space_reservations.end_reservation = end_time

    WHERE space_reservations.reservation_id = id;
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE del_reservation(reservationid INT)
 BEGIN
 START TRANSACTION;
    DELETE FROM space_reservations
    WHERE space_reservations.reservation_id = reservationid;
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE add_club_reserve(reserveid INT, clubid INT)
 BEGIN
 START TRANSACTION;
    INSERT INTO club_reservations(reservation_id, club_id)
    VALUES (reserve_id, club_id);
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE update_club_reserve(reserveid INT, clubid INT)
 BEGIN
 START TRANSACTION;
    UPDATE club_reservations
        SET club_reservations.reservation_id = reserveid,
            club_reservations.club_id = clubid
    WHERE (club_reservations.reservation_id = reserveid and club_reservations.club_id = clubid);
COMMIT;
   END
//
DELIMITER ;

DELIMITER //
CREATE OR REPLACE PROCEDURE del_club_reserve(reserveid INT, clubid INT)
 BEGIN
 START TRANSACTION;
    DELETE FROM club_reservations
    WHERE (club_reservations.reservation_id = reserve_id and club_reservations.club_id = clubid);
COMMIT;
   END
//
DELIMITER ;