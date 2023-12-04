CREATE OR REPLACE VIEW active_spaces AS
(
    SELECT *
      FROM spaces
     WHERE space_is_active = TRUE
);