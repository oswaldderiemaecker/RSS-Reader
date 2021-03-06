DROP TABLE IF EXISTS feeds;
DROP TABLE IF EXISTS items;

CREATE TABLE feeds(
  id                INTEGER         NOT NULL PRIMARY KEY,
  title             VARCHAR(255)    NOT NULL,
  link              VARCHAR(255)    NOT NULL,
  description       VARCHAR(255)    NOT NULL,
  date              DATE            NOT NULL,
  type              INTEGER         NOT NULL
);

CREATE TABLE items(
  id                INTEGER         NOT NULL PRIMARY KEY,
  id_feed           INTEGER         NOT NULL,
  title             VARCHAR(255)    NOT NULL,
  link              VARCHAR(255)    NOT NULL,
  description       VARCHAR(255)    NOT NULL,
  date              DATE            NOT NULL
);

INSERT INTO feeds(title, link, description, date, type)
VALUES ('Korben', 'http://korben.info/feed', 'Flux du site Korben', '2015-01-01 22:05', 0);

INSERT INTO feeds(title, link, description, date, type)
VALUES ('ZD Net', 'http://www.zdnet.fr/feeds/rss/', 'Flux du site ZD Net', '2015-01-01 22:05', 0);

INSERT INTO feeds(title, link, description, date, type)
VALUES ('Developpez.com', 'http://www.developpez.com/index/atom/', 'Flux du site Developpez.com', '2015-01-01 22:05', 0);
