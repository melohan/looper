-- -----------------------------------------------------
-- Looper Test Database
-- This file is the script for creating the test database.
-- -----------------------------------------------------
-- MySQL Script generated by MySQL Workbench
-- Sun Oct 24 22:15:21 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema looper
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `looper` ;

-- -----------------------------------------------------
-- Schema looper
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `looper` DEFAULT CHARACTER SET utf8 ;
USE `looper` ;

-- -----------------------------------------------------
-- Table `looper`.`status`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `looper`.`status` ;

CREATE TABLE IF NOT EXISTS `looper`.`status` (
                                                 `id` INT NOT NULL AUTO_INCREMENT,
                                                 `name` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `looper`.`exercises`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `looper`.`exercises` ;

CREATE TABLE IF NOT EXISTS `looper`.`exercises` (
                                                    `id` INT NOT NULL AUTO_INCREMENT,
                                                    `title` VARCHAR(150) NULL,
    `status_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_exercises_status1_idx` (`status_id` ASC) VISIBLE,
    CONSTRAINT `fk_exercises_status1`
    FOREIGN KEY (`status_id`)
    REFERENCES `looper`.`status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `looper`.`types`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `looper`.`types` ;

CREATE TABLE IF NOT EXISTS `looper`.`types` (
                                                `id` INT NOT NULL AUTO_INCREMENT,
                                                `name` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `looper`.`questions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `looper`.`questions` ;

CREATE TABLE IF NOT EXISTS `looper`.`questions` (
                                                    `id` INT NOT NULL AUTO_INCREMENT,
                                                    `text` VARCHAR(255) NULL,
    `exercise_id` INT NOT NULL,
    `type_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_questions_exercises_idx` (`exercise_id` ASC) VISIBLE,
    INDEX `fk_questions_types1_idx` (`type_id` ASC) VISIBLE,
    CONSTRAINT `fk_questions_exercises`
    FOREIGN KEY (`exercise_id`)
    REFERENCES `looper`.`exercises` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_questions_types1`
    FOREIGN KEY (`type_id`)
    REFERENCES `looper`.`types` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `looper`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `looper`.`users` ;

CREATE TABLE IF NOT EXISTS `looper`.`users` (
                                                `id` INT NOT NULL AUTO_INCREMENT,
                                                `name` VARCHAR(100) NOT NULL DEFAULT 'user',
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `looper`.`answers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `looper`.`answers` ;

CREATE TABLE IF NOT EXISTS `looper`.`answers` (
                                                  `id` INT NOT NULL AUTO_INCREMENT,
                                                  `question_id` INT NOT NULL,
                                                  `user_id` INT NOT NULL,
                                                  `answer` VARCHAR(255) NULL,
    INDEX `fk_answers_questions1_idx` (`question_id` ASC) VISIBLE,
    INDEX `fk_answers_users1_idx` (`user_id` ASC) VISIBLE,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_answers_questions1`
    FOREIGN KEY (`question_id`)
    REFERENCES `looper`.`questions` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_answers_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `looper`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
    ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

--  Types insertion
-- --------------------------------------------------------------------------------
INSERT INTO looper.types (name) VALUES ("Single line text");
INSERT INTO looper.types (name) VALUES ("List of single lines");
INSERT INTO looper.types (name) VALUES ("Multi-line text");


-- Status insertion
-- --------------------------------------------------------------------------------
INSERT INTO looper.status (name) VALUES ("Building");
INSERT INTO looper.status (name) VALUES ("Answering");
INSERT INTO looper.status (name) VALUES ("Closed");


-- Exercise insertion
-- --------------------------------------------------------------------------------
INSERT INTO looper.exercises (title, status_id) VALUES ("Exercise 1", 1);
INSERT INTO looper.exercises (title, status_id) VALUES ("Exercise 2", 1);
INSERT INTO looper.exercises (title, status_id) VALUES ("Exercise 3", 1);


-- Questions insertion
-- --------------------------------------------------------------------------------
INSERT INTO looper.questions (text, exercise_id, type_id) VALUES ("Question 1",1,1);
INSERT INTO looper.questions (text, exercise_id, type_id) VALUES ("Question 2",1,1);
INSERT INTO looper.questions (text, exercise_id, type_id) VALUES ("Question 3",1,1);
INSERT INTO looper.questions (text, exercise_id, type_id) VALUES ("Question 4",1,1);
INSERT INTO looper.questions (text, exercise_id, type_id) VALUES ("Question 5" ,1,1);
INSERT INTO looper.questions (text, exercise_id, type_id) VALUES ("Question 6",3,1);
INSERT INTO looper.questions (text, exercise_id, type_id) VALUES ("Question 7",3,1);
INSERT INTO looper.questions (text, exercise_id, type_id) VALUES ("Question 8",3,1);


-- Users insertion
-- --------------------------------------------------------------------------------
INSERT INTO looper.users (name) VALUES ("User 1");
INSERT INTO looper.users (name) VALUES ("User 2");
INSERT INTO looper.users (name) VALUES ("User 3");
INSERT INTO looper.users (name) VALUES ("User 4");
INSERT INTO looper.users (name) VALUES ("User 5");

-- Answers insertion
-- --------------------------------------------------------------------------------
INSERT INTO looper.answers (question_id, user_id, answer) VALUES (1,1,"Answer 1");
INSERT INTO looper.answers (question_id, user_id, answer) VALUES (1,2,"Answer 2");
INSERT INTO looper.answers (question_id, user_id, answer) VALUES (4,3,"Answer 3");
INSERT INTO looper.answers (question_id, user_id, answer) VALUES (7,4,"Answer 4");
INSERT INTO looper.answers (question_id, user_id, answer) VALUES (7,2,"Answer 5");
INSERT INTO looper.answers (question_id, user_id, answer) VALUES (8,3,"Answer 6");
INSERT INTO looper.answers (question_id, user_id, answer) VALUES (3,4,"Answer 7");