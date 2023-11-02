/* PROMPT: for ChatGPT 3.5
    Could you help me write out several SQL scripts (MariaDB flavored) to establish a database?
    Make sure all table and field names are in snake case, and
    that all data types are tabbed out (with white space) to the right so they all line up at the same column.
    Please make sure all ID artificial primary keys have AUTO_INCREMENT and NOT NULL attributes
    (as long as they are not foreign keys). Further make sure that simple primary key constraints
    are not written on the same line - instead, they should follow a pattern like below:

    primary_key_field INT AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (primary_key_field)

    I will pass along information on each of the tables now. Thank you!
    [The contents of the TableStructures.md file.]
*/

/* THIS VERSION OF THE FILE HAS NOT BEEN MODIFIED - IT IS RAW OUTPUT FROM CHATGPT. */

-- Multimedia Types
CREATE TABLE multimedia_types (
    multimedia_type_id INT AUTO_INCREMENT NOT NULL,
    multimedia_type_name VARCHAR(255) NOT NULL,
    PRIMARY KEY (multimedia_type_id)
);

-- Print Types
CREATE TABLE print_types (
    print_type_id INT AUTO_INCREMENT NOT NULL,
    print_type_name VARCHAR(255) NOT NULL,
    PRIMARY KEY (print_type_id)
);

-- Selection Languages
CREATE TABLE selection_languages (
    material_id INT NOT NULL,
    language_name VARCHAR(255) NOT NULL,
    PRIMARY KEY (material_id, language_name),
    FOREIGN KEY (material_id) REFERENCES selection(material_id),
    FOREIGN KEY (language_name) REFERENCES languages(language_name)
);

-- Languages
CREATE TABLE languages (
    language_name VARCHAR(255),
    PRIMARY KEY (language_name)
);

-- Selection Creators
CREATE TABLE selection_creators (
    material_id INT NOT NULL,
    creator_id INT NOT NULL,
    creator_role VARCHAR(255) NOT NULL,
    PRIMARY KEY (material_id, creator_id, creator_role),
    FOREIGN KEY (material_id) REFERENCES selection(material_id),
    FOREIGN KEY (creator_id) REFERENCES creators(creator_id),
    FOREIGN KEY (creator_role) REFERENCES creator_roles(creator_role)
);

-- Creators
CREATE TABLE creators (
    creator_id INT AUTO_INCREMENT NOT NULL,
    creator_first_name VARCHAR(255),
    creator_last_name VARCHAR(255),
    PRIMARY KEY (creator_id)
);

-- Creator Roles
CREATE TABLE creator_roles (
    creator_role VARCHAR(255),
    PRIMARY KEY (creator_role)
);

-- Selection Genres
CREATE TABLE selection_genres (
    material_id INT NOT NULL,
    genre_name VARCHAR(255) NOT NULL,
    PRIMARY KEY (material_id, genre_name),
    FOREIGN KEY (material_id) REFERENCES selection(material_id),
    FOREIGN KEY (genre_name) REFERENCES genres(genre_name)
);

-- Genres
CREATE TABLE genres (
    genre_name VARCHAR(255),
    PRIMARY KEY (genre_name)
);

-- Club Members
CREATE TABLE club_members (
    club_id INT NOT NULL,
    patron_id INT NOT NULL,
    member_info TEXT,
    member_is_leader BOOLEAN,
    PRIMARY KEY (club_id, patron_id),
    FOREIGN KEY (club_id) REFERENCES clubs(club_id),
    FOREIGN KEY (patron_id) REFERENCES patrons(patron_id)
);

-- Club Reservations
CREATE TABLE club_reservations (
    reservation_id INT AUTO_INCREMENT NOT NULL,
    club_id INT NOT NULL,
    PRIMARY KEY (reservation_id),
    FOREIGN KEY (club_id) REFERENCES clubs(club_id)
);

