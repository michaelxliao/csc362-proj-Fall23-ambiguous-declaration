CREATE OR REPLACE VIEW active_holds AS
SELECT *
  FROM holds
 WHERE holds_hold_is_active = TRUE;