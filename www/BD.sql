CREATE DATABASE IF NOT EXISTS `photos`  CHARSET = UTF8 COLLATE = utf8_general_ci ;

USE `photos` ;

CREATE TABLE IF NOT EXISTS `category` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `description` VARCHAR(45) NULL,
  `active` BIT NULL,
  PRIMARY KEY (`id`)
)CHARACTER SET utf8 COLLATE utf8_general_ci  ENGINE = innodb;

CREATE TABLE IF NOT EXISTS `images` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_category` INT(10),
  `link` VARCHAR(255) NOT NULL UNIQUE,
  `active` BIT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_Images_Category` FOREIGN KEY (`id_category`) REFERENCES `category`(`id`)
)CHARACTER SET utf8 COLLATE utf8_general_ci  ENGINE = innodb;



