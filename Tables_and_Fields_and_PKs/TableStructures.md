# Table Structures

## Selection
- Material ID **(PK)**
- Material Title 
- Material Date Received
- Material Date Created


### To do with patrons of library & their interactions

## Patrons
- Patron ID **(PK)**
- Patron Name
- Patron Email
- Patron Phone 

## Patron_Selection_Interactions
- Patron ID **(CPK)**
- Material ID **(CPK)**
- 

## Loans
- Patron ID
- Material ID
- Loan Start Date
- Loan End Date
- Loan Return Date

## Holds
- Patron ID
- Material ID
- Hold Start

## 
- Club ID
- Club Name


# Notes
Patrons: we need to store name, email, phone; email & phone are required
Media types are all listed in email as well as periodicals (magazines, newspapers)
no ebooks
for the media we store -- we need to keep track of author/producer/director etc