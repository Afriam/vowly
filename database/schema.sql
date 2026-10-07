CREATE DATABASE IF NOT EXISTS vowly CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE vowly;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE weddings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL UNIQUE,
  slug VARCHAR(40) NOT NULL UNIQUE,
  groom_name VARCHAR(100) NOT NULL,
  bride_name VARCHAR(100) NOT NULL,
  groom_father VARCHAR(120) DEFAULT '', groom_mother VARCHAR(120) DEFAULT '',
  bride_father VARCHAR(120) DEFAULT '', bride_mother VARCHAR(120) DEFAULT '',
  wedding_date DATE NULL,
  ceremony_venue VARCHAR(150) DEFAULT '', ceremony_address VARCHAR(255) DEFAULT '', ceremony_time VARCHAR(40) DEFAULT '',
  reception_venue VARCHAR(150) DEFAULT '', reception_address VARCHAR(255) DEFAULT '', reception_time VARCHAR(40) DEFAULT '',
  dress_code VARCHAR(150) DEFAULT '',
  story TEXT,
  theme VARCHAR(20) NOT NULL DEFAULT 'garden',
  font_heading VARCHAR(40) NOT NULL DEFAULT 'Playfair Display',
  font_body VARCHAR(40) NOT NULL DEFAULT 'Montserrat',
  accent CHAR(7) NULL,
  hero_media_id INT NULL,
  is_published TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE media (
  id INT AUTO_INCREMENT PRIMARY KEY,
  wedding_id INT NOT NULL,
  type ENUM('image','video') NOT NULL,
  path VARCHAR(255) NOT NULL,
  caption VARCHAR(255) DEFAULT '',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (wedding_id) REFERENCES weddings(id) ON DELETE CASCADE
);

CREATE TABLE entourage (
  id INT AUTO_INCREMENT PRIMARY KEY,
  wedding_id INT NOT NULL,
  role VARCHAR(40) NOT NULL,
  name VARCHAR(120) NOT NULL,
  FOREIGN KEY (wedding_id) REFERENCES weddings(id) ON DELETE CASCADE
);

CREATE TABLE rsvps (
  id INT AUTO_INCREMENT PRIMARY KEY,
  wedding_id INT NOT NULL,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) DEFAULT '',
  attending TINYINT(1) NOT NULL,
  guests TINYINT NOT NULL DEFAULT 1,
  message TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (wedding_id) REFERENCES weddings(id) ON DELETE CASCADE
);
