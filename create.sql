create database dit;
use dit;
show tables;
CREATE TABLE Users
(
ID int NOT NULL AUTO_INCREMENT,
name varchar(25),
surname varchar(25),
email varchar(25),
password varchar(20),
username varchar(20),
PRIMARY KEY (ID)
);

CREATE TABLE Artist
(
ID int NOT NULL AUTO_INCREMENT,
name varchar(255) NOT NULL,
country varchar(255),
PRIMARY KEY (ID)
);

CREATE TABLE Album
(
ID int NOT NULL AUTO_INCREMENT,
album_name varchar(255) NOT NULL,
album_year YEAR(4),
artist int NOT NULL,
PRIMARY KEY (ID),
FOREIGN KEY (artist) REFERENCES Artist(id)
);

CREATE TABLE Song
(
ID int NOT NULL AUTO_INCREMENT,
song_name varchar(255) NOT NULL,
duration float(10,2),
artist int NOT NULL,
album int,
track_no int,
PRIMARY KEY (ID),
FOREIGN KEY (artist) REFERENCES Artist(id),
FOREIGN KEY (album) REFERENCES Album(id)
);

INSERT INTO Artist (name,country)
VALUES('The Beatles','UK');

INSERT INTO Album (album_name,album_year,artist)
VALUES('The White Album','1968',1);

INSERT INTO Song (song_name,duration,artist,album,track_no)
VALUES('Back in the U.S.S.R',2.43,1,1,1);

INSERT INTO Song (song_name,duration,artist,album,track_no)
VALUES('Glass Onion',3.14,1,1,2);

INSERT INTO Song (song_name,duration,artist,album,track_no)
VALUES('Blackbird',3.05,1,1,3);



