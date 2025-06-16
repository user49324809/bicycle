DROP DATABASE IF EXISTS bike_db;
CREATE DATABASE bike_db;
USE bike_db;

CREATE TABLE bike_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    image VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    link VARCHAR(255) NOT NULL
);

