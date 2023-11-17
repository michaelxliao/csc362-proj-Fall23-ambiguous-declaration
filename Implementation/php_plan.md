## PHP Plan

Reminder: Check `manageX.sql` SQL files for syntax: implement DENY deletion rules.

### WHAT WE NEED FOR THE WEBSITE

Basic architecture: All basic data tables (prettified views) receive their own pages. In these pages, you can do basic data manipulation (add/**insert** new, (multi?)-**delete**, etc.) You can also "drill down" into a particular record in the table to see the *profile report(!!)*. From there, you can **update** the selected record and manage linked records across linking tables, which are not explicitly given their own pages (unless we want to do SQL but web).

- Way to look at all, at a glance:
  - [ ] Selection
  - [ ] Patrons
  - [ ] Spaces
  - [ ] Clubs

- Details on a Selection:
    - [ ] Current holds on it
    - [ ] Curr

- Details on Patron (Patron Profile):
    - [ ] checked-out materials
    - [ ] current spaces reserved
    - [ ] joined clubs
    - [ ] current holds on books

- Details on Club (Club Profile):
    - [X] Spaces reserved
    - [X] Club members and their role (leadership)

- Details on a Space
    - 
## General


| PHP File          | Assigned To | Details                        |
| ------------------- | ------------- | -------------------------------- |
| index.php         |             |                                |
| staff_index.php   |             | for librarians - HIGH PRIORITY |
| general_index.php |             | for patrons                    |

## Reports

Profile pages look up all data (including linked data) for a specific record.


| PHP File                | Assigned To | Details |
| ------------------------- | ------------- | --------- |
| profile_patron.php      |             |         |
| profile_club.php        |             |         |
| profile_adaptations.php |             |         |
|                         |             |         |
|                         |             |         |

## Data Management

Management pages have a filterable table that allows us to operate on the data displayed.


| PHP File             | Assigned To | Details                                     |
| ---------------------- | ------------- | --------------------------------------------- |
| manage_patrons.php   |             |                                             |
| manage_selection.php |             | ALSO the catalog page, but without DM perms |
| manage_              |             |                                             |
|                      |             |                                             |
|                      |             |                                             |