-- Spaces
CREATE TABLE spaces (
    space_id INT AUTO_INCREMENT NOT NULL,
    space_name VARCHAR(255),
    space_room_number VARCHAR(255),
    space_capacity INT,
    PRIMARY KEY (space_id)
);

-- Space Reservations
CREATE TABLE space_reservations (
    reservation_id INT AUTO_INCREMENT NOT NULL,
    patron_id INT NOT NULL,
    space_id INT NOT NULL,
    start_reservation DATETIME,
    end_reservation DATETIME,
    reservation_notes TEXT,
    PRIMARY KEY (reservation_id),
    FOREIGN KEY (patron_id) REFERENCES patrons(patron_id),
    FOREIGN KEY (space_id) REFERENCES spaces(space_id)
);

-- Selection
CREATE TABLE selection (
    material_id INT AUTO_INCREMENT NOT NULL,
    material_title VARCHAR(255),
    material_date_received DATE,
    material_date_created DATE,
    material_is_pending BOOLEAN,
    material_price DECIMAL(10, 2),
    PRIMARY KEY (material_id)
);

-- Print Materials
CREATE TABLE print_materials (
    material_id INT NOT NULL,
    print_type_id INT,
    page_count INT,
    PRIMARY KEY (material_id),
    FOREIGN KEY (material_id) REFERENCES selection(material_id),
    FOREIGN KEY (print_type_id) REFERENCES print_types(print_type_id)
);

-- Multimedia
CREATE TABLE multimedia (
    material_id INT NOT NULL,
    multimedia_type_id INT,
    duration INT,
    PRIMARY KEY (material_id),
    FOREIGN KEY (material_id) REFERENCES selection(material_id),
    FOREIGN KEY (multimedia_type_id) REFERENCES multimedia_types(multimedia_type_id)
);

-- Narratives
CREATE TABLE narratives (
    narrative_id INT AUTO_INCREMENT NOT NULL,
    narrative_name VARCHAR(255),
    narrative_description TEXT,
    PRIMARY KEY (narrative_id)
);

-- Adaptations
CREATE TABLE adaptations (
    narrative_id INT NOT NULL,
    material_id INT NOT NULL,
    material_is_source BOOLEAN,
    PRIMARY KEY (narrative_id, material_id),
    FOREIGN KEY (narrative_id) REFERENCES narratives(narrative_id),
    FOREIGN KEY (material_id) REFERENCES selection(material_id)
);

-- Patrons
CREATE TABLE patrons (
    patron_id INT AUTO_INCREMENT NOT NULL,
    patron_first_name VARCHAR(255),
    patron_last_name VARCHAR(255),
    patron_email VARCHAR(255),
    patron_phone VARCHAR(20),
    PRIMARY KEY (patron_id)
);

-- Patron Selection Interactions
CREATE TABLE patron_selection_interactions (
    interaction_id INT AUTO_INCREMENT NOT NULL,
    patron_id INT NOT NULL,
    material_id INT NOT NULL,
    PRIMARY KEY (interaction_id),
    FOREIGN KEY (patron_id) REFERENCES patrons(patron_id),
    FOREIGN KEY (material_id) REFERENCES selection(material_id)
);

-- Loans
CREATE TABLE loans (
    interaction_id INT NOT NULL,
    loan_start_date DATE,
    loan_return_date DATE,
    loan_renewal_tally INT,
    PRIMARY KEY (interaction_id),
    FOREIGN KEY (interaction_id) REFERENCES patron_selection_interactions(interaction_id)
);

-- Holds
CREATE TABLE holds (
    interaction_id INT NOT NULL,
    hold_date_requested DATE,
    PRIMARY KEY (interaction_id),
    FOREIGN KEY (interaction_id) REFERENCES patron_selection_interactions(interaction_id)
);

-- Clubs
CREATE TABLE clubs (
    club_id INT AUTO_INCREMENT NOT NULL,
    club_name VARCHAR(255),
    club_description TEXT,
    PRIMARY KEY (club_id)
);
