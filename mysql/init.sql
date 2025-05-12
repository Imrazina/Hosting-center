-- Создание базы данных для Pure-FTPd
CREATE DATABASE IF NOT EXISTS pureftpd;

-- Удаление и создание пользователя для Pure-FTPd
DROP USER IF EXISTS 'pureftpd'@'%';
CREATE USER 'pureftpd'@'%' IDENTIFIED BY 'ftp_password';

-- Выдача прав доступа к БД pureftpd (SELECT, INSERT, UPDATE нужны Pure-FTPd)
GRANT ALL PRIVILEGES ON pureftpd.* TO 'pureftpd'@'%';
FLUSH PRIVILEGES;

-- Создание таблицы пользователей FTP
USE pureftpd;

CREATE TABLE IF NOT EXISTS ftp_users (
                                         username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    uid INT NOT NULL DEFAULT 1000,
    gid INT NOT NULL DEFAULT 1000,
    dir VARCHAR(255) NOT NULL,
    status TINYINT(1) DEFAULT 1,
    PRIMARY KEY (username)
    );

-- Создание основной базы данных хостинга
CREATE DATABASE IF NOT EXISTS hosting_db;
USE hosting_db;

-- Таблица для управления доменами и привязками
CREATE TABLE IF NOT EXISTS domains (
                                       id INT AUTO_INCREMENT PRIMARY KEY,
                                       email VARCHAR(255) NOT NULL,
    domain VARCHAR(255) NOT NULL,
    ftp_username VARCHAR(50) NOT NULL,
    ftp_password VARCHAR(50) NOT NULL,
    db_username VARCHAR(50) NOT NULL,
    db_password VARCHAR(50) NOT NULL,
    db_name VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_domain (domain)
    );

-- Удаление и создание пользователя для основной БД
DROP USER IF EXISTS 'hosting_user'@'%';
CREATE USER 'hosting_user'@'%' IDENTIFIED BY 'hosting_password';
GRANT ALL PRIVILEGES ON hosting_db.* TO 'hosting_user'@'%';
FLUSH PRIVILEGES;
