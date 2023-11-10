USE therpston;

INSERT INTO spaces(space_name, space_room_number, space_capacity)
VALUES
("The Round Table", 1, 150),
("The Square Table", 2, 40);

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