
-- -----------------------------------------------------
-- Schema controlesaidas
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `controlesaidas` DEFAULT CHARACTER SET utf8mb4 ;
USE `controlesaidas` ;

-- -----------------------------------------------------
-- Table `controlesaidas`.`USUARIOS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `controlesaidas`.`USUARIOS` (
  `usu_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `usu_nome` VARCHAR(256) NOT NULL,
  `usu_email` VARCHAR(256) NOT NULL,
  `usu_senha` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`usu_id`),
  UNIQUE INDEX `usu_id_UNIQUE` (`usu_id` ASC) VISIBLE,
  UNIQUE INDEX `usu_email_UNIQUE` (`usu_email` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `controlesaidas`.`DEPARTAMENTOS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `controlesaidas`.`DEPARTAMENTOS` (
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
    REFERENCES `controlesaidas`.`USUARIOS` (`usu_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `controlesaidas`.`CHAMADOS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `controlesaidas`.`CHAMADOS` (
  `cha_id` INT NOT NULL AUTO_INCREMENT,
  `dep_id` INT NOT NULL,
  `cha_data` VARCHAR(10) NOT NULL,
  `cha_produto` VARCHAR(45) NOT NULL,
  `cha_observacao` TEXT(3000) NULL,
  `cha_status` TINYINT NOT NULL,
  PRIMARY KEY (`cha_id`),
  UNIQUE INDEX `cha_id_UNIQUE` (`cha_id` ASC) VISIBLE,
  INDEX `fk_CHAMADOS_DEPARTAMENTOS1_idx` (`dep_id` ASC) VISIBLE,
  CONSTRAINT `fk_CHAMADOS_DEPARTAMENTOS1`
    FOREIGN KEY (`dep_id`)
    REFERENCES `controlesaidas`.`DEPARTAMENTOS` (`dep_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `controlesaidas`.`SAIDAS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `controlesaidas`.`SAIDAS` (
  `sai_id` INT NOT NULL AUTO_INCREMENT,
  `usu_id` INT UNSIGNED NOT NULL,
  `sai_data` VARCHAR(10) NOT NULL,
  `sai_departamento` VARCHAR(256) NOT NULL,
  `sai_produto` VARCHAR(256) NOT NULL,
  `sai_observacao` TEXT(3000) NULL,
  PRIMARY KEY (`sai_id`),
  UNIQUE INDEX `sai_id_UNIQUE` (`sai_id` ASC) VISIBLE,
  INDEX `fk_SAIDAS_USUARIOS1_idx` (`usu_id` ASC) VISIBLE,
  CONSTRAINT `fk_SAIDAS_USUARIOS1`
    FOREIGN KEY (`usu_id`)
    REFERENCES `controlesaidas`.`USUARIOS` (`usu_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;