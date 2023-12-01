-- For patrons_profile.php, we want to show
-- all active patrons and their number of current loans.
CREATE OR REPLACE VIEW pretty_patron_details_librarian
AS (
SELECT 
    patron_id AS 'ID', -- assuming this is the same as their library card's
    (CONCAT(patron_first_name, ' ', patron_last_name)) AS 'Name',
    COUNT(material_id) AS 'Number of Loans', -- need only current loans?
    patron_email AS 'Email',
    patron_phone AS 'Phone Number'

    FROM patrons
        LEFT OUTER JOIN patron_selection_interactions USING (patron_id)
        LEFT OUTER JOIN loans USING (interaction_id)
    
    WHERE patron_is_active = TRUE
    GROUP BY (patron_id)
);

-- for manage_selection.php
CREATE OR REPLACE VIEW pretty_selection_librarian AS
SELECT material_id AS 'ID',
       material_title AS 'Title',
       (CASE WHEN (NOT EXISTS (SELECT 1 FROM current_loans WHERE current_loans.material_id = active_selection.material_id))
        THEN 'On Shelf'
        ELSE 'Checked Out'
        END) AS 'Available for Checkout?', -- should be filterable
       material_date_received AS 'Date Selected into Library', -- prolly leave to drill-down
       material_date_created AS 'Date Created',
       (CASE WHEN material_is_pending
       THEN 'Not Processed Yet'
       ELSE 'Processed'
       END) AS 'Pending?', -- should be filterable
       material_price AS 'Cost', -- prolly leave to drill-down
       GROUP_CONCAT(DISTINCT CONCAT(creator_role, ': ', creator_first_name, ' ', creator_last_name) SEPARATOR ', ') AS 'Creator(s)', -- later: hide these on page :)
    --    GROUP_CONCAT(creator_role SEPARATOR ', ') AS 'Role',
       GROUP_CONCAT(DISTINCT genre_name SEPARATOR ', ') AS 'Genre(s)',
       GROUP_CONCAT(DISTINCT language_name SEPARATOR ', ') AS 'Language(s)',
       (CASE WHEN (multimedia_type IS NULL)
       THEN print_type
       ELSE multimedia_type
       END) AS 'Type',
       (CASE WHEN (multimedia_type IS NULL)
       THEN page_count
       ELSE duration
       END) AS 'Length'
  FROM active_selection
       LEFT OUTER JOIN print_materials USING(material_id)
       LEFT OUTER JOIN multimedia USING(material_id)
       LEFT OUTER JOIN selection_creators USING(material_id)
       LEFT OUTER JOIN creators USING (creator_id)
       LEFT OUTER JOIN creator_roles USING (creator_role)
       LEFT OUTER JOIN selection_genres USING (material_id)
       LEFT OUTER JOIN selection_languages USING (material_id)
 GROUP BY material_id;

-- for profile_clubs.php
CREATE OR REPLACE VIEW pretty_clubs_librarian AS
SELECT club_id AS 'ID',
       club_name AS 'Name',
       club_description AS 'Description'
  FROM active_clubs
 ORDER BY club_name;

 -- for profile_adaptations.php
 CREATE OR REPLACE VIEW pretty_narratives_librarian AS
 SELECT DISTINCT narrative_name AS 'Narrative',
        material_title AS 'Source Material'
    FROM active_narratives
         INNER JOIN adaptations USING(narrative_id)
         LEFT OUTER JOIN selection USING(material_id)
   WHERE material_is_source;

   CREATE OR REPLACE VIEW pretty_clubs_and_roles AS
   SELECT club_id AS 'ID',
       club_name AS 'Name',
       (CASE WHEN (member_info = "")
       THEN 'Member'
       ELSE member_info END) AS 'Member Role', -- when "", "Member"
       club_description AS 'Club Description',
       patron_id
    FROM active_clubs
    LEFT OUTER JOIN club_members USING (club_id)
    ORDER BY club_name;


-- for session_spaces_find.php
    CREATE OR REPLACE VIEW pretty_all_upcoming_space_reservations AS
    SELECT reservation_id,
    space_name AS 'Reserved Space', 
    space_room_number AS 'Room Number',
    start_reservation AS 'Start Time',
    end_reservation AS 'End Time',
    reservation_notes AS 'Notes'
    FROM space_reservations
    LEFT OUTER JOIN spaces USING (space_id) 
    LEFT OUTER JOIN club_reservations USING (reservation_id)
    LEFT OUTER JOIN clubs USING (club_id)
    WHERE end_reservation > CURRENT_TIMESTAMP()
    ORDER BY start_reservation ASC;

    -- for session_spaces.php
    CREATE OR REPLACE VIEW pretty_upcoming_space_reservations AS
    SELECT reservation_id,
    patron_id,
    space_name AS 'Reserved Space', 
    space_room_number AS 'Room Number',
    start_reservation AS 'Start Time',
    end_reservation AS 'End Time', 
    club_name AS 'Associated Club',
    reservation_notes AS 'Notes'
    FROM space_reservations
    LEFT OUTER JOIN spaces USING (space_id) 
    LEFT OUTER JOIN club_reservations USING (reservation_id)
    LEFT OUTER JOIN clubs USING (club_id)
    WHERE end_reservation > CURRENT_TIMESTAMP()
    ORDER BY start_reservation ASC;


-- for session_spaces_past.php
    CREATE OR REPLACE VIEW pretty_past_space_reservations AS
    SELECT reservation_id,
    patron_id,
    space_name AS 'Reserved Space', 
    space_room_number AS 'Room Number',
    start_reservation AS 'Start Time',
    end_reservation AS 'End Time', 
    club_name AS 'Associated Club',
    reservation_notes AS 'Notes'
    FROM space_reservations
    LEFT OUTER JOIN spaces USING (space_id) 
    LEFT OUTER JOIN club_reservations USING (reservation_id)
    LEFT OUTER JOIN clubs USING (club_id)
    ORDER BY start_reservation DESC;


DELIMITER //
CREATE OR REPLACE PROCEDURE increment_loan_renewal(reservationid INT)
 BEGIN
 START TRANSACTION;
UPDATE loans
       SET loans.loan_renewal_tally = loan_renewal_tally + 1
    WHERE interaction_id = reservationid;
    COMMIT;
   END
//
DELIMITER ;

-- used in profile_holds. Gets relevant fields from holds that are currently being processed!
CREATE OR REPLACE VIEW processing_holds AS
SELECT material_id,
       material_title,
       patron_id,
       patron_email,
       patron_phone,
       patron_first_name,
       patron_last_name
       FROM holds
    LEFT OUTER JOIN patron_selection_interactions USING (interaction_id)
    LEFT OUTER JOIN selection USING (material_id)
    LEFT OUTER JOIN patrons USING (patron_id)

GROUP BY material_id
ORDER BY hold_date_requested;
