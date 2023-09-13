/* INITIALIZE DATABASE */
CREATE DATABASE IF NOT EXISTS ryan_nguyen_syscbook;

CREATE TABLE users_info (
    student_ID          INT(10)         PRIMARY KEY     AUTO_INCREMENT,
    student_email       VARCHAR(150)    NOT NULL,
    first_name          VARCHAR(150)    NOT NULL,
    last_name           VARCHAR(150)    NOT NULL,
    DOB                 DATE            NOT NULL
) AUTO_INCREMENT=100100;

CREATE TABLE users_program (
    student_ID          INT(10)         PRIMARY KEY,
    Program             VARCHAR(50)     NOT NULL,
    FOREIGN KEY         (student_ID)    REFERENCES      users_info(student_ID)
);

CREATE TABLE users_avatar (
    student_ID          INT(10)         PRIMARY KEY,
    avatar              INT(1)          NULL,
    FOREIGN KEY         (student_ID)    REFERENCES      users_info(student_ID)
);

CREATE TABLE users_address (
    student_ID          INT(10)         PRIMARY KEY,
    street_number       INT(5)          NULL,
    street_name         VARCHAR(150)    NULL,
    city                VARCHAR(30)     NULL,
    provence            VARCHAR(2)      NULL,
    postal_code         VARCHAR(7)      NULL,
    FOREIGN KEY         (student_ID)    REFERENCES      users_info(student_ID)
);

CREATE TABLE users_posts (
    post_ID             INT(100)	 	PRIMARY KEY     AUTO_INCREMENT,
    student_ID          INT(10)         NOT NULL,
    new_post            TEXT            NOT NULL,
    post_date           TIMESTAMP       NOT NULL,
    FOREIGN KEY         (student_ID)    REFERENCES      users_info(student_ID)
) AUTO_INCREMENT=1;

CREATE TABLE users_passwords (
    student_ID          INT(10)         PRIMARY KEY,
    password            VARCHAR(255)    NOT NULL,
    FOREIGN KEY         (student_ID)    REFERENCES      users_info(student_ID)
);

CREATE TABLE users_permissions (
    student_ID          INT(10)         PRIMARY KEY,
    account_type        INT(1)          NOT NULL        DEFAULT 1,
    FOREIGN KEY         (student_ID)    REFERENCES      users_info(student_ID)

);