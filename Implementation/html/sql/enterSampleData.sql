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

INSERT INTO patrons(patron_first_name, patron_last_name, patron_email, patron_phone)
VALUES  ("Rashawn","Butler","rashawn.butler@centre.edu", "111-111-1111"),
        ("Pierce","Mason","pierce.mason@centre.edu","222-222-2222"),
        ("Michael","Liao","michael.liao@centre.edu","333-333-3333"),
        ("Minecraft","Steve",NULL,"100-200-3000"),
        ("Sans", "Undertale","tobyfox@urmom.com",NULL),
        ("Cuttlefish","Capn",NULL,"420-420-8008");
        
INSERT INTO club_members(patron_id, club_id, member_info, member_is_leader)
VALUES  (1,5,"Can only play on monday and friday",FALSE),
        (2,5,"Can only play on tuseday and thursday",FALSE),
        (3,5,"Can only play on wedneday",TRUE),
        (1,2,"Reads fantasy books",TRUE),
        (2,2,"Reads monster manuals",FALSE),
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


/* Selection Sample Data (see: ChatGPTprompts.sql */
-- Inserting print materials
CALL add_print_material('The Adventures of Codey the Coding Cat', '2023-01-15', '1980-01-10', TRUE, 29.99, 'Hardcover', 150); -- 1
CALL add_print_material('Galactic Pizza Recipes', '2023-02-25', '1980-02-20', FALSE, 19.99, 'Paperback', 100); -- 2

-- Inserting multimedia materials
-- NOTE: "Digital Download" and "Audio Streaming" were changed to "Movie" and "Podcast"
CALL add_multimedia_material('Space Explorers: The Musical', '2023-03-25', '1955-03-20', TRUE, 9.99, 'Movie', '01:45:00'); -- 3
CALL add_multimedia_material('The Laughing Llamas Podcast', '2023-04-30', '1980-04-25', FALSE, 0.99, 'Podcast', '00:45:00'); -- 4

-- Back to not-chatGPT
-- name, date inserted, date created, is pending, price, material type, page number OR length
CALL add_print_material('The Cento', '2023-08-16', '2023-08-15', TRUE, 0.09, 'Magazine', 5); -- 5
CALL add_print_material('The CenTWO', '2023-08-17', '2023-08-16', TRUE, 0.09, 'Magazine', 5); -- 6
CALL add_print_material('The CenThree', '2023-08-18', '2023-08-16', FALSE, 0.09, 'Magazine', 5); -- 7
CALL add_print_material('Galactic Burger Recipes', '2023-02-20', '1980-02-25', FALSE, 19.99, 'Paperback', 120); -- 8
CALL add_print_material('Galactic Grepcipes', '2023-02-20', '1980-02-25', FALSE, 19.99, 'Paperback', 80); -- 9
CALL add_print_material('Codey the Coding Cat Fell In A Hole', '2023-01-15', '1990-01-10', TRUE, 29.99, 'Hardcover', 120); -- 10
CALL add_print_material('Codey the Coding Cat Fell In A Hole', '2023-01-15', '1990-01-10', TRUE, 29.99, 'Paperback', 120); -- 11
CALL add_print_material('Dune', '2003-01-15', '1965-01-10', TRUE, 29.99, 'Paperback', 1230); -- 12

CALL add_multimedia_material('Space Explorers: The Movie', '2023-03-25', '1980-03-20', TRUE, 9.99, 'Movie', '01:45:00'); -- 13
CALL add_multimedia_material('Space Explorers Two: The Subspace Explorers Attack', '2023-03-25', '1982-03-20', TRUE, 9.99, 'Movie', '02:30:00'); -- 14
CALL add_multimedia_material('Space Explorers Three: Revenge of the Schmedi', '2023-04-30', '1985-04-25', FALSE, 0.99, 'Movie', '03:45:00'); -- 15
CALL add_multimedia_material('Larry Llama Talks About Laughter', '2023-04-30', '2023-04-25', FALSE, 0.99, 'Podcast', '00:39:00'); -- 16
CALL add_multimedia_material('Louise Llama Does Stand-Up', '2023-04-30', '2023-04-25', FALSE, 0.99, 'Podcast', '00:39:00');  -- 17
CALL add_multimedia_material('The Podcast With No Narrative', '2023-04-30', '1900-04-25', FALSE, 0.99, 'Podcast', '00:20:00'); -- 18
CALL add_multimedia_material('Dune Your Mom', '2020-04-20', '2019-04-25', FALSE, 14.99, 'Movie', '00:39:00'); -- 19
CALL add_print_material('The Adventures of Codey the Coding Cat', '2023-01-15', '1980-01-10', TRUE, 29.99, 'Paperback', 150); -- 20


INSERT INTO creators(creator_first_name, creator_last_name)
VALUES ("Steven", "Spielberg"), -- 1
       ("Stephen", "Rout"), -- 2
       ("Hatsune", "Miku"), -- 3
       ("Rebecca", "Sugar"); -- 4

INSERT INTO creator_roles(creator_role)
VALUES ("Director"),
       ("Producer"),
       ("Voice Actor"),
       ("Actor"),
       ("Author");

INSERT INTO languages(language_name)
VALUES ("English"),
       ("French"),
       ("Japanese");
    
INSERT INTO genres(genre_name)
VALUES  ("Sci-Fi"),
        ("Fantasy"),
        ("Romance"),
        ("Adventure"), 
        ("Comedy");

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
(3,"English"),
(4,"English"),
(4,"French"),
(16,"English"),
(16,"French"),
(18,"English"),
(18,"Japanese"),
(19,"English"),
(19,"French"),
(19,"Japanese");

-- selection_creators

INSERT INTO selection_creators(creator_id, material_id, creator_role)
VALUES
(1, 3, "Author"),
(1, 10, "Author"),
(1, 11, "Author"),
(2, 5, "Voice Actor"),
(2, 6, "Author"),
(2, 6, "Voice Actor"),
(2, 7, "Voice Actor"),
(3, 19, "Actor"),
(4, 19, "Director");

-- selection_genres

INSERT INTO selection_genres(material_id, genre_name) 
VALUES
(1, "Fantasy"),
(10, "Fantasy"),
(11, "Fantasy"),
(10, "Adventure"),
(11, "Adventure"),
(4, "Comedy"),
(16, "Romance"),
(16, "Comedy"),
(17, "Comedy");

-- patron selection interactions
-- add_loan(material_id INT, patron_id INT, loan_start DATE, loan_return DATE, loan_renewal_tally INT)
-- add_hold(material_id INT, patron_id INT, hold_date DATETIME)
CALL add_loan(5, 1, '2023-10-29', '2023-11-02', 0);
CALL add_loan(5, 1, '2023-11-05', '2023-11-12', 1);
CALL add_loan(5, 2, '2023-9-29', '2023-10-15', 0);
CALL add_loan(5, 3, '2023-10-29', '2023-11-02', 0);
CALL add_loan(4, 4, '2023-10-29', NULL, 2);
CALL add_loan(2, 5, '2023-10-29', NULL, 0);
CALL add_loan(1, 5, '2023-10-10', NULL, 3);
CALL add_loan(12, 5, '2023-10-10', NULL, 1);
CALL add_hold(1, 4, '2023-10-11 ');
CALL add_hold(4, 1, '2023-11-10 07:00:00');
CALL add_hold(4, 2, '2023-11-12 04:00:00');

-- club reservations

CALL add_reservation(1, 1, '2023-11-01 03:00:00', '2023-11-01 07:00:00', "Knights when they");