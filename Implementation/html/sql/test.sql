-- random sql shtuff

-- trying to grab # of active print material loans for a particular patron
SELECT COUNT(material_id) FROM
(
    SELECT *
    FROM loans
        LEFT OUTER JOIN patron_selection_interactions USING (interaction_id)
        LEFT OUTER JOIN print_materials USING (material_id)
        
    WHERE ((patron_id = 5) AND (loan_return_date IS NULL))
) AS print_loans
GROUP BY (patron_id);