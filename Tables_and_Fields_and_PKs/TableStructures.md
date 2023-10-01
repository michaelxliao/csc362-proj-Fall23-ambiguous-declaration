# Table Structures

## Selection
- Material ID **(PK)**
- Material Title 
- Material Date Received
- Material Date Created

## Print Materials

## Multimedia

## Narratives

## Adaptations

## Patrons
- Patron ID **(PK)**
- Patron First Name
- Patron Last Name
- Patron Email
- Patron Phone 

## Patron Selection Interactions
- Interaction ID **(PK)**
- Patron ID **(FK)**
- Material ID **(FK)**
- 

## Loans
- Interaction ID **(PK/FK)**
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

This is the start of the fields and Primary Keys document. We can merge this with the other one if we think we should. 


Media:
Media Name
Media ID
Print/Digital Status
Publisher
Fiction
Language
Periodical

Media_Authors:
Media ID
Author ID

Media_Genre:
Media ID
Author ID

Media_Demographic:
Media ID
Demographic

Patron_Media_Interactions:
Media ID
Patron ID
Check_Out Date
Check_In Date
Return Date


Patron:
Patron ID
Patron Name
Patron Email
Patron Phone

Clubs:
Club ID
Club Name

Club_Members:
Club ID
Patron ID


Loans:
Patron ID
Media ID
Loan Beginning Date
Loan Ending Date
Loan Return Date

Holds:
Hold ID
Held Book
Held Patron
Hold Beginning Date

Genre:
Genre ID
Genre Name

Demographic:
Demographic


Author:
Author ID
Author Name

# Notes
Media types are all listed in email as well as periodicals (magazines, newspapers)
no ebooks