CREATE DATABASE `tz_olkon`;

CREATE USER
    'tz_olkon_user' @'localhost' IDENTIFIED
WITH
    mysql_native_password BY 'tz_olkon_pass';

GRANT
    ALL PRIVILEGES ON tz_olkon.* TO 'tz_olkon_user' @'localhost'
WITH
GRANT OPTION;

FLUSH PRIVILEGES;