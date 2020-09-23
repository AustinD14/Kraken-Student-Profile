CREATE DATABASE IF NOT EXISTS `Student_Profile`;
USE Student_Profile;

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