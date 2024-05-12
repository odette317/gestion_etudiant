-- Création de la base de données
CREATE DATABASE IF NOT EXISTS gestion_etudiant;

-- Sélection de la base de données
USE gestion_etudiant;

-- Création de la table des étudiants
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    adresse VARCHAR(255),
    tel VARCHAR(20),
    dateNaissance DATE,
    photo VARCHAR(255)
);
