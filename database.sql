CREATE DATABASE IF NOT EXISTS laravel_master;
USE laravel_master;

CREATE TABLE IF NOT EXISTS users(
 id              int(255) auto_increment not null,
 role            varchar(20),
 name            varchar(100),
 surname         varchar(200),
 nick            varchar(100),
 email           varchar(255),
 password        varchar(255),
 image           varchar(255),
 created_at      datetime,
 updated_at      datetime,
 remember_token  varchar(255), 
 CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;


INSERT INTO users VALUES(null, 'user','Desi','Salazar', 'DesiDev','desi@desi.com','1234',null, CURTIME(), CURTIME(),null);

INSERT INTO users VALUES(null, 'user','Juan','Lopez', 'Juapi','juan@juan.com','1234',null, CURTIME(), CURTIME(),null);

INSERT INTO users VALUES(null, 'user','Manolo','Garcia', 'Manolin','manolo@garcia.com','1234',null, CURTIME(), CURTIME(),null);

CREATE TABLE IF NOT EXISTS images(
id             int(255) auto_increment not null,
user_id        int(255), 
imagen_path    varchar(255),
description    text,
created_at     datetime,
updated_at     datetime,
CONSTRAINT pk_images PRIMARY KEY(id),
CONSTRAINT fk_images_users FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;

INSERT INTO images VALUES(null, 1, 'test.jpg', 'descripción de prueba', CURTIME(), CURTIME());

INSERT INTO images VALUES(null, 1, 'playa.jpg', 'descripción de playa', CURTIME(), CURTIME());

INSERT INTO images VALUES(null, 1, 'bosque.jpg', 'descripción de bosque', CURTIME(), CURTIME());

INSERT INTO images VALUES(null, 2, 'arcoiris.jpg', 'descripción de arcoiris', CURTIME(), CURTIME());



CREATE TABLE IF NOT EXISTS comments(
id             int(255) auto_increment not null,
user_id        int(255), 
image_id       int(255),
content        text,
created_at     datetime,
updated_at     datetime,
CONSTRAINT pk_comments PRIMARY KEY(id),
CONSTRAINT fk_comments_users FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_comments_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb;

INSERT INTO comments VALUES(null, 1, 4, 'Bonita foto del arcoiris', CURTIME(), CURTIME());

INSERT INTO comments VALUES(null, 2, 1, 'Bonita foto de Playa en familia', CURTIME(), CURTIME());

INSERT INTO comments VALUES(null, 2, 4, 'Es mi mejor foto hasta el momento', CURTIME(), CURTIME());

CREATE TABLE IF NOT EXISTS likes(
id             int(255) auto_increment not null,
user_id        int(255), 
image_id       int(255),
created_at     datetime,
updated_at     datetime,
CONSTRAINT pk_likes PRIMARY KEY(id),
CONSTRAINT fk_likes_users FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_likes_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb;

INSERT INTO likes VALUES(null, 1, 4, CURTIME(), CURTIME());

INSERT INTO likes VALUES(null, 2, 1, CURTIME(), CURTIME());

INSERT INTO likes VALUES(null, 3, 1, CURTIME(), CURTIME());

INSERT INTO likes VALUES(null, 2, 4, CURTIME(), CURTIME());

INSERT INTO likes VALUES(null, 3, 4, CURTIME(), CURTIME());