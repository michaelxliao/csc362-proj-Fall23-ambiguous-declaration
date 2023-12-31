# Coding Plan

Stretch Goals:

- Sessions and Passwords
    - Errors displayed when
      invalid data submitted,
      via https://stackoverflow.com/questions/57011464/show-errors-on-form-without-using-get
- CSS
- Testing for SQL to ensure tables work properly
- Testing for PHP to ensure web handles as expected
  - e.g. preventing XSS and other cybersecurity risks
- Documentation

## Files

Paste `☑` over the `☐` boxes when done.

#### Database Definitions

##### REVIEW ALL FOR SYNTAX.

* Includes: cases, whitespace, foreign key constraints, OR REPLACEs, etc.


| Done? | **Filename**                           | **Assigned to** | Notes                                        |
| ------- | ---------------------------------------- | ----------------- | ---------------------------------------------- |
| ☐    | SetupTherpstonDB.sql                   | Michael         | still waiting on                             |
| ☑    | Selection.sql                          | Michael         |                                              |
| ☑    | ActiveSelection.sql                    | Michael         | VIEW, for DENY deletion                      |
| ☑    | PrintMaterials.sql                     | Michael         |                                              |
| ☑    | Multimedia.sql                         | Michael         |                                              |
| ☑    | PrintTypes.sql                         | Michael         |                                              |
| ☑    | MultiMediaTypes.sql                    | Michael         |                                              |
| ☑    | Narratives.sql                         | Michael         |                                              |
| ☑    | ActiveNarratives.sql                   | Michael         | VIEW, for DENY deletion                      |
| ☑    | Adaptations.sql                        | Michael         |                                              |
| ☑    | SelectionLanguages.sql                 | Pierce          |                                              |
| ☑    | Languages.sql                          | Pierce          |                                              |
| ☑    | SelectionCreators.sql                  | Pierce          |                                              |
| ☑    | Creators.sql                           | Pierce          |                                              |
| ☑    | CreatorRoles.sql                       | Pierce          |                                              |
| ☑    | SelectionGenres.sql                    | Pierce          |                                              |
| ☑    | Genres.sql                             | Pierce          |                                              |
| ☑    | Patrons.sql                            | Rashawn         |                                              |
| ☑    | Patron-SelectionInteractions.sql       | Rashawn         |                                              |
| ☑    | ActivePatron-SelectionInteractions.sql | Rashawn         | VIEW, for DENY deletion                      |
| ☑    | Loans.sql                              | Rashawn         |                                              |
| ☑    | CurrentLoans.sql                       | Rashawn         | VIEW                                         |
| ☑    | Holds.sql                              | Rashawn         |                                              |
| ☑    | CurrentHolds.sql                       | Rashawn         | VIEW                                         |
| ☑    | Clubs.sql                              | Rashawn         |                                              |
| ☑    | ActiveClubs.sql                        | Rashawn         | VIEW                                         |
| ☑    | ClubMembers.sql                        | Rashawn         |                                              |
| ☑    | Spaces.sql                             | Pierce          |                                              |
| ☑    | ActiveSpaces.sql                       | Pierce          | VIEW                                         |
| ☑    | SpaceReservations.sql                  | Pierce          |                                              |
| ☑    | CurrentReservations.sql                | Pierce          | VIEW, range? the current week/today/ongoing? |
| ☑    | ClubReservations.sql                   | Pierce          |                                              |

### Client-Requested Reports


| Done? | **Filename**       | **Assigned to** | Notes                                                                                                                                         |
| ------- | -------------------- | ----------------- | ----------------------------------------------------------------------------------------------------------------------------------------------- |
| ☐    | Patron_Profile.php |                 | All checked out items, hold requests, fines, etc. for 1 person                                                                                |
| ☐    | Club_Profile.php   | Rashawn         | All info about a club (members concatenated, ability to show more info about a member, who's the leader, what reservations they've made, etc) |
| ☐    | Current_Holds.php  |                 | should also show the queue of users waiting for it (a particular material)                                                                    |

