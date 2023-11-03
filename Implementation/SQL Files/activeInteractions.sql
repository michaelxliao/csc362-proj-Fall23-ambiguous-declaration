CREATE OR REPLACE VIEW activeInteractions AS
SELECT *
FROM Patron_Selection_Interactions
WHERE Patron_Selection_Interactions.Interaction_isActive = TRUE;