# Table Structures

## Selection
- Material ID **(PK)**
- Material Title 
- Material Date Received
- Material Date Created
- Material isPending

## Print Materials
- Material ID **(PK/FK)**
- Print Type
- Page Count

## Multimedia
- Material ID **(PK/FK)**
- Multimedia Type
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
- Loan End Date
- Loan Return Date
- Loan Renewal Tally 

## Holds
- Interaction ID **(PK/FK)**
- Hold Date Requested

## Clubs
- Club ID **(PK)**
- Club Name
- Club Description
