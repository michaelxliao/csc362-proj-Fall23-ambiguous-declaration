CREATE OR REPLACE VIEW active_holds AS
SELECT *
  FROM holds
 WHERE hold_is_active = TRUE;