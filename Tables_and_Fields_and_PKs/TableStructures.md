# Table Structures

# TEMP: SPACE_RESERVATIONS LAST TABLE

## Multimedia Types
- Multimedia Type **(PK)**

## Print Types
- Print Type **(PK)**

## Selection Languages
- Material ID **(CPK/FK)**
- Language Name **(CPK/FK)**

## Languages
- Language Name **(PK)**

## Selection Creators
- Material ID **(CPK/FK)**
- Creator ID **(CPK/FK)**
- Creator Role **(CPK/FK)**

## Creators
- Creator ID **(PK)**
- Creator First Name
- Creator Last Name

## Creator Roles
- Creator Role **(PK)**

## Selection Genres
- Material ID **(CPK/FK)**
- Genre Name **(CPK/FK)**

## Genres
- Genre Name **(PK)**

## Club Members
- Club ID **(CPK/FK)**
- Patron ID **(CPK/FK)**
- Member Info
- Member isLeader

## Club Reservations
- Reservation ID **(PK/FK)**
- Club ID **(FK)**

## Spaces
- Space ID **(PK)**
- Space Name
- Space Room Number
- Space Capacity

## Space Reservations
? Reservation ID **(PK)**
? Patron ID **(FK)**
? Space ID **(FK)**
? Start Reservation
? End Reservation
? Reservation Notes

## Selection
- Material ID **(PK)**
- Material Title 
- Material Date Received
- Material Date Created
- Material isPending
- Material Price

## Print Materials
- Material ID **(PK/FK)**
- Print Type **(FK)**
- Page Count

## Multimedia
- Material ID **(PK/FK)**
- Multimedia Type **(FK)**
- Duration

## Narratives
- Narrative ID **(PK)**
- Narrative Name 
- Narrative Description

## Adaptations
- Narrative ID **(CPK/FK)**
- Material ID **(CPK/FK)**

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

## Loans
- Interaction ID **(PK/FK)**
- Loan Start Date
- Loan Return Date
- Loan Renewal Tally 

## Holds
- Interaction ID **(PK/FK)**
- Hold Date Requested

## Clubs
- Club ID **(PK)**
- Club Name
- Club Description
