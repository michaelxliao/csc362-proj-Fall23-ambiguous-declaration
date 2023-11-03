CREATE OR REPLACE activeHolds AS
SELECT *
FROM holds
WHERE holds.hold_isActive=TRUE;