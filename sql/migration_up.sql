USE tz_olkon;

CREATE TABLE
    users (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        login VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        session_id VARCHAR(255) NOT NULL DEFAULT '',
        role VARCHAR(20) NOT NULL
    );

CREATE TABLE
    orders (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        param_1 VARCHAR(255) NOT NULL DEFAULT '',
        param_2 VARCHAR(255) NOT NULL DEFAULT '',
        param_3 VARCHAR(255) NOT NULL DEFAULT ''
    );

INSERT INTO
    users (login, password, role)
VALUES ('admin', 'admin', 'admin');

INSERT INTO
    users (login, password, role)
VALUES ('user', 'user', 'user');