-- violates primary key constraint - cannot have null or duplicate primary key
-- ERROR 1048 (23000): Column 'id' cannot be null

INSERT INTO Movie VALUES (null, "hello world", 1997, "G", "cs productions");

-- violates check constraint - the year has to be between the year of oldest motion picture (1888) & current year (2019)
INSERT INTO Movie VALUES (4751, "hello world", 1001, "G", "cs productions");

-- violates check constraint - the rating has to be one of the possible MPAA ratings
INSERT INTO Movie VALUES (4752, "hello world", 2018, "M", "cs productions");

-- violates check constraint - each ticket earns at least 1 dollar so total income cannnot be less than tickets sold
INSERT INTO Sales VALUES (4751, 1000, 1);

-- violates primary key constraint - cannot have null or duplicate primary key, 2093 is already an existing id
-- ERROR 1062 (23000): Duplicate entry '2093' for key PRIMARY
INSERT INTO Director VALUES (2093, "mark", "smith", 19560903, null);

-- violates primary key constraint - cannot have null or duplicate primary key
-- ERROR 1048 (23000): Column 'id' cannot be null
INSERT INTO Actor VALUES (null, "smith", "mark", "F", 19560903, null);

-- violates foreign key constraint - the movie id has to be an existing id in the Movie table
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails 
INSERT INTO MovieGenre VALUES (4701, "Horror");

-- violates foreign key constraint - the movie id has to be an existing id in the Movie table
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails 
INSERT INTO MovieDirector VALUES (4702, 47992);

-- violates foreign key constraint - the director id has to be an existing id in the Director table
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails 
INSERT INTO MovieDirector VALUES (4700, 4700);

-- violates foreign key constraint - the movie id has to be an existing id in the Movie table
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails 
INSERT INTO MovieActor VALUES (4703, 1, "King");

-- violates foreign key constraint - the actor id has to be an existing id in the Actor table
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails 
INSERT INTO MovieActor VALUES (4700, 2156, "Himself");

-- violates: foreign key constraint - the movie id has to be an existing id in the Movie table
-- ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails 
INSERT INTO MovieRating VALUES (4704, 99, 99);


