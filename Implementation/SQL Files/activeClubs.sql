CREATE OR REPLACE activeClubs AS
SELECT club_id, club_name
FROM clubs
WHERE clubs.club_isActive=TRUE;