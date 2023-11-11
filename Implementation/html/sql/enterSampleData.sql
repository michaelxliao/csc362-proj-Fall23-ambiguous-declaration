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
VALUES  ("Rashawn","Butler","rashawn.butler@centre.edu", "111-111-1111"),
        ("Pierce","Mason","pierce.mason@centre.edu","222-222-2222"),
        ("Michael","Liao","michael.liao@centre.edu","333-333-3333"),
        ("Minecraft","Steve",NULL,"100-200-3000");
        
INSERT INTO club_members(patron_id, club_id, member_info, member_is_leader)
VALUES  (1,5,"Can only play on monday and friday",FALSE),
        (2,5,"Can only play on tuseday and thursday",FALSE),
        (3,5,"Can only play on wedneday",TRUE),
        (1,2,"Reads fantasy books",TRUE),
        (2,2,"Reads monster manuels",FALSE),
        (3,4,"Reads poetry about ruling the moon", TRUE);

INSERT INTO multimedia_types (multimedia_type)
VALUES ("Movie"),
       ("Podcast"),
       ("Audiobook");

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
CALL add_print_material('The Adventures of Codey the Coding Cat', '2023-01-15', '2023-01-10', TRUE, 29.99, 'Hardcover', 150); -- 1
CALL add_print_material('Galactic Pizza Recipes', '2023-02-20', '2023-02-25', FALSE, 19.99, 'Paperback', 100); -- 2



-- Inserting multimedia materials
-- NOTE: "Digital Download" and "Audio Streaming" were changed to "Movie" and "Podcast"
CALL add_multimedia_material('Space Explorers: The Musical', '2023-03-25', '2023-03-20', TRUE, 9.99, 'Movie', '01:45:00'); -- 3
CALL add_multimedia_material('The Laughing Llamas Podcast', '2023-04-30', '2023-04-25', FALSE, 0.99, 'Podcast', '00:45:00'); -- 4

-- Back to not-chatGPT
-- name, date inserted, date created, is pending, price, material type, page number OR length
CALL add_print_material('The Cento', '2023-08-16', '2023-08-23', TRUE, 0.09, 'Magazine', 5); -- 5
CALL add_print_material('The CenTWO', '2023-08-17', '2023-08-23', TRUE, 0.09, 'Magazine', 5); -- 6
CALL add_print_material('The CenThree', '2023-08-17', '2023-08-23', FALSE, 0.09, 'Magazine', 5); -- 7
CALL add_print_material('Galactic Burger Recipes', '2023-02-20', '2023-02-25', FALSE, 19.99, 'Paperback', 120); -- 8
CALL add_print_material('Galactic Grepcipes', '2023-02-20', '2023-02-25', FALSE, 19.99, 'Paperback', 80); -- 9
CALL add_print_material('Codey the Coding Cat Fell In A Hole', '2023-01-15', '2023-01-10', TRUE, 29.99, 'Hardcover', 120); -- 10
CALL add_print_material('Codey the Coding Cat Fell In A Hole', '2023-01-15', '2023-01-10', TRUE, 29.99, 'Paperback', 120); -- 11
CALL add_print_material('Dune', '2003-01-15', '1965-01-10', TRUE, 29.99, 'Paperback', 1230); -- 12

CALL add_multimedia_material('Space Explorers: The Movie', '2023-03-25', '2023-03-20', TRUE, 9.99, 'Movie', '01:45:00'); -- 13
CALL add_multimedia_material('Space Explorers Two: The Subspace Explorers Attack', '2023-03-25', '2023-03-20', TRUE, 9.99, 'Movie', '02:30:00'); -- 14
CALL add_multimedia_material('Space Explorers Three: Revenge of the Schmedi', '2023-04-30', '2023-04-25', FALSE, 0.99, 'Movie', '03:45:00'); -- 15
CALL add_multimedia_material('Larry Llama Talks About Laughter', '2023-04-30', '2023-04-25', FALSE, 0.99, 'Podcast', '00:39:00'); -- 16
CALL add_multimedia_material('Louise Llama Does Stand-Up', '2023-04-30', '2023-04-25', FALSE, 0.99, 'Podcast', '00:39:00');  -- 17
CALL add_multimedia_material('The Podcast With No Narrative', '2023-04-30', '2023-04-25', FALSE, 0.99, 'Podcast', '00:20:00'); -- 18
CALL add_multimedia_material('Dune Your Mom', '2020-04-20', '2019-04-25', FALSE, 14.99, 'Movie', '00:39:00'); -- 19
CALL add_print_material('The Adventures of Codey the Coding Cat', '2023-01-15', '2023-01-10', TRUE, 29.99, 'Paperback', 150); -- 20


INSERT INTO creators(creator_first_name, creator_last_name)
VALUES ("Steven", "Spielberg"), -- 1
       ("Stephen", "Rout"), -- 2
       ("Hatsune", "Miku"), -- 3
       ("Rebecca", "Sugar"); -- 4

INSERT INTO creator_roles(creator_roles)
VALUES ("Director"), -- 1
       ("Producer"), -- 2
       ("Voice Actor"), -- 3
       ("Actor"); -- 4

INSERT INTO languages(language_name)
VALUES ("English"), -- 1
       ("French"), -- 2
       ("Japanese"); -- 3
    
INSERT INTO genres(genre_name)
VALUES  ("Sci-Fi"), -- 1
        ("Fantasy"), -- 2
        ("Romance"), -- 3
        ("Adventure"); -- 4

INSERT INTO narratives(narrative_name, narrative_description)
VALUES
("Codey the Coding Cat", "when the cat codes"), -- 1
("Space Explorers", "omg guys its luke skytrotter (he's a pig in this one)"), -- 2
("Llama Podcasts", "llamas talk so you don't feel lonely and develop a parasocial bond"), -- 3
-- below source: Wikipedia  -- also id 4 btw
("Dune", "tens of thousands of years in the future, the saga chronicles a civilization that has banned all 'thinking machines', which include computers, robots, and artificial intelligence. In their place, civilization has developed advanced mental and physical disciplines as well as advanced technologies that adhere to the ban on computers. Vital to this empire is the harsh desert planet Arrakis, the only known source of the spice melange, the most valuable substance in the universe. "),
("Baba Yaga", "a witch from Slavic folklore with a fun house");  -- 5

INSERT INTO adaptations(narrative_id, material_id, material_is_source)
VALUES
-- codey the coding cat
(1, 1, 1),
(1,20,1),
(1, 10, 0),
(1, 11, 0),
-- space explorers
(2,3,1),
(2,15,0),
(2,16,0),
(2,17,0),

-- laughing llamas
(3,4,1),
(3,16,0),
(3,17,0)
;

-- best case this is done for all of them.
INSERT INTO selection_languages(material_id, language_name)
VALUES
(3,1),
(4,1),
(4,2),
(16,1),
(16,2),
(18,1),
(18,3),
(19,1),
(19,2),
(19,3);

-- selection_creator


-- selection_genres
INSERT INTO selection_genres