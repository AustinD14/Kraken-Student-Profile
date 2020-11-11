CREATE TABLE pre_user (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
urltoken VARCHAR(255) NOT NULL,
mail VARCHAR(255) NOT NULL,
date DATETIME NOT NULL,
flag TINYINT(4) NOT NULL DEFAULT 0
)ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

CREATE TABLE user_datas (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
mail VARCHAR(255) NOT NULL,
status INT(1) NOT NULL DEFAULT 1,
created_at DATETIME,
updated_at DATETIME
role int(11)
)ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;