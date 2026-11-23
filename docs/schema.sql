-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema event_management
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema event_management
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `event_management` DEFAULT CHARACTER SET utf8 ;
USE `event_management` ;

-- -----------------------------------------------------
-- Table `event_management`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `event_management`.`users` ;

CREATE TABLE IF NOT EXISTS `event_management`.`users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` VARCHAR(20) NOT NULL,
  `status` VARCHAR(20) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `event_management`.`events`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `event_management`.`events` ;

CREATE TABLE IF NOT EXISTS `event_management`.`events` (
  `event_id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL,
  `location` VARCHAR(150) NULL,
  `description` TEXT NULL,
  `event_start` DATETIME NOT NULL,
  `event_end` DATETIME NOT NULL,
  `organizer_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`event_id`),
  INDEX `fk_events_users_idx` (`organizer_id` ASC) VISIBLE,
  CONSTRAINT `fk_events_users`
    FOREIGN KEY (`organizer_id`)
    REFERENCES `event_management`.`users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `event_management`.`event_registration`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `event_management`.`event_registration` ;

CREATE TABLE IF NOT EXISTS `event_management`.`event_registration` (
  `registration_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `event_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`registration_id`),
  INDEX `fk_signed_up_users1_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_signed_up_events1_idx` (`event_id` ASC) VISIBLE,
  UNIQUE INDEX `unique_user_event` (`user_id` ASC, `event_id` ASC) VISIBLE,
  CONSTRAINT `fk_signed_up_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `event_management`.`users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_signed_up_events1`
    FOREIGN KEY (`event_id`)
    REFERENCES `event_management`.`events` (`event_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `event_management`.`interests`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `event_management`.`interests` ;

CREATE TABLE IF NOT EXISTS `event_management`.`interests` (
  `interest_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `event_id` INT NOT NULL,
  `interested_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`interest_id`),
  INDEX `fk_interets_users1_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_interets_events1_idx` (`event_id` ASC) VISIBLE,
  UNIQUE INDEX `unique_user_interest` (`user_id` ASC, `event_id` ASC) VISIBLE,
  CONSTRAINT `fk_interets_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `event_management`.`users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_interets_events1`
    FOREIGN KEY (`event_id`)
    REFERENCES `event_management`.`events` (`event_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
