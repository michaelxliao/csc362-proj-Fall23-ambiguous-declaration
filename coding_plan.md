# Coding Plan

## Files

### SQL Files
Files we will need(Names are in the works):
- SetupTherpstonDB.sql(X)
- Selection.sql
- ActiveSelection.sql (VIEW)
- PrintMaterials.sql
- PrintTypes.sql
- Multimedia.sql
- MultiMediaTypes.sql
- Narratives.sql
- ActiveNarratives.sql (VIEW)
- Adaptations.sql
- SelectionLanguages.sql
- Languages.sql
- SelectionCreators.sql
- Creators.sql
- CreatorRoles.sql
- SelectionGenres.sql
- Genres.sql
- Patrons.sql
- Patron-SelectionInteractions.sql
- ActivePatron-SelectionInteractions.sql (VIEW)
- Loans.sql
- CurrentLoans.sql (VIEW)
- Holds.sql
- CurrentHolds.sql (VIEW)
- Clubs.sql
- ActiveClubs.sql (VIEW)
- ClubMembers.sql
- Spaces.sql
- ActiveSpaces.sql (VIEW)
- SpaceReservations.sql
- CurrentReservations.sql (VIEW) // Need to consider what "range" of currency this encompasses. The current week? Just today? Only reservations that are ongoing?
- ClubReservations.sql

### PHP Files and related SQL files
- Patron_Interactions.php(X)
- Club_Info.php(X)
- Current_Holds.php(X)



## Task Categories (from Moodle Assignment)
- SQL scripts, including:
    - Table and view definitions. (One .sql file for each table and view.)
    - Queries invoked by PHP pages as prepared statements (One .sql file for INSERT, UPDATE, and DELETE), for each table. In some cases, you may want to consolidate the operations on closely-related tables into a single file implementing a transaction or stored procedure, which ensures data integrity across the tables. Use your best judgement in these cases, and don't hesitate to ask if you're unsure.
    - Any management scripts run manually, rather then invoked by PHP. If your organization has operations which are performed infrequently, it is acceptable to have these be run from the MariaDB prompt.
    - A setup script which allows your database to be established easily. This is valuable for your client, who benefits from an easy setup process, but it also benefits you in testing your database, allowing you to build and rebuild quickly. This script should:
        - set up the "webuser" account used by your PHP pages, and give it appropriate privileges,
        - SOURCE the table and definition scripts to create the table structure.
- PHP pages, including:
    - pages showing the reports requested by your client
    - pages which allow convenient data management, including:
        - insertion of new records,
        - modification of existing records, if permitted
        - deletion of existing records, if permitted.
- A final design document, explaining the table and field structure. For more details, see Implementation 6 - Documentation and Delivery.
- A slide deck and scripted (not in the code sense) demo of your final product which you will present to your client.