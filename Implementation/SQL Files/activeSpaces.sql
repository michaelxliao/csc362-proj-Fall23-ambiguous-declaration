CREATE VIEW active_spaces AS
(
    SELECT space_id, space_name, space_room_number, space_capacity
    FROM spaces
    WHERE space_is_active = TRUE
);