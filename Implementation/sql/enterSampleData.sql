USE therpston;

INSERT INTO spaces(space_name, space_room_number, space_capacity)
VALUES
("The Round Table", 1, 150),
("The Square Table", 2, 40),
("The Other Table", 202, 40);

INSERT INTO clubs(club_name, club_description, club_is_active)
VALUES
("Inkling Performance Labs", "Inkling Performance Labs' goal is to unite and grow the community by creating high quality Splatoon tournaments. We want to promote the growth of Splatoon, both in working to bring in new members, along with helping improve those already in the community.", True),
("Reading Club", "It's a library. What did you expect", True),
("Poetry Club", "We're a budding club \n Like sakura in spring \n We, too, share our hearts.", True),
("Evil Poetry Club", "Make a better haiku losers", True),
("D&D Club", "Scheduling issues :(", False);

/*
            INT             AUTO_INCREMENT,
    space_name          VARCHAR(256)    NOT NULL,
    space_room_number   INT             NOT NULL,
    space_capacity      INT             NOT NULL,
    space_is_active)
    */
INSERT INTO patrons(patron_first_name, patron_last_name, patron_email, patron_phone)
VALUES  ("Rashawn","Butler", "rashawn.butler@centre.edu", "111-111-1111"),
        ("Pierce","Mason","Pierce.mason@centre.edu","222-222-2222"),
        ("Michael","Liao","Michael.Lioa@centre.edu","333-333-3333");
        
INSERT INTO club_members(patron_id, club_id, member_info, member_is_leader)
VALUES  (1,5,"Can only play on monday and friday",FALSE),
        (2,5,"Can only play on tuseday and thursday",FALSE),
        (3,5,"Can only play on wedneday",TRUE),
        (1,2,"Reads fantasy books",TRUE),
        (2,2,"Reads monster manuels",FALSE),
        (3,4,"Reads poetry about ruling the moon", TRUE);

INSERT INTO multimedia_types (multimedia_type)
VALUES ("DVD"),
       ("Audio CD"),
       ("Blu-Ray"),
       ("Movie"),
       ("Podcast"),
       ("Audiobook"),
       ("Digital Download"),
       ("Audio Streaming");

INSERT INTO print_types (print_type)
VALUES ("Hardcover"),
       ("Paperback"),
       ("Magazine"),
       ("Journal");

INSERT INTO space_reservations(patron_id, space_id, start_reservation, end_reservation, reservation_notes)
VALUES
(1, 1, '2023-11-29 06:00:00', '2023-11-29 07:00:00', "Things happening here"),
(1, 2, '2023-11-29 07:00:00', '2023-11-29 08:00:00', "Things happening there"),
(2, 1, '2023-11-29 07:00:00', '2023-11-29 08:00:00', "Things happening here too"),
(3, 3, '2023-11-28 06:00:00', '2023-11-29 07:00:00', "Things happening also");


/* Selection Sample Data */
/* Generated with ChatGPT 3.5, using the following prompts:
Help me generate some filler data for this table, which notably has two subset tables:
[The contents of the selection.sql, printMaterials.sql, and multimedia.sql files.]
You may use the following procedures to insert this sample data.
[The contents of the manageSelection.sql file.]

(ChatGPT responds with:)
-- Inserting print materials
CALL add_print_material('Book 1', '2023-01-01', '2023-01-01', TRUE, 19.99, 'Hardcover', 300);
CALL add_print_material('Book 2', '2023-02-01', '2023-02-01', FALSE, 14.99, 'Paperback', 200);

-- Inserting multimedia materials
CALL add_multimedia_material('Movie 1', '2023-03-01', '2023-03-01', TRUE, 9.99, 'DVD', '02:30:00');
CALL add_multimedia_material('Podcast 1', '2023-04-01', '2023-04-01', FALSE, 0.99, 'Audio CD', '01:15:00');

I prompt: Make them more fun! Come up with feasible-sounding data that is still clearly sample data.

Result is as follows, unedited. */

-- Inserting print materials
CALL add_print_material('The Adventures of Codey the Coding Cat', '2023-01-15', '2023-01-10', TRUE, 29.99, 'Hardcover', 150);
CALL add_print_material('Galactic Pizza Recipes', '2023-02-20', '2023-02-15', FALSE, 19.99, 'Paperback', 100);

-- Inserting multimedia materials
CALL add_multimedia_material('Space Explorers: The Musical', '2023-03-25', '2023-03-20', TRUE, 9.99, 'Digital Download', '01:45:00');
CALL add_multimedia_material('The Laughing Llamas Podcast', '2023-04-30', '2023-04-25', FALSE, 0.99, 'Audio Streaming', '00:45:00');
