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
SOURCE selectionLanguages.sql;
SOURCE language.sql;
SOURCE selectionCreators.sql;
SOURCE creator.sql;
SOURCE creatorRoles.sql;
SOURCE selectionGenres.sql;
SOURCE genres.sql;
SOURCE patrons.sql;
SOURCE patronSelectionInteractions.sql;
SOURCE activePatronSelectionInteractions.sql;
SOURCE loans.sql;
SOURCE currentLoans.sql;
SOURCE holds.sql;
SOURCE currentHolds.sql;
SOURCE clubs.sql;
SOURCE activeClubs.sql;
SOURCE clubMembers.sql;
SOURCE spaces.sql;
SOURCE activeSpaces.sql;
SOURCE spaceReservations.sql;
SOURCE currentReservations.sql;
SOURCE clubReservations.sql;