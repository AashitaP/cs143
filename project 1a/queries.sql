-- names of all the actors in the movie 'Die Another Day'

SELECT CONCAT(Actor.first,' ', Actor.last)
FROM MovieActor 
INNER JOIN Actor ON Actor.id = MovieActor.aid
INNER JOIN Movie ON Movie.id=MovieActor.mid AND Movie.title='Die Another Day';

-- count of all the actors who acted in multiple movies

SELECT COUNT(DISTINCT a1.aid)
FROM MovieActor a1
INNER JOIN MovieActor a2 ON a1.aid = a2.aid WHERE a1.mid <> a2.mid;

-- title of movies that sell more than 1,000,000 tickets

SELECT title 
FROM Movie
INNER JOIN Sales ON Sales.mid = Movie.id WHERE Sales.ticketsSold > 1000000;

-- movie title/s with highest total income

SELECT title
FROM Movie
INNER JOIN 
    Sales ON Sales.mid = Movie.id AND Sales.totalIncome = (SELECT MAX(totalIncome) FROM Sales);

-- movie title/s with highest rotten tomatoes ratings

SELECT title
FROM Movie
INNER JOIN 
    MovieRating ON MovieRating.mid = Movie.id AND MovieRating.rot = (SELECT MAX(rot) FROM MovieRating);

