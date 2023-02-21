-- Création de la base de données
CREATE DATABASE chatpot;

-- Création des tables
CREATE TABLE chatpot.chat (
  id INT NOT NULL AUTO_INCREMENT, 
  date_envoi DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
  auteur VARCHAR(30) NOT NULL, 
  contenu VARCHAR(255) NOT NULL, 
  PRIMARY KEY (id)
) ENGINE = InnoDB;

