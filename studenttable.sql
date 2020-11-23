CREATE DATABASE IF NOT EXISTS `Student_Profile`;
USE Student_Profile;

-- REMOVE LATER
DROP TABLE IF EXISTS `users_data`;
CREATE TABLE IF NOT EXISTS `users_data` (
`id` int(11) NOT NULL,
  `user_name` varchar(60) NOT NULL,
  `user_email` varchar(60) NOT NULL
)AUTO_INCREMENT=1 ;

ALTER TABLE `users_data`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `users_data`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
-- 

DROP TABLE IF EXISTS `pre_user`;
CREATE TABLE `pre_user` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`urltoken` VARCHAR(255) NOT NULL,
`mail` VARCHAR(255) NOT NULL,
`date` DATETIME NOT NULL,
`flag` TINYINT(4) NOT NULL DEFAULT 0
)ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;


DROP TABLE IF EXISTS `user_data`;
CREATE TABLE `user_data` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`student_id` INT,
`name` VARCHAR(255) NOT NULL,
`password` VARCHAR(255) NOT NULL,
`mail` VARCHAR(255) NOT NULL,
`birthday` DATE,
`phone_number` INT,
`status` INT(1) NOT NULL DEFAULT 1,
`created_at` DATETIME,
`updated_at` DATETIME,
`role` int(11)
)ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

DROP TABLE IF EXISTS `upimages`;
CREATE TABLE `upimages` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `file_name`  VARCHAR(255) NOT NULL,
  `uploaded_on` DATETIME NOT NULL,
  `status` ENUM('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;