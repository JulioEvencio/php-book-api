-- SOURCE /path/php-book-api/database/database.sql

DROP DATABASE IF EXISTS db_api_book;

CREATE DATABASE IF NOT EXISTS db_api_book;

USE db_api_book;

CREATE TABLE IF NOT EXISTS tb_book (
    id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    publisher VARCHAR(255) NOT NULL,
    year_published DATE NOT NULL
)ENGINE=InnoDB AUTO_INCREMENT=1;