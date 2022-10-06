-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema controlesaidas
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema controlesaidas
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `controlesaidas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `controlesaidas` ;

-- -----------------------------------------------------
-- Table `controlesaidas`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `controlesaidas`.`usuarios` (
  `usu_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `usu_nome` VARCHAR(256) NOT NULL,
  `usu_email` VARCHAR(256) NOT NULL,
  `usu_senha` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`usu_id`),
  UNIQUE INDEX `usu_id_UNIQUE` (`usu_id` ASC) VISIBLE,
  UNIQUE INDEX `usu_email_UNIQUE` (`usu_email` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 13
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `controlesaidas`.`chamados`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `controlesaidas`.`chamados` (
  `cha_id` INT NOT NULL AUTO_INCREMENT,
  `usu_id` INT UNSIGNED NOT NULL,
  `cha_data` DATE NOT NULL,
  `cha_produto` VARCHAR(45) NOT NULL,
  `cha_observacao` TEXT NULL DEFAULT NULL,
  `cha_status` TINYINT NOT NULL,
  `cha_departamento` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`cha_id`),
  UNIQUE INDEX `cha_id_UNIQUE` (`cha_id` ASC) VISIBLE,
  INDEX `fk_chamados_usuarios1_idx` (`usu_id` ASC) VISIBLE,
  CONSTRAINT `fk_chamados_usuarios1`
    FOREIGN KEY (`usu_id`)
    REFERENCES `controlesaidas`.`usuarios` (`usu_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `controlesaidas`.`departamentos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `controlesaidas`.`departamentos` (
  `dep_id` INT NOT NULL AUTO_INCREMENT,
  `usu_id` INT UNSIGNED NOT NULL,
  `dep_nome` VARCHAR(128) NOT NULL,
  `dep_responsavel` VARCHAR(256) NOT NULL,
  `dep_telefone` VARCHAR(15) NOT NULL,
  `dep_email` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`dep_id`),
  UNIQUE INDEX `dep_id_UNIQUE` (`dep_id` ASC) VISIBLE,
  INDEX `fk_DEPARTAMENTOS_USUARIOS_idx` (`usu_id` ASC) VISIBLE,
  CONSTRAINT `fk_DEPARTAMENTOS_USUARIOS`
    FOREIGN KEY (`usu_id`)
    REFERENCES `controlesaidas`.`usuarios` (`usu_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 45
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `controlesaidas`.`saidas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `controlesaidas`.`saidas` (
  `sai_id` INT NOT NULL AUTO_INCREMENT,
  `usu_id` INT UNSIGNED NOT NULL,
  `sai_data` DATE NOT NULL,
  `sai_departamento` VARCHAR(256) NOT NULL,
  `sai_produto` VARCHAR(256) NOT NULL,
  `sai_observacao` TEXT NULL DEFAULT NULL,
  PRIMARY KEY (`sai_id`),
  UNIQUE INDEX `sai_id_UNIQUE` (`sai_id` ASC) VISIBLE,
  INDEX `fk_SAIDAS_USUARIOS1_idx` (`usu_id` ASC) VISIBLE,
  CONSTRAINT `fk_SAIDAS_USUARIOS1`
    FOREIGN KEY (`usu_id`)
    REFERENCES `controlesaidas`.`usuarios` (`usu_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 34
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
