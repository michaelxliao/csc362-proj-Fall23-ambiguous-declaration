CREATE OR REPLACE TABLE patron_selection_interactions(
    PRIMARY KEY(Interaction_ID),
    Interaction_ID       INT AUTO_INCREMENT,
    material_id          INT,
    Patron_ID            INT,
    Interaction_isActive BOOLEAN DEFUALT TRUE
);