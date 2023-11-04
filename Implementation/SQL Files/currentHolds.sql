CREATE OR REPLACE activeHolds AS
SELECT *
  FROM holds
 WHERE holds_hold_is_activ e= TRUE;