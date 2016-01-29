<?php

// If you are editing tis file - leave the first two if statements
// alone.

if ( file_exists("pdo-local.php") ) {
    require_once("pdo-local.php");
} else if ( file_exists("../../../db.php") ) {
    require_once("../../../db.php");
} else {
    // Change this line
    $pdo = new PDO('mysql:host=localhost;port=8889;dbname=reading;charset=utf8', 'shaochi', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

/*
CREATE DATABASE reading DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;

GRANT ALL ON reading.* TO 'shaochi'@'localhost' IDENTIFIED BY '';
GRANT ALL ON reading.* TO 'shaochi'@'127.0.0.1' IDENTIFIED BY '';

CREATE TABLE Users (
   user_id INTEGER NOT NULL KEY AUTO_INCREMENT,
   name VARCHAR(128),
   email VARCHAR(128),
   password VARCHAR(128),

   INDEX(email)
) ENGINE=InnoDB CHARSET=utf8;

ALTER TABLE Users ADD INDEX(password);

CREATE TABLE Review (
  review_id INTEGER NOT NULL KEY AUTO_INCREMENT,
  user_id INTEGER NOT NULL,
  book_id INTEGER NOT NULL,
  rate_id INTEGER NOT NULL,
  extraction TEXT,
  reflection TEXT,
  feedback TEXT,

  CONSTRAINT review_ibfk_1
        FOREIGN KEY (user_id)
        REFERENCES Users (user_id)
        ON DELETE CASCADE ON UPDATE CASCADE,

  CONSTRAINT review_ibfk_2
        FOREIGN KEY (book_id)
        REFERENCES Book (book_id)
        ON DELETE CASCADE ON UPDATE CASCADE,

  CONSTRAINT review_ibfk_3
        FOREIGN KEY (rate_id)
        REFERENCES Rate (rate_id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Book (
  book_id INTEGER NOT NULL KEY AUTO_INCREMENT,
  author_id INTEGER NOT NULL,
  title TEXT,
  year INTEGER,

  CONSTRAINT book_ibfk_1
        FOREIGN KEY (author_id)
        REFERENCES Author (author_id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Rate (
  rate_id INTEGER NOT NULL KEY AUTO_INCREMENT,
  rating VARCHAR(255),
  UNIQUE(rating)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO Rate (rating) VALUES ('5 - I love it!');
INSERT INTO Rate (rating) VALUES ('4 - I enjoy reading it.);
INSERT INTO Rate (rating) VALUES ('3 - It's okay.');
INSERT INTO Rate (rating) VALUES ('2 - I don't really enjoy reading it.');
INSERT INTO Rate (rating) VALUES ('1 - I don't like it.');

CREATE TABLE Author (
  author_id INTEGER NOT NULL KEY AUTO_INCREMENT,
  author VARCHAR(255),
  UNIQUE(author)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

*/
?>
