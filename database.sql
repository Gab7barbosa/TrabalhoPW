-- Database creation script for manga_store
CREATE DATABASE IF NOT EXISTS `manga_store` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `manga_store`;

-- 1. Table for authenticated users
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(255) UNIQUE NOT NULL,
  `senha` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert default admin user: email = admin@admin.com, password = admin123
INSERT INTO `usuarios` (`email`, `senha`) VALUES 
('admin@admin.com', '$2y$10$ap569Grg30XJuP1TYcpeX.2S7OO4lRwqyFRdPFccvJarxxMZ8hj9m')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- 2. Table for authors
CREATE TABLE IF NOT EXISTS `autores` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(255) NOT NULL,
  `nacionalidade` VARCHAR(100) NOT NULL,
  `data_nascimento` DATE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 3. Table for mangas (books)
CREATE TABLE IF NOT EXISTS `mangas` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `titulo` VARCHAR(255) NOT NULL,
  `genero` VARCHAR(100) NOT NULL,
  `preco` DECIMAL(10, 2) NOT NULL,
  `autor_id` INT NOT NULL,
  CONSTRAINT `fk_mangas_autores` FOREIGN KEY (`autor_id`) REFERENCES `autores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 4. Table for sales (vendas)
CREATE TABLE IF NOT EXISTS `vendas` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `manga_id` INT NOT NULL,
  `quantidade` INT NOT NULL,
  `data_venda` DATE NOT NULL,
  CONSTRAINT `fk_vendas_mangas` FOREIGN KEY (`manga_id`) REFERENCES `mangas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
