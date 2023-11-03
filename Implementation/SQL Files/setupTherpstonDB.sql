CREATE OR REPLACE DATABASE therpston;

USE therpston;

/* Defining the webuser */
CREATE USER 'webuser'@'localhost' IDENTIFIED BY 'tidybattlefield'; -- RANDOMLY GENERATED 2 WORDS

GRANT INSERT ON *.* TO 'webuser'@'localhost'; -- C(reate)
GRANT SELECT ON *.* TO 'webuser'@'localhost'; -- R(ead)
GRANT UPDATE ON *.* TO 'webuser'@'localhost'; -- U(pdate)
GRANT DELETE ON *.* TO 'webuser'@'localhost'; -- D(dlete)

/* now calling the rest of the definitional files */
SOURCE selection.sql;
SOURCE activeSelection.sql;
SOURCE printMaterials.sql;
SOURCE multimedia.sql;
SOURCE printTypes.sql;
SOURCE multimediaTypes.sql;
SOURCE narratives.sql;
SOURCE activeNarratives.sql;
SOURCE adaptations.sql;
SOURCE selection_languages.sql;
SOURCE languages;