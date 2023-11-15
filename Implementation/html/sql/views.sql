-- For profile_patrons.sql, we want to show
-- all active patrons and their number of current loans.
CREATE OR REPLACE VIEW pretty_patron_details_librarian
AS (
SELECT 
    patron_id AS "ID", -- assuming this is the same as their library card's
    (CONCAT(patron_first_name, " ", patron_last_name)) AS "Name",
    COUNT(material_id) AS "Number of Loans", -- need only current loans?
    patron_email AS "Email",
    patron_phone AS "Phone Number"

    FROM patrons
        LEFT OUTER JOIN patron_selection_interactions USING (patron_id)
        LEFT OUTER JOIN loans USING (interaction_id)
    
    WHERE patron_is_active = TRUE
    GROUP BY (patron_id)
);

CREATE OR REPLACE VIEW active_selection_pretty_librarians AS -- needs reformatting lol
SELECT material_title AS "Title",
       material_date_received AS "Date Selected into Library",
       material_date_created AS "Date Created",
       material_is_pending AS "Pending?",
       material_price AS "Cost"
  FROM active_selection

CREATE OR REPLACE VIEW active_selection_pretty_patrons AS
SELECT material_title AS "Title",
       material_date_created AS "Date Created",
  FROM active_selection
 WHERE material_is_pending = FALSE;

 SELECT * FROM pretty_patron_details_librarian;
/*
 SELECT COUNT(material_id) FROM loans
    INNER JOIN patron_selection_interactions USING (interaction_id)
     WHERE patron_id = 5
     GROUP BY patron_id;

SELECT COUNT(material_id), patron_id FROM loans
    INNER JOIN patron_selection_interactions USING (interaction_id)
     GROUP BY patron_id;
     */