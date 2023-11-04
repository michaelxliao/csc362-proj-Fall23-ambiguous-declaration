CREATE OR REPLACE active_clubs AS
SELECT club_id, club_name, club_description
 FROM clubs
WHERE clubs.club_is_active = TRUE;