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

CREATE OR REPLACE VIEW current_loans AS
SELECT *
  FROM loans
       LEFT OUTER JOIN patron_selection_interactions USING(interaction_id)
 WHERE loan_return_date IS NOT NULL;

CREATE OR REPLACE VIEW pretty_active_selection_librarians AS -- needs reformatting lol
SELECT material_id AS 'ID',
       material_title AS "Title",
       (CASE WHEN (NOT EXISTS (SELECT 1 FROM current_loans WHERE current_loans.material_id = active_selection.material_id))
        THEN 'On Shelf'
        ELSE 'Checked Out'
        END) AS 'Available for Checkout?', -- should be filterable
       material_date_received AS "Date Selected into Library",
       material_date_created AS "Date Created",
       (CASE WHEN material_is_pending
       THEN 'Not Processed Yet'
       ELSE 'Processed'
       END) AS "Pending?", -- should be filterable
       material_price AS "Cost", -- prolly leave to drill-down
       
  FROM active_selection -- change this if want is_active field
       LEFT OUTER JOIN print_materials ON pretty_active_selection_librarians.`ID` = print_materials.material_id
       LEFT OUTER JOIN multimedia ON pretty_active_selection_librarians.`ID` = multimedia.material_id
       LEFT OUTER JOIN selection_creators ON pretty_active_selection_librarians.`ID` = selection_creators.material_id
       LEFT OUTER JOIN creators USING (creator_id)
       LEFT OUTER JOIN creator_roles USING (creator_role);

--  SELECT * FROM pretty_patron_details_librarian;
/*
 SELECT COUNT(material_id) FROM loans
    INNER JOIN patron_selection_interactions USING (interaction_id)
     WHERE patron_id = 5
     GROUP BY patron_id;

SELECT COUNT(material_id), patron_id FROM loans
    INNER JOIN patron_selection_interactions USING (interaction_id)
     GROUP BY patron_id;
     */