### Data Management

Note that each `ManageX.sql` script holds the appropriate INSERT/DELETE/UPDATE queries as needed per page.


| Done? | **Filename**                                       | **Assigned to**      | Notes                                                                              |
| ------- | ---------------------------------------------------- | ---------------------- | ------------------------------------------------------------------------------------ |
| ☑    | UpdateValidationTables.sql                         | Michael + Pierce     | infrequently run; left as script                                                   |
| ☑    | ManageSpaces.sql                                   | ~~Michael~~ Pierce   | infrequently updated; left as script                                               |
| ☐    | ManageSelection.php                                | Pierce               | can modify selection/deselect things from page                                     |
| ☑    | ManageSelection.sql                                | ~~Pierce~~ Michael   | will likely also interface with Adaptations<br />SORRY PIERCE I DID IT BY ACCIDENT |
| ☐    | ManageClubs.php                                    | ~~Rashawn~~ Everyone |                                                                                    |
| ☐    | ManageClubs.sql                                    | Rashawn              |                                                                                    |
| ☐    | ManagePatrons.php                                  | Rashawn              |                                                                                    |
| ☐    | ManagePatrons.sql                                  | Rashawn              |                                                                                    |
| ☐    | ~~ManageInteractions.php~~<br />ManageLoanHold.php | Michael              |                                                                                    |
| ☑    | ManageInteractions.sql                             | Michael              | will have to interface with subset tables                                          |
| ☐    | ManageReservations.php                             | Pierce               |                                                                                    |
| ☑    | ManageReservations.sql                             | Pierce               |                                                                                    |

### Other Useful Reports


| Done? | **Filename**            | **Assigned to** | Notes                                                 |
| ------- | ------------------------- | ----------------- | ------------------------------------------------------- |
| ☐    | Index.php               | Pierce          | Links to all other pages                              |
| ☐    | Catalog.php             | Michael         | shows all materials in selection, probably can filter |
| ☐    | CurrentLoans.php        | Rashawn         | for librarians                                        |
| ☐    | CurrentReservations.php |                 | for librarians                                        |
| ☐    | CurrentHolds.php        |                 | for librarians                                        |
| ☐    | ClubDetails.php         |                 | for librarians (active clubs)                         |
| ☐    | PatronLookup.php        |                 | for librarians                                        |

## Final Deliverables


| Done? | **Deliverable** |
| ------- | ----------------- |
| ☐    | Design Document |
| ☐    | Slide Deck      |
| ☐    | Demo            |

## Task Categories (from Moodle Assignment)

- [ ] SQL scripts, including:
  - [ ] Table and view definitions. (One .sql file for each table and view.)
  - [ ] Queries invoked by PHP pages as prepared statements (One .sql file for INSERT, UPDATE, and DELETE), for each table. In some cases, you may want to consolidate the operations on closely-related tables into a single file implementing a transaction or stored procedure, which ensures data integrity across the tables. Use your best judgement in these cases, and don't hesitate to ask if you're unsure.
  - [ ] Any management scripts run manually, rather then invoked by PHP. If your organization has operations which are performed infrequently, it is acceptable to have these be run from the MariaDB prompt.
  - [ ] A setup script which allows your database to be established easily. This is valuable for your client, who benefits from an easy setup process, but it also benefits you in testing your database, allowing you to build and rebuild quickly. This script should:
    - [ ] set up the "webuser" account used by your PHP pages, and give it appropriate privileges,
    - [ ] SOURCE the table and definition scripts to create the table structure.
- [ ] PHP pages, including:
  - [ ] pages showing the reports requested by your client
  - [ ] pages which allow convenient data management, including:
    - insertion of new records,
    - modification of existing records, if permitted
    - deletion of existing records, if permitted.
- [ ] A final design document, explaining the table and field structure. For more details, see Implementation 6 - Documentation and Delivery.
- [ ] A slide deck and scripted (not in the code sense) demo of your final product which you will present to your client.
