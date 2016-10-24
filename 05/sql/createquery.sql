CREATE TABLE accordions (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `model` VARCHAR(30) NOT NULL,
    `price` DECIMAL(9,2) NOT NULL,
    `manufactured` DATE NULL,
    `type` ENUM('button', 'keyboard') NOT NULL DEFAULT 'button',
    `decibels` INT UNSIGNED NULL,
    `color` VARCHAR(30),
    `maker` INT NOT NULL,
    `descr` TEXT NULL DEFAULT NULL
) ENGINE = MyISAM;

CREATE TABLE users (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `loggedin` TINYINT(1) DEFAULT 0 NOT NULL,
    `lastlogin` DATETIME NULL,
    `ipaddr` VARCHAR(16) NULL
) ENGINE = MyISAM;

CREATE TABLE submissions (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `userid` INT UNSIGNED NOT NULL, 
    `submissiondate` DATE NOT NULL,
    `submissiontime` TIME NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `url` VARCHAR(2083) NOT NULL,
    `subtext` TEXT NULL DEFAULT NULL,
    CONSTRAINT fk_userid FOREIGN KEY (`userid`) REFERENCES users(`id`)
) ENGINE = MyISAM;

CREATE TABLE comments (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `subid` INT UNSIGNED NOT NULL,
    `userid` INT UNSIGNED NOT NULL,
    `commentdate` DATE NOT NULL,
    `commenttime` TIME NOT NULL,
    `edited` TINYINT(1) DEFAULT 0 NOT NULL,
    `comment` TEXT NULL DEFAULT NULL,
    CONSTRAINT fk_subid FOREIGN KEY (`subid`) REFERENCES submission(`id`),
    CONSTRAINT fk_userid FOREIGN KEY(`userid`) REFERENCES users(`id`) 
) ENGINE = MyISAM;