# csc362-proj-Fall23-ambiguous-declaration

From a librarian of the fabricated Therpston County Public Library, we were asked to do a redesign of the catalog system. This repository is the full-stack implementation of that request, which builds an SQL website that interacts with a PHP database.

### Package Installation and Use

We have implemented the database using MariaDB version 10.5.21 and PHP version 7.4.33. We have implemented this through the LAMP stack, and have run thorough website testing through a virtual machine.

To use this website, please replace the '.ssh/html' directory of your machine with all contents of the "Implementation/html" directory, or create a symbolic link to the directory elsewhere. Then, change your working directory to Implementation/html/sql/ and 

### The Design of the Database

In particular, our database design is such that requests for further patron functionality and filtering materials in the library are all extendable. For instance, the types of interactions between a library material and a patron are currently shown through loan and subset tables, but could easily create another subset table if one wishes to allow for renting of films at a predetermined rate, for example. Adding further functionality for clubs, spaces, and other patron needs within the library's database and website are all attainable with no need to overhaul the pre-existing design of the database.

Further, we have implemented the design with particular care for storing "adaptations" of a material, such as the sequels, novelization of a film, and the like. We have made sure the design is robust to materials such as "Avengers: Endgame," as well as if the original source of an adaptation is unavailable at our library.



### The Client

We were given the following (fake) request from a Rita Booker, of Therpston County:



    *Salutations,

    Thank you for your interest in supporting the Therpston County Public Library! We are pleased to accept your bid for redesigning the catalog system. We are looking forward to upgrading our systems to enable deeper exploration of what the library has to offer.

    We are particularly interested in promoting the connections between print and multimedia. Not only audiobooks, film and TV adaptations of books and graphic novels and comics, but also novelizations of films. These connections are often hard to make, because the related items do not always share the same names, and some stories may go by more than one name across different mediums! We feel that this is a powerful way to revitalize the library and bring new members into our book and film clubs.

    In addition to this exciting new initiative, we also need to update our usual operating mechanisms related to loans and renewals, late fees, reservations, and our selection and deselection processes.

    Sincerely,

    Rita Booker Summit
    Chief Librarian, Therpston Country Public Library*


Since that initial contact, we have followed up with Rita Booker extensively to develop and implement this full-stack website to allow for saving and editing of information about our patrons, spaces, clubs, materials, and narratives. 