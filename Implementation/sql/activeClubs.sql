CREATE OR REPLACE VIEW active_clubs AS
SELECT *
  FROM clubs
 WHERE clubs.club_is_active = TRUE;