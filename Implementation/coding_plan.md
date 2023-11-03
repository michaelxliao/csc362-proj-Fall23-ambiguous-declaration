# Coding Plan

## Files

Paste `☑` over the `☐` boxes when done.

#### Database Definitions


| Done? | **Filename**                           | **Assigned to** | Notes                                        |
| ------- | ---------------------------------------- | ----------------- | ---------------------------------------------- |
| ☐    | SetupTherpstonDB.sql                   | Michael         | webuser, SOURCE other sql files              |
| ☑    | Selection.sql                          | Michael         |                                              |
| ☑    | ActiveSelection.sql                    | Michael         | VIEW, for DENY deletion                      |
| ☑    | PrintMaterials.sql                     | Michael         |                                              |
| ☐    | Multimedia.sql                         | Michael         |                                              |
| ☐    | PrintTypes.sql                         | Michael         |                                              |
| ☐    | MultiMediaTypes.sql                    | Michael         |                                              |
| ☐    | Narratives.sql                         | Michael         |                                              |
| ☐    | ActiveNarratives.sql                   | Michael         | VIEW, for DENY deletion                      |
| ☐    | Adaptations.sql                        | Michael         |                                              |
| ☐    | SelectionLanguages.sql                 | Pierce          |                                              |
| ☐    | Languages.sql                          | Pierce          |                                              |
| ☐    | SelectionCreators.sql                  | Pierce          |                                              |
| ☐    | Creators.sql                           | Pierce          |                                              |
| ☐    | CreatorRoles.sql                       | Pierce          |                                              |
| ☐    | SelectionGenres.sql                    | Pierce          |                                              |
| ☐    | Genres.sql                             | Pierce          |                                              |
| ☐    | Patrons.sql                            | Rashawn         |                                              |
| ☐    | Patron-SelectionInteractions.sql       | Rashawn         |                                              |
| ☐    | ActivePatron-SelectionInteractions.sql | Rashawn         | VIEW, for DENY deletion                      |
| ☐    | Loans.sql                              | Rashawn         |                                              |
| ☐    | CurrentLoans.sql                       | Rashawn         | VIEW                                         |
| ☐    | Holds.sql                              | Rashawn         |                                              |
| ☐    | CurrentHolds.sql                       | Rashawn         | VIEW                                         |
| ☐    | Clubs.sql                              | Rashawn         |                                              |
| ☐    | ActiveClubs.sql                        | Rashawn         | VIEW                                         |
| ☐    | ClubMembers.sql                        | Rashawn         |                                              |
| ☐    | Spaces.sql                             | Pierce          |                                              |
| ☑    | ActiveSpaces.sql                       | Pierce          | VIEW                                         |
| ☑    | SpaceReservations.sql                  | Pierce          |                                              |
| ☑    | CurrentReservations.sql                | Pierce          | VIEW, range? the current week/today/ongoing? |
| ☑    | ClubReservations.sql                   | Pierce          |                                              |

### Client-Requested Reports


| Done? | **Filename**       | **Assigned to** | Notes                                                          |
| ------- | -------------------- | ----------------- | ---------------------------------------------------------------- |
| ☐    | Patron_Profile.php |                 | All checked out items, hold requests, fines, etc. for 1 person |
| ☐    | Club_Profile.php   | Rashawn         | All info about a club                                          |
| ☐    | Current_Holds.php  |                 | should also show the queue of users waiting for it             |

### Data Management

Note that each `ManageX.sql` script holds the appropriate INSERT/DELETE/UPDATE queries as needed per page.


| Done? | **Filename**               | **Assigned to** | Notes                                          |
| ------- | ---------------------------- | ----------------- | ------------------------------------------------ |
| ☐    | UpdateValidationTables.sql |                 | infrequently run; left as script               |
| ☐    | ManageSpaces.sql           |                 | infrequently updated; left as script           |
| ☐    | ManageSelection.php        | Pierce          | can modify selection/deselect things from page |
| ☐    | ManageSelection.sql        | Pierce          | will likely also interface with Adaptations    |
| ☐    | ManageClubs.php            | Rashawn         |                                                |
| ☐    | ManageClubs.sql            | Rashawn         |                                                |
| ☐    | ManagePatrons.php          | Rashawn         |                                                |
| ☐    | ManagePatrons.sql          | Rashawn         |                                                |
| ☐    | ManageInteractions.php     |                 |                                                |
| ☐    | ManageInteractions.sql     |                 | will have to interface with subset tables      |
| ☐    | ManageReservations.php     | Pierce          |                                                |
| ☐    | ManageReservations.sql     | Pierce          |                                                |

### Other Useful Reports


| Done? | **Filename**            | **Assigned to** | Notes                                                 |
| ------- | ------------------------- | ----------------- | ------------------------------------------------------- |
| ☐    | Index.php               |                 | Links to all other pages                              |
| ☐    | Catalog.php             |                 | shows all materials in selection, probably can filter |
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
