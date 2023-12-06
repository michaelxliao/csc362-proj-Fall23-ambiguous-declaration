-- used to help with EnterSampleData.sql

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
