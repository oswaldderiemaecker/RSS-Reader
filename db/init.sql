DROP TABLE IF EXISTS feeds;
DROP TABLE IF EXISTS items;

CREATE TABLE feeds (
  id                INTEGER         NOT NULL PRIMARY KEY AUTOINCREMENT,
  title             VARCHAR(255)    NOT NULL,
  description       VARCHAR(255)    NOT NULL,
  provider          VARCHAR(255)    NOT NULL,
  type              INTEGER         NOT NULL
);

CREATE TABLE items (
  id                INTEGER         NOT NULL PRIMARY KEY AUTOINCREMENT,
  title             VARCHAR(255)    NOT NULL,
  link              VARCHAR(255)    NOT NULL,
  source            VARCHAR(255)    NOT NULL,
  publication_date  DATE            NOT NULL,
  content           VARCHAR(2000)   NOT NULL
);
