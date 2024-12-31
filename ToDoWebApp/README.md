# ToDO Web App
<!-- voici les informations à avoir dans qa base de donnés -->
CREATE DATABASE todo;
USE todo;
CREATE TABLE reg (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user VARCHAR(255) NOT NULL,
    pass VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE dd (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user VARCHAR(255),
    task TEXT,
    st TIME,
    tme TIME
);
CREATE TABLE task (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user VARCHAR(255) NOT NULL,
    task TEXT NOT NULL,
    st TIME NOT NULL, -- Heure de début
    tme TIME NOT NULL, -- Heure de fin
    pre INT NOT NULL -- Priorité
);
