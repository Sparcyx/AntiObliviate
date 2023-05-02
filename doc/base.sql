-- Utilisez la base de données créée
USE AntiObliviate;

-- Créez la table Utilisateur
CREATE TABLE Utilisateur (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  mot_de_passe VARCHAR(255) NOT NULL
);

-- Créez la table Anime
CREATE TABLE Anime (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(255) NOT NULL,
  nombre_depisodes INT,
  url_image VARCHAR(255),
  idAPI INT
);

-- Créez la table Catégorie
CREATE TABLE Categorie (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(255) NOT NULL UNIQUE
);

-- Créez la table Fiche_Anime
CREATE TABLE Fiche_Anime (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dernier_episode_vu INT,
  date_visionnage DATE,
  date_ajout DATE,
  categorie_id INT,
  FOREIGN KEY (categorie_id) REFERENCES Categorie(id)
);

-- Créez la table de relation entre Utilisateur et Anime
CREATE TABLE Utilisateur_Anime (
  utilisateur_id INT,
  anime_id INT,
  PRIMARY KEY (utilisateur_id, anime_id),
  FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur(id),
  FOREIGN KEY (anime_id) REFERENCES Anime(id)
);

-- Créez l'utilisateur MySQL
CREATE USER 'AntiObliviate'@'localhost' IDENTIFIED BY 'super';

-- Accordez tous les privilèges à l'utilisateur pour la base de données créée
GRANT ALL PRIVILEGES ON AntiObliviate.* TO 'AntiObliviate'@'localhost';

-- Rechargez les privilèges pour prendre en compte les changements
FLUSH PRIVILEGES;