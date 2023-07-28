DROP DATABASE IF EXISTS taskforce;
CREATE DATABASE taskforce CHARACTER SET = utf8;
USE taskforce;

CREATE TABLE category 
(
id INT AUTO_INCREMENT PRIMARY KEY,
character_code INT UNIQUE,
name TEXT NOT NULL,
icon VARCHAR(255)
);

CREATE TABLE city 
(
id INT AUTO_INCREMENT PRIMARY KEY,
name TEXT,
latitude DECIMAL(18, 7),
longditude DECIMAL(18, 7) 
);

CREATE TABLE status
(
id INT AUTO_INCREMENT PRIMARY KEY,
status TEXT,
name TEXT
);

CREATE TABLE users 
(
id INT AUTO_INCREMENT PRIMARY KEY,
registration_dt DATETIME DEFAULT CURRENT_TIMESTAMP,
name TEXT NOT NULL,
password VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL UNIQUE,
picture VARCHAR(255),
birthday DATETIME,
phone_number INT,
telegram VARCHAR(255),
about TEXT,
city_id INT NOT NULL,
FOREIGN KEY (city_id) REFERENCES city(id)
);

CREATE TABLE task 
(
id INT AUTO_INCREMENT PRIMARY KEY,
publication_dt DATETIME DEFAULT CURRENT_TIMESTAMP,
title TEXT NOT NULL,
description TEXT NOT NULL,
budget INT,
files VARCHAR(255),
status_id INT,
execution_dt DATETIME,
category_id INT NOT NULL,
client_id INT NOT NULL,
performer_id INT,
city_id INT,
adress text,
FOREIGN KEY (category_id) REFERENCES category(id),
FOREIGN KEY (client_id) REFERENCES users(id),
FOREIGN KEY (performer_id) REFERENCES users(id),
FOREIGN KEY (city_id) REFERENCES city(id),
FOREIGN KEY (status_id) REFERENCES status(id)
);

CREATE TABLE rating 
(
id INT AUTO_INCREMENT PRIMARY KEY,
performer_id INT,
client_id INT,
rating INT,
task_id INT,
rating_dt DATETIME DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (performer_id) REFERENCES users(id),
FOREIGN KEY (client_id) REFERENCES users(id),
FOREIGN KEY (task_id) REFERENCES task(id)
);

CREATE TABLE reply
(
id INT AUTO_INCREMENT PRIMARY KEY,
task_id INT NOT NULL,
client_id INT NOT NULL,
performer_id INT NOT NULL,
publication_dt DATETIME DEFAULT CURRENT_TIMESTAMP,
comment TEXT NOT NULL,
budget INT NOT NULL,
FOREIGN KEY (task_id) REFERENCES task(id),
FOREIGN KEY (client_id) REFERENCES users(id),
FOREIGN KEY (performer_id) REFERENCES users(id)
);

SET GLOBAL max_allowed_packet=524288000;


