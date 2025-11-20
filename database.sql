-- Crear base de dades
CREATE DATABASE IF NOT EXISTS smix2
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE smix2;

-- Taula d'usuaris
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Taula de bitz
CREATE TABLE bitz (
    id INT AUTO_INCREMENT PRIMARY KEY,
    text VARCHAR(255) NOT NULL,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_bitz_user
        FOREIGN KEY (created_by) REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- Taula de vots
CREATE TABLE votes (
    user_id INT NOT NULL,
    bitz_id INT NOT NULL,
    value TINYINT NOT NULL, -- +1 = upvote, -1 = downvote
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, bitz_id),
    CONSTRAINT fk_votes_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_votes_bitz
        FOREIGN KEY (bitz_id) REFERENCES bitz(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

