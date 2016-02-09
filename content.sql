DROP TABLE IF EXISTS authors;
CREATE TABLE authors (
 id BIGINT NOT NULL PRIMARY KEY auto_increment,
 name VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS books;
CREATE TABLE books (
 id BIGINT NOT NULL PRIMARY KEY auto_increment,
 title VARCHAR(255) NOT NULL,
 author_id BIGINT NOT NULL,
 publisher VARCHAR(255) NOT NULL,
 year_release INT NOT NULL
);

INSERT INTO authors VALUES ( 0, 'Neal Stephenson' );
INSERT INTO authors VALUES ( 0, 'Karl May' );
INSERT INTO authors VALUES ( 0, 'J. K. Rowling' );
INSERT INTO books VALUES ( 0, 'Seveneves', 1, 'William Morrow', 2015 );
