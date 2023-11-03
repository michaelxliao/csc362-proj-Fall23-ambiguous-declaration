CREATE OR REPLACE holds(
    PRIMARY KEY(Interaction_ID),
    Interaction_ID      INT,
    hold_date_requested DATE,
    hold_isActive       BOOLEAN DEFUALT TRUE
);