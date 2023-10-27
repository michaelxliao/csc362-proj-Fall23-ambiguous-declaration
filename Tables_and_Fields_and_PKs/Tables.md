# Tables

## List Format
- Table Name
    - Table Type
    - Table Description

## Table List

### To do with materials stored by library & their connections
- Selection
    - Data
    - The materials (both current and soon-to-be) held by the library meant to be loaned out. This will reflect only the materials the library has currently or soon will have; past materials are not of importance. Storing this information is key to managing the collection of materials the library can lend out.

- Print Materials
    - Subset (of Selection)
    - The printed materials like traditional and comic books or magazines, journals, and other periodicals that are (both current and soon-to-be) held by the library meant to be loaned out. This will reflect only the materials the library has currently or soon will have; past materials are not of importance. Storing this information is key to managing the collection of materials the library can lend out.


- Print Types
    - Validation
    - Stores the types of print materials offered by the library, such as text, articles, and periodicals. Ensures consistent nomenclature of this field in relation to every print material that fulfills this requirement.

- Multimedia
    - Subset (of Selection)
    - The materials that are not printed or otherwise are nontraditional items the library has or will have for loaning; like films, TV show episodes, audiobooks, etc. This will reflect only the materials the library has currently or soon will have; past materials are not of importance. Storing this information is key to managing the collection of materials the library can lend out.


- Mutimedia Types
    - Validation
    - Stores the types of multimedia materials offered by the library, such as film and audiobook. Ensures consistent nomenclature of this field in relation to every print material that fulfills this requirement.

- Narratives
    - Validation
    - The core stories behind or depicted by the materials the library has stored. This is vital to maintaining connections of different versions of the same story, as identifying the underlying original narrative can help in that regard.

- Adaptations
    - Linking (Narratives & Selection)
    - The connections between items in the library and their narratives. This depicts the connections between print stories and their different multimedia versions, or indeed between print and other print versions, multimedia and other multimedia versions, important to the goals set out by the library.

- Selection_Languages
    - Linking (Selection and Languages)
    - The languages in which a selection can be offered. This is important to store to identify which language a selection is offered. 

- Languages
    - Data
    - The languages in which something in the library's database may be stored. This is important for quick reference on which languages are extensively offered in the library's selection.

- Selection_Genres
    - Linking (Selection and Genres)
    - The genres in which a selection is categorized. This is important to store so a patron can identify which genres a selection is offered, and potentially narrow their search on the selection.

- Genres
    - Data
    - The genres in which something in the library's database may be categorized. This is important for quick reference on which genres are recognized in the library's selection.


### To do with patrons of library & their interactions

- Patrons
    - Data
    - The individuals who have accounts with the library and can access its services. Information stored here is useful to the library for identifying who may check out what materials and for contacting them regarding those materials.

- Patron-Selection Interactions
    - Linking (Patrons & Selection)
    - The interactions between patrons of the library and the materials held by the library. This kind of information is important to store in so that there is an active and ongoing record of exchanges of materials with patrons, for maintenance of the services the library can provide.

- Loans
    - Subset (of Patron Interactions)
    - The specific checkings-out of materials the library holds to the patrons at the library. This kind of information is important to store in so that there is an active and ongoing record of exchanges of materials with patrons, for maintenance of the services the library can provide.
    
- Holds
    - Subset (of Patron Interactions)
    - The people waiting for materials that are already checked out. Storing this information allows the library to determine who is next in line for high-demand materials and enable a smooth transfer process between them.

- Clubs
    - Data
    - The groups of people that meet at the library to engage in various activities. This information allows the library to see what their patrons are actively engaged in and better support their needs.

- Club_Members
    - Linking (Patrons and Clubs)
    - The clubs that a particular patron is a part of. It is important to store to streamline communication between a patron and the clubs they may be a part of.

- Spaces
    - Data
    - The spaces that are physically present in the library. Storing this information differentiates the (past and current) physical spaces of the library that may be of use to administration or patrons.
    
- Space_Reservation
    - Linking (Spaces and Patrons)
    - The reservations in which patrons plan to use the spaces in the library. Storing this information allows for reservations of spaces in advance, and later track which areas were used for which purposes.

- Club_Reservation
    - Subset (of Space_Reservation)
    - The club that reserved a particular space. Storing this information allows for more transparent display of how a space might be used, and whether it is for work more directly affiliated with the library (i.e. a club) or more independent (in the case that the reservation does not have a record in this table).