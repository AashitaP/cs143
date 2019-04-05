CREATE TABLE Movie (
    id int,
    title varchar(100),
    year int, 
    rating varchar(10),
    company varchar(50),
    PRIMARY KEY(id),
    CHECK(year >= 1888 AND year <= 2019),
    CHECK(rating in ('G', 'PG', 'PG-13', 'R', 'NC-17'))
) ENGINE = INNODB;
-- every movie has a unique identification number
-- every movie has to have been released between 1888 (year of first movie) and 2019 (current year)
-- every movie should have a rating that is in the list of possible MPAA ratings

CREATE TABLE Actor (
    id int,
    last varchar(20),
    first varchar(20),
    sex varchar(6),
    dob DATE,
    dod DATE, 
    PRIMARY KEY(id)
) ENGINE = INNODB;
-- every actor has a unique identification (id) number

CREATE TABLE Sales (
    mid int,
    ticketsSold int,
    totalIncome int,
    CHECK(totalIncome >= ticketsSold)
) ENGINE=INNODB;
-- every sale cannot have a total income that is less than the number of tickets sold assuming each ticket is sold for a minimum of $1

CREATE TABLE Director (
    id int,
    last varchar(20),
    first varchar(20),
    dob DATE,
    dod DATE,
    PRIMARY KEY(id)
) ENGINE = INNODB;
-- every director has a unique id

CREATE TABLE MovieGenre (
    mid int,
    genre varchar(20),
    FOREIGN KEY (mid) references Movie(id)
) ENGINE = INNODB;
-- MovieGenre table cannot contain information on a movie that is not in the Movie table i.e. all entries in MovieGenre have an associated movie in the Movie table

CREATE TABLE MovieDirector (
    mid int,
    did int,
    FOREIGN KEY (mid) references Movie(id),
    FOREIGN KEY (did) references Director(id)
) ENGINE = INNODB;
-- MovieDirector table cannot contain information on a movie that is not in the Movie table i.e. all entries in MovieDirector have an associated movie in the Movie table
-- MovieDirector table cannot contain information on a director that is not in the Director table i.e. all entries in MovieDirector have an associated director in the Director table


CREATE TABLE MovieActor (
    mid int,
    aid int,
    role varchar(50),
    FOREIGN KEY (mid) references Movie(id),
    FOREIGN KEY (aid) references Actor(id)
) ENGINE = INNODB;
-- MovieActor table cannot contain information on a movie that is not in the Movie table i.e. all entries in MovieActor have an associated movie in the Movie table
-- MovieActor table cannot contain information on a actor that is not in the Actor table i.e. all entries in MovieActor have an associated actor in the Actor table


CREATE TABLE MovieRating (
    mid int,
    imdb int,
    rot int,
    FOREIGN KEY (mid) references Movie(id)
) ENGINE = INNODB;
-- MovieRating table cannot contain information on a movie that is not in the Movie table i.e. all entries in MovieRating have an associated movie in the Movie table


CREATE TABLE Review (
    name varchar(20),
    time timestamp,
    mid int,
    rating int,
    comment varchar(500)
) ENGINE = INNODB;

CREATE TABLE MaxPersonID (
    id int
) ENGINE = INNODB;

CREATE TABLE MaxMovieID (
    id int
) ENGINE = INNODB;


