CREATE DATABASE api_login;

CREATE TABLE api_login.usuarios (
	id SMALLINT PRIMARY KEY NOT NULL,
    username VARCHAR(20) NOT NULL,
    password VARCHAR(20) NOT NULL,
    state TINYINT NOT NULL
);

INSERT INTO usuarios VALUES (1, 'ahc280699', '123456789', 1);