###EXAMPLE FORMAT
Table Name:
Table Type(Linking, Validation, etc.):
Table Purpose:
(We can add or take away. This was just to get us starting and thinking about what we n
Feed)


- Authors
    - Validation
    - Stores information on an author
- Genres
    - Validation
    - Stores information about media genre
- Demographics
    - Stores groups of people that would be interested in stored media
- Languages
    - Stores languages used in media stored by library
- Media-Demographics
    - Linking
    - This is for highlighting which books are popular or written for certain demographics.

- Media-Authors
- Media-Genres

- Media
    - Linking(? i think this would be a data table)
    - This is for storing information about each book in the system such as type, ownership status, names, etc.
- Books
    - subset table of media
- Films
    - subset table of media

- Adaptations/Media-Media (Versions?Adaptations?)
    - Validation
    - Stores information about media adaptations
    - need to link different tables in subsets of media to each other? The # of tales we need grows quadratically as we add new media tables, i think media-media is general for that reason

- Clubs
    - Validation
    - Store information such as club names
- Club_Members
    - Linking(Patrons & Clubs)
    - Store information on the members within each club 
    
- Patrons
    - Validation
    - Store infromation such as patron name, address

- Patron-Book Interactions?
- Patron-Resource Interactions? for rooms etc

- Loans
    - Linking (Patrons & Media)
    - Store information on the amount of loans on a book, 
- Holds
    - Linking (Patrons & Media)
    - Store information on which patron is in que for which piece of media


# BIG THINGS TO STILL LOOK OVER
- interlibrary loan
- 'reviewing' books on a rolling basis (should this be a separate table?) - this is a part of application-oriented design, we just need to make sure we can track dates. That makes sense for deselection, what about new books to review?

# Qs
- what data do we need about a patron? library card number, contact info, demographics? Maybe we track age
- what data do we need to track about books? author, genre, audience, etc.
- what kinds of multimedia is stored? 
- what to do with data on deselected books
- are we allowing multiple ppl to put a hold on a book, etc.
- how do late fees? Are late fees something calculated based on the amount of time it has been gone(calculated field) or is it a flat fee?
- is there a limit on how many things a patron can reserve?
- new books to review: what info do we have about them? Patron, etc?
- ILL: what are we expected to store with this